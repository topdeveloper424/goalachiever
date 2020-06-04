@extends('layout.app')

@section('title')
    Sponsor Order List
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
                                <h4 class="card-title">Sponsor Orders List Table</h4>
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
                                    <th>Item List</th>
                                    <th>Main Order</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <?php
                                            $purchaser_id = "GA" . str_pad($order->purchaser_id, 6, "0", STR_PAD_LEFT);
                                            $member_id = "GA" . str_pad($order->member_id, 6, "0", STR_PAD_LEFT);
                                            $item_number = $order->proceeds()->count();
                                        ?>
                                        <td>{{$member_id}}</td>
                                        <td>{{$purchaser_id}}</td>
                                        <td>{{$order->order_number}}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->order_date)->format('m/d/Y h:i:s A')}}</td>
                                        <td>{{ $item_number }}</td>
                                        <td>
                                            <a href="{{route('sponsor_proceed_list_page',['id'=>$order->id])}}" target="_blank">
                                                <button class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Go to proceeds list page"><i class="ft-server mr-2"></i>View Items</button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('sponsor_main_order_page',['id'=>$order->id])}}" target="_blank">
                                                <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Go to this main purchase order page"><i class="ft-shopping-cart mr-2"></i>Main Orders</button>
                                            </a>
                                        </td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
        });

    </script>
@endsection