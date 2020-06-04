@extends('layout.app')
@section('title')
    User List (Personal Goal)
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
                                <h4 class="card-title badge badge-danger badge-pill">Users Table (Personal Goal)
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title text-right" style="color: #1ba7aa;font-weight: bold;" id="typeLabel">{{$goal_types[0]->name}}
                                </h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-content ">
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
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Time Created</th>
                                                <th>Create/Edit</th>
                                                <th>Remove</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <?php
                                                $goal = \App\PersonalGoal::where('user',$user->id)->where('type',$goal_type->id)->get();
                                                $created = null;
                                                if (count($goal) > 0){
                                                    $created = $goal[0]->created_at;
                                                }
                                                $created_at = "";
                                                if ($created){
                                                    $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$goal[0]->created_at)->format('m/d/Y h:i:s A');
                                                }
                                                ?>
                                                <tr>
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>{{$created_at}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-raised btn-primary btn-sm btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Go to page for creating/editing" onclick="gotoPage({{$user->id}},{{$goal_type->id}})"><i class="ft-play mr-2"></i>Go To Page</button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-raised btn-danger btn-sm btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Remove this goal" onclick="removeOne({{$user->id}},{{$goal_type->id}})"><i class="ft-trash-2 mr-2"></i>Remove</button>
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
            $('table').DataTable();
        });

        function gotoPage(id,type) {
            window.open("personal?id="+id+"&type="+type);
        }
        function changeType(type) {
            $("#typeLabel").html(type);
        }
        function removeOne(id,type) {
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
                    $.post("{{route('remove_personal')}}",{
                        _token:'{{csrf_token()}}',
                        user:id,
                        type:type,
                    }).done(
                        function (data) {
                            document.location.reload(true);
                        }
                    );
                }
            }).catch(swal.noop);
        }

    </script>
@endsection