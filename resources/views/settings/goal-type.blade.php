@extends('layout.app')
@section('title')
    Goal Types
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title badge badge-danger badge-pill">&nbsp;Goal Types ( {{count($types)}} )&nbsp;</h4>
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title text-right" style="color: #1ba7aa;font-weight: bold;" id="typeLabel">Financial Goal</h4>

                            </div>
                        </div>
                    </div>
                    <div class="card-content mt-2">
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1"
                                       aria-expanded="true" onclick="changeType('Financial Goal')">Financial Goal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2"
                                       aria-expanded="true" onclick="changeType('Educational Goal')">Educational Goal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3"
                                       aria-expanded="true" onclick="changeType('Career Goal')">Career Goal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4"
                                       aria-expanded="true" onclick="changeType('Personal Goal')">Personal Goal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab5" href="#tab5"
                                       aria-expanded="true" onclick="changeType('Weight Loss Goal')">Weight Loss Goal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab6" data-toggle="tab" aria-controls="tab6" href="#tab6"
                                       aria-expanded="true" onclick="changeType('Vacation Goal')">Vacation Goal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab7" data-toggle="tab" aria-controls="tab7" href="#tab7"
                                       aria-expanded="true" onclick="changeType('Life Insurance')">Life Insurance</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab8" data-toggle="tab" aria-controls="tab8" href="#tab8"
                                       aria-expanded="true" onclick="changeType('Retirement')">Retirement</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab9" data-toggle="tab" aria-controls="tab9" href="#tab9"
                                       aria-expanded="true" onclick="changeType('RE Purchase')">RE Purchase</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab10" data-toggle="tab" aria-controls="tab10" href="#tab10"
                                       aria-expanded="true" onclick="changeType('RE Listing')">RE Listing</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab11" data-toggle="tab" aria-controls="tab11" href="#tab11"
                                       aria-expanded="true" onclick="changeType('Mortgage Loan')">Mortgage Loan</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1 mt-2">
                                <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(0)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 0)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab2" aria-expanded="true" aria-labelledby="base-tab2">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(1)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 1)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab3" aria-expanded="true" aria-labelledby="base-tab3">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(2)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 2)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab4" aria-expanded="true" aria-labelledby="base-tab4">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(3)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 3)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab5" aria-expanded="true" aria-labelledby="base-tab5">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(4)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 4)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab6" aria-expanded="true" aria-labelledby="base-tab6">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(5)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 5)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab7" aria-expanded="true" aria-labelledby="base-tab7">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(6)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 6)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab8" aria-expanded="true" aria-labelledby="base-tab8">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(7)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 7)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab9" aria-expanded="true" aria-labelledby="base-tab9">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(8)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 8)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="tab10" aria-expanded="true" aria-labelledby="base-tab10">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(9)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 9)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="tab11" aria-expanded="true" aria-labelledby="base-tab11">
                                    <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Add new goal type" onclick="addType(10)" style="float: right"><i class="ft-plus mr-1"></i>Add New Type</button>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $type)
                                            @if($type->goal == 10)
                                                <tr>
                                                    <td>{{$type->name}}</td>
                                                    <td>
                                                        <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Click this button to edit this goal type" onclick="editType({{$type->id}})">
                                                            <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                                        </a>
                                                        <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Click this button to remove this goal type" onclick="removeType({{$type->id}})">
                                                            <i class="ft-trash font-medium-3 mr-2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-user-check"></i> New Goal Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('prod_goal_type')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="goal" name="goal">
                        <input type="hidden" name="mode" value="0">
                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-lock"></i> Enter Goal Type Name</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">New Goal Type</label>
                                        <input type="text" id="newType" class="form-control" name="name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-user-check"></i> Edit Goal Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('prod_goal_type')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="cur_id" name="cur_id">
                        <input type="hidden" name="mode" value="1">
                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-lock"></i> Enter Goal Type Name</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">New Goal Type</label>
                                        <input type="text" id="editType" class="form-control" name="name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Save changes</button>
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


    <script>

        $(document).ready(function () {
            $('.file-export').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('.alert-success').fadeIn().delay(5000).fadeOut();

        });

        function addType(goal) {

            $("#goal").val(goal);
            $("#newType").val("");
            $("#addModal").modal('show');
        }

        function editType(id) {
            $("#cur_id").val(id);
            $("#editType").val("");
            $.ajax({
                type: "get",
                url: '{{route('get_goal_type')}}',
                data: {
                    id: id
                },
                success: function (data) {
                    console.log(data);
                    var jsondata = JSON.parse(data);
                    $("#editType").val(jsondata.name);
                    $("#editModal").modal('show');
                }
            });

        }

        function removeType(id) {
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
                        url: '{{route('remove_goal_type')}}',
                        data: {
                            _token:'{{csrf_token()}}',
                            id: id
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

    </script>
@endsection