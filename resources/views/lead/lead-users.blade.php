@extends('layout.app')
@section('title')
    @if($mode == 0)
        User List (Leads For Insurance)
    @else
        User List (Leads For Retirement)
    @endif
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickadate/pickadate.css')}}">
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
                                <h4 class="card-title badge badge-danger badge-pill">Users Table ( Leads For @if($mode == 0) Insurance @else Retirement @endif )</h4>
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title text-right" style="color: #1ba7aa;font-weight: bold;" id="typeLabel">{{$goal_types[0]->name}}
                                </h4>
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
                    </div>

                    <input type="hidden" value="{{$mode}}" id="mode">

                    <div class="card-content">
                        <div class="card-body card-dashboard table-responsive">
                            <ul class="nav nav-tabs">
                                @foreach($goal_types as $goal_type)
                                    <li class="nav-item">
                                        <a class="nav-link @if($loop->iteration == 1) active @endif" id="base-tab{{$goal_type->id}}" data-toggle="tab" aria-controls="tab{{$goal_type->id}}" href="#tab{{$goal_type->id}}"
                                           aria-expanded="true" onclick="changeType('{{$goal_type->name}}')">{{$goal_type->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                @foreach($goal_types as $goal_type)
                                    <div role="tabpanel" class="tab-pane @if($loop->iteration == 1) active @endif" id="tab{{$goal_type->id}}" aria-expanded="true" aria-labelledby="base-tab{{$goal_type->id}}">
                                        <div class="row mt-2">
                                            <div class="col-md-12 text-right">
                                                <button class="btn btn-info mr-4" data-toggle="tooltip" data-placement="top" title="Click this button to export leads as CSV" onclick="exportCSV({{$goal_type->id}})"><i class="ft-save mr-1"></i>Export As CSV</button>
                                            </div>
                                        </div>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Time Created</th>
                                                <th>View Detail</th>
                                                <th>Remove</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($leads as $lead)
                                                <?php
                                                        $user = \App\User::find($lead->user);
                                                        $user_name = '';
                                                        $user_email = '';
                                                        if ($user){
                                                            $user_name = $user->name;
                                                            $user_email = $user->email;
                                                        }
                                                    $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$lead->created_at)->format('m/d/Y h:i:s A');
                                                ?>
                                                <tr>
                                                    <td>{{$user_name}}</td>
                                                    <td>{{$user_email}}</td>
                                                    <td>{{$created_at}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-raised btn-primary btn-sm btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Edit this lead" onclick="showDetail({{$lead->id}})"><i class="ft-file-text mr-2"></i>View</button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-raised btn-danger btn-sm btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Remove this lead" onclick="removeOne({{$lead->id}})"><i class="ft-trash-2 mr-2"></i>Remove</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade text-left" id="leadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-bell"></i> Lead</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form">
                    <div class="modal-body">

                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-mail"></i> Lead Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leadName">Name</label>
                                        <input type="text" id="leadName" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leadAge">Age</label>
                                        <input type="number" id="leadAge" min="1" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leadContact">Contact</label>
                                        <input type="text" id="leadContact" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leadEmail">Email</label>
                                        <input type="email" id="leadEmail" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="leadText">Text</label>
                                        <textarea type="text" id="leadText" class="form-control" name="text" readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="leadType">Goal Type</label>
                                        <input type="text" id="leadType" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>

                </form>
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
    <script src="{{asset('app-assets/vendors/js/pickadate/picker.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/pickadate/picker.date.js')}}" type="text/javascript"></script>

    <script>

        $(document).ready(function () {
            $('table').DataTable();

        });

        function showDetail(id) {
            $.ajax({
                type: "get",
                url: "{{route('get_lead_detail')}}",
                data: {
                    id: id,
                },
                success: function (data) {
                    console.log(data);
                    var jsondata = JSON.parse(data);
                    $("#leadName").val(jsondata['name']);
                    $("#leadText").val(jsondata['text']);
                    $("#leadAge").val(jsondata['age']);
                    $("#leadEmail").val(jsondata['email']);

                    $("#leadContact").val(jsondata['contact']);
                    $("#leadType").val(jsondata['type_name']);
                    $("#leadModal").modal('show');

                }
            });


        }

        function removeOne(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Yes',
                cancelButtonText: "No, cancel"
            }).then(function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{route('remove_lead')}}",
                        data: {
                            _token:'{{csrf_token()}}',
                            id: id,
                        },
                        success: function (data) {
                            document.location.reload(true);
                        }
                    });
                }
            }).catch(swal.noop);
        }


        function changeType(type) {
            $("#typeLabel").html(type);
        }

        function onFilter() {
            var from_date = $("#picker_from").val();
            var to_date = $("#picker_to").val();

            var mode = $("#mode").val();
            var url = "";
            if (mode == 0){
                url = "{{route('insurance_lead_list_page')}}?";
            }else{
                url = "{{route('retirement_lead_list_page')}}?";
            }
            if (from_date != ""){
                url += "from_date="+from_date+"&";
            }
            if (to_date != ""){
                url += "to_date="+to_date;
            }
            document.location.href = url;
        }

        function exportCSV(type) {
            var from_date = $("#picker_from").val();
            var to_date = $("#picker_to").val();

            var mode = $("#mode").val();

            var url = "{{route('export_csv')}}?mode="+mode+"&type="+type+"&";
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