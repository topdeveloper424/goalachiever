@extends('layout.app')
@section('title')
    <?php $goal_name = "";
    if($mode == 0){
        $goal_name = "Goal Report";
    }else{
        $goal_name = "Goal Booster";
    }
    ?>
    User List ({{$goal_name}})
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
                        <h4 class="card-title badge badge-danger badge-pill">Users Table ({{$goal_name}})
                        </h4>
                    </div>
                    <div class="card-content ">
                        <div class="card-body card-dashboard table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    @if($mode == 0)
                                        <th>Create Reports</th>
                                    @else
                                        <th>Time Created</th>
                                        <th>Create/Edit</th>
                                    @endif

                                    @if($mode != 0)
                                    <th>Remove</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <?php
                                            $goal = null;
                                            if ($mode == 1){
                                                $goal = \App\GoalBooster::where('user',$user->id)->get();
                                            }
                                            $created = null;
                                            if ($goal && count($goal) > 0){
                                                $created = $goal[0]->created_at;
                                            }
                                            $created_at = "";
                                            if ($created){
                                                $created_at = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$created)->format('m/d/Y h:i:s A');
                                            }
                                    ?>
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        @if($mode != 0)
                                        <td>{{$created_at}}</td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-raised btn-primary btn-sm btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Go to page" onclick="gotoPage({{$mode}},{{$user->id}})"><i class="ft-play mr-2"></i>Go To Page</button>
                                        </td>
                                        @if($mode != 0)
                                        <td>
                                            <button type="button" class="btn btn-raised btn-danger btn-sm btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Remove this goal" onclick="removeOne({{$user->id}})"><i class="ft-trash-2 mr-2"></i>Remove</button>
                                        </td>
                                        @endif
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
            $('table').DataTable();
        });

        function gotoPage(mode,id) {
            if (mode == 0){
                window.open("goal-report?id="+id);
            } else{
                window.open("goal-booster?id="+id);
            }
        }

        function removeOne(id) {
            var url = "{{route('remove_booster')}}";
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
                    $.post(url,{
                        _token:'{{csrf_token()}}',
                        user:id,
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