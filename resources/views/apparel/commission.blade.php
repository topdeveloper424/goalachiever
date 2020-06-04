@extends('layout.app')

@section('title')
    Goal Booster Commissions
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/sweetalert2.min.css')}}">
@endsection

@section('content')
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mb-2" role="alert">
                <strong>{{$error}}</strong>
            </div>
        @endforeach
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success mb-2" role="alert">
            <strong>{{$message}}</strong>
        </div>
    @endif

    <div class="content-wrapper"><!--Statistics cards Starts-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Apparel Commissions Table</h4>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-5 mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <span class="fa fa-calendar-o"></span>
                                                    </span>
                                                </div>
                                                <input id="picker_from" name="from_date" class="form-control datepicker" type="date" value="{{ app('request')->input('from_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <span class="fa fa-calendar-o"></span>
                                                    </span>
                                                </div>
                                                <input id="picker_to" name="to_date" class="form-control datepicker" type="date" value="{{ app('request')->input('to_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <button class="btn btn-success mr-4" data-toggle="tooltip" data-placement="top" title="Click this button to filter leads by date" onclick="onFilter()"><i class="ft-search mr-1"></i>Filter</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title text-right" style="color: #1ba7aa;font-weight: bold;" id="ytd_label"></h4>
                            </div>
                        </div>

                    </div>
                    <div class="card-content ">
                        <div class="card-body card-dashboard table-responsive">
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                <tr>
                                    <th>Benefit Member ID</th>
                                    <th>Purchaser ID</th>
                                    <th>Purchase Order #</th>
                                    <th>Purchase Order Date</th>
                                    <th>Number Of Items </th>
                                    <th>Total Commission</th>
                                    <th>Item List</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $ytd_comm = 0;
                                ?>
                                @foreach($orders as $order)
                                    <tr>
                                        <?php
                                            $purchaser_id = "GA" . str_pad($order->purchaser_id, 6, "0", STR_PAD_LEFT);
                                            $member_id = "GA" . str_pad($order->member_id, 6, "0", STR_PAD_LEFT);
                                            $item_number = $order->proceeds()->count();
                                            $total_net = 0;
                                            foreach ($order->proceeds() as $proceed){
                                                $item = \App\ApparelItem::find($proceed->item_id);
                                                $total_net += $item->total_net_profit*$item->member/100;
                                            }
                                            $ytd_comm += $total_net;

                                        ?>
                                        <td>{{$member_id}}</td>
                                        <td>{{$purchaser_id}}</td>
                                        <td>{{$order->order_number}}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->order_date)->format('m/d/Y h:i:s A')}}</td>
                                        <td>{{ $item_number }}</td>
                                        <td>$ {{ number_format($total_net,2) }}</td>
                                        <td>
                                            <a href="{{route('apparel_proceed_list_page',['id'=>$order->id])}}" target="_blank">
                                                <button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Go to proceeds list page"><i class="ft-server mr-2"></i>View Items</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <input type="hidden" id="total_ytd" value="{{round($ytd_comm,2)}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script src="{{asset('app-assets/vendors/js/datatable/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/dataTables.buttons.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/buttons.flash.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/jszip.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/pdfmake.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/vfs_fonts.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/buttons.html5.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/datatable/buttons.print.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/components-modal.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/sweetalert2.min.js')}}" type="text/javascript"></script>


    <script>

        $(document).ready(function () {
            $('.file-export').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-outline-primary mr-1');
            var ytd = $("#total_ytd").val();
            var htm = "YTD Commission : $" + Number(ytd).toFixed(2);

            $("#ytd_label").html(htm);
        });

        function onFilter() {
            var from_date = $("#picker_from").val();
            var to_date = $("#picker_to").val();

            var url = "{{route('apparel_comm_page')}}?";
            if (from_date != ""){
                url += "from_date="+from_date+"&";
            }
            if (to_date != ""){
                url += "to_date="+to_date;
            }
            document.location.href = url;
        }


    </script>
@endsection