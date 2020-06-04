@extends('layout.app')
@section('title')
    Participant
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
                                <h4 class="card-title">School Participants Table</h4>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float: right" class="btn btn-raised btn-danger btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Add new contact" onclick="addNew()">ADD NEW<i class="fa ft-user-plus ml-2"></i></button>
                            </div>

                        </div>
                    </div>
                    <div class="card-content ">
                        <div class="card-body card-dashboard table-responsive">
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Contact #</th>
                                    <th>Website</th>
                                    <th>Email</th>
                                    <th>Contact Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($participants as $participant)
                                    <tr>
                                        <td>{{$participant->name}}</td>
                                        <td>{{$participant->phone}}</td>
                                        <td>{{$participant->website}}</td>
                                        <td>{{ $participant->email }}</td>
                                        <td>{{ $participant->contact_name }}</td>
                                        <td>
                                            <a class="success p-0" data-toggle="tooltip" data-placement="top" title="Edit this contact"  onclick="editOne({{$participant->id}})">
                                                <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                            </a>
                                            <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Remove this contact"  onclick="removeOne({{$participant->id}})">
                                                <i class="ft-trash font-medium-3 mr-2"></i>
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
    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-user-plus"></i> Add New Vendor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('save_contact')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="mode" value="0">
                        <input type="hidden" name="type" value="2">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_name">Company Name</label>
                                        <input type="text" id="new_name" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_phone">Contact #</label>
                                        <input type="text" id="new_phone" class="form-control" name="phone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_website">Website</label>
                                        <input type="text" id="new_website" class="form-control" name="website" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_email">Email</label>
                                        <input type="email" id="new_email" class="form-control" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_contact_name">Contact Name</label>
                                        <input type="text" id="new_contact_name" class="form-control" name="contact_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_address">Address</label>
                                        <input type="text" id="new_address" class="form-control" name="address" required>
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
                <div class="modal-header bg-success white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-user-check"></i> User Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('save_contact')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="mode" value="1">
                        <input type="hidden" name="type" value="0">
                        <input type="hidden" name="cur_contact" id="cur_contact" value="">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Company Name</label>
                                        <input type="text" id="name" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Contact #</label>
                                        <input type="text" id="phone" class="form-control" name="phone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="text" id="website" class="form-control" name="website" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" class="form-control" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ontact_name">Contact Name</label>
                                        <input type="text" id="contact_name" class="form-control" name="contact_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" id="address" class="form-control" name="address" required>
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
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-outline-primary mr-1');
        });
        
        function addNew() {
            $("#new_name").val("");
            $("#new_phone").val("");
            $("#new_website").val("");
            $("#new_email").val("");
            $("#new_contact_name").val("");
            $("#new_address").val("");
            $('#addModal').modal('show');

        }

        function editOne(id) {
            $("#name").val("");
            $("#phone").val("");
            $("#website").val("");
            $("#email").val("");
            $("#contact_name").val("");
            $("#address").val("");
            $("#cur_contact").val(id);
            $.ajax({
                type: "get",
                url: '{{route('get_contact')}}',
                data: {
                    id: id
                },
                success: function (data) {
                    console.log(data);
                    var jsondata = JSON.parse(data);
                    $("#name").val(jsondata.name);
                    $("#phone").val(jsondata.phone);
                    $("#website").val(jsondata.website);
                    $("#email").val(jsondata.email);
                    $("#contact_name").val(jsondata.contact_name);
                    $("#address").val(jsondata.address);
                    $("#editModal").modal('show');
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
                    $.post("{{route('remove_contact')}}",{
                        _token:'{{csrf_token()}}',
                        id:id,
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