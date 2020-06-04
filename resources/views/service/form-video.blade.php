@extends('layout.app')
@section('title')
    Form/Video Page
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
                        <h4 class="card-title">Forms Uploads/Forms Downloads/Videos</h4>
                        <p>Please upload/download forms/videos</p>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link tab-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1"
                                       aria-expanded="true">Forms Upload</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2"
                                       aria-expanded="false">Forms Download</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab-link" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" aria-expanded="false">Videos Upload</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab-link" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" aria-expanded="false">Videos Download</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-primary" onclick="uploadForm()"><i class="fa ft-upload-cloud mr-1"></i>Upload New Form</button>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Form Name</th>
                                                    <th width="25%">Created At</th>
                                                    <th width="20%">Uploaded By</th>
                                                    <th width="15%">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($forms as $form)
                                                    <?php $user = \App\User::find($form->uploaded_by); ?>
                                                    <tr>
                                                        <td>{{$form->name}}</td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$form->created_at)->format('m/d/Y h:i:s A')}}</td>
                                                        <td>@if($user) {{$user->name}} @endif</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Edit this form name" onclick="editForm({{$form->id}})"><i class="fa ft-edit"></i></button>
                                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Remove this form" onclick="removeForm({{$form->id}})"><i class="fa ft-trash-2"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">&nbsp;</div>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Form Name</th>
                                                    <th width="25%">Created At</th>
                                                    <th width="25%">Uploaded By</th>
                                                    <th width="10%">Download</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($forms as $form)
                                                    <?php $user = \App\User::find($form->uploaded_by); ?>
                                                    <tr>
                                                        <td>{{$form->name}}</td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$form->created_at)->format('m/d/Y h:i:s A')}}</td>
                                                        <td>@if($user) {{$user->name}} @endif</td>
                                                        <td>
                                                            <a href="{{route('download_form_video')}}?id={{$form->id}}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="download this form" download><i class="fa ft-download-cloud"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab3" aria-labelledby="base-tab3">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-primary" onclick="uploadVideo()"><i class="fa ft-upload-cloud mr-1"></i>Upload New Video</button>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Video Name</th>
                                                    <th width="25%">Created At</th>
                                                    <th width="20%">Uploaded By</th>
                                                    <th width="15%">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($videos as $video)
                                                    <?php $user = \App\User::find($video->uploaded_by); ?>
                                                    <tr>
                                                        <td>{{$video->name}}</td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$video->created_at)->format('m/d/Y h:i:s A')}}</td>
                                                        <td>@if($user) {{$user->name}} @endif</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Edit this video" onclick="editVideo({{$video->id}})"><i class="fa ft-edit"></i></button>
                                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Remove this video" onclick="removeForm({{$video->id}})"><i class="fa ft-trash-2"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab4" aria-labelledby="base-tab4">
                                    <div class="row">
                                        <div class="col-md-12 mt-2">&nbsp;</div>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th width="40%">Video Name</th>
                                                    <th width="25%">Created At</th>
                                                    <th width="25%">Uploaded By</th>
                                                    <th width="10%">Download</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($videos as $video)
                                                    <?php $user = \App\User::find($video->uploaded_by); ?>
                                                    <tr>
                                                        <td>{{$video->name}}</td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$video->created_at)->format('m/d/Y h:i:s A')}}</td>
                                                        <td>@if($user) {{$user->name}} @endif</td>
                                                        <td>
                                                            <a href="{{route('download_form_video')}}?id={{$video->id}}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Download this video" download><i class="fa ft-download-cloud"></i></a>
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
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade text-left" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-file-o"></i> Form Upload</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('upload_form_video')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" name="type" value="0">
                            <input type="hidden" name="mode" value="0">
                            <h4 class="form-section"><i class="fa fa-list-alt"></i> Form Details</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="formName">Form Name</label>
                                        <input type="text" id="formName" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="formFile">Upload Form</label>
                                        <input type="file" id="formFile" name="file" class="form-control" accept=".pdf,.doc,.docx,.xml,.csv,.xls,.xlsx,.ppt,.pptx" required>
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


    <div class="modal fade text-left" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-file-o"></i> Form Upload</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('upload_form_video')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" name="type" value="0">
                            <input type="hidden" name="mode" value="1">
                            <input type="hidden" name="currentID" id="currentFormID">
                            <h4 class="form-section"><i class="fa fa-list-alt"></i> Form Details</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editFormName">Form Name</label>
                                        <input type="text" id="editFormName" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editFormCurrent">File Name</label>
                                        <input type="text" id="editFormCurrent" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editFormFile">Upload Form</label>
                                        <input type="file" id="editFormFile" name="file" class="form-control" accept=".pdf,.doc,.docx,.xml,.csv,.xls,.xlsx,.ppt,.pptx">
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



    <div class="modal fade text-left" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-file-o"></i> Video Upload</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('upload_form_video')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" name="type" value="1">
                            <input type="hidden" name="mode" value="0">
                            <h4 class="form-section"><i class="fa fa-list-alt"></i> Video Details</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="videoName">Video Name</label>
                                        <input type="text" id="videoName" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="videoFile">Upload Video</label>
                                        <input type="file" id="videoFile" name="file" class="form-control" accept=".mp4,.mp3,.avi" required>
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


    <div class="modal fade text-left" id="editVideoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-file-o"></i> Video Upload</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('upload_form_video')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" name="type" value="1">
                            <input type="hidden" name="mode" value="1">
                            <input type="hidden" name="currentID" id="currentVideoID">
                            <h4 class="form-section"><i class="fa fa-list-alt"></i> Video Details</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editVideoName">Video Name</label>
                                        <input type="text" id="editVideoName" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editVideoCurrent">File Name</label>
                                        <input type="text" id="editVideoCurrent" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editVideoFile">Upload Video</label>
                                        <input type="file" id="editVideoFile" name="file" class="form-control" accept=".mp4,.mp3,.avi">
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
            $(".tab-link").each(function(i){
                $(this).click(function(e){
                    var tab_id = $('.tab-link')[i].id;
                    tab_id = tab_id.replace("base-","");
                    window.location.hash  = tab_id;
                });
            });

            var url = window.location.href;
            if (url.indexOf("#") != -1){
                var activeTab = url.substring(url.indexOf("#") + 1);
                $(".tab-link").removeClass("active");
                $(".tab-pane").removeClass("active");
                $("#base-" + activeTab).addClass("active");
                $("#" + activeTab).addClass("active");
            }

        });

        function uploadForm() {
            $("#formName").val();
            $("#formFile").val();
            $("#formModal").modal('show');
        }
        
        function editForm(id) {
            $.post("{{route('get_form_video')}}",{
                _token:'{{csrf_token()}}',
                id:id,
            }).done(
                function (data) {
                    var jsonData = JSON.parse(data);
                    $("#currentFormID").val(jsonData.id);
                    $("#editFormName").val(jsonData.name);
                    $("#editFormCurrent").val(jsonData.original_name);
                    $("#editFormFile").val("");
                    console.log(data);
                    $("#editFormModal").modal('show');
                }
            );
        }

        function uploadVideo() {
            $("#videoName").val();
            $("#videoFile").val();
            $("#videoModal").modal('show');
        }

        function editVideo(id) {
            $.post("{{route('get_form_video')}}",{
                _token:'{{csrf_token()}}',
                id:id,
            }).done(
                function (data) {
                    var jsonData = JSON.parse(data);
                    $("#currentVideoID").val(jsonData.id);
                    $("#editVideoName").val(jsonData.name);
                    $("#editVideoCurrent").val(jsonData.original_name);
                    $("#editVideoFile").val("");
                    console.log(data);
                    $("#editVideoModal").modal('show');
                }
            );
        }

        function removeForm(id) {
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
                    $.post("{{route('remove_form_video')}}",{
                        _token:'{{csrf_token()}}',
                        id:id,
                    }).done(
                        function (data) {
                            document.location.reload(true);
                        }
                    );
                }
            });

        }


    </script>
@endsection