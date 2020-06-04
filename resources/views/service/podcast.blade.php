@extends('layout.app')
@section('title')
    Podcast Page
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
                        <h4 class="card-title">Podcasts</h4>
                        <p>Member can download interviews</p>
                        <input type="hidden" id="currentURL" value="{{route('podcast_page')}}">
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active tab-link" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1"
                                       aria-expanded="true">Upload</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2"
                                       aria-expanded="false">Download</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-primary" onclick="uploadCast()"><i class="fa ft-upload-cloud mr-1"></i>Upload New Podcast</button>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th width="25%">Podcast Name</th>
                                                    <th width="25%">Podcast type</th>
                                                    <th width="25%">Created At</th>
                                                    <th width="20%">Uploaded By</th>
                                                    <th width="5%">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($casts as $cast)
                                                    <?php $user = \App\User::find($cast->uploaded_by); ?>
                                                    <tr>
                                                        <td>{{$cast->name}}</td>
                                                        <td>
                                                            @if($cast->type == 2)
                                                                Inspiring Stories
                                                            @elseif($cast->type == 3)
                                                                Educator School Talk
                                                            @elseif($cast->type == 4)
                                                                Veteran Talk
                                                            @elseif($cast->type == 5)
                                                                Financial Talk
                                                            @elseif($cast->type == 6)
                                                                Real Talk
                                                            @elseif($cast->type == 7)
                                                                Entrepreneurs Talk
                                                            @endif

                                                        </td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$cast->created_at)->format('m/d/Y h:i:s A')}}</td>
                                                        <td>@if($user) {{$user->name}} @endif</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Edit this form name" onclick="editCast({{$cast->id}})"><i class="fa ft-edit"></i></button>
                                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Remove this form" onclick="removeCast({{$cast->id}})"><i class="fa ft-trash-2"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                                    <div class="row mt-2">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="startDate">Start Date Name</label>
                                                <input type="date" id="start_date" name="start_date" class="form-control" value="{{app('request')->input('start_date')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="endDate">End Date Name</label>
                                                <input type="date" id="end_date" name="end_date" class="form-control" value="{{app('request')->input('end_date')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="filterButton">&nbsp;</label><br>
                                                <button class="btn btn-success" id="filterButton" onclick="onFilter()"><i class="ft-filter mr-1"></i>Filter</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered file-export">
                                                <thead>
                                                <tr>
                                                    <th width="25%">Podcast Name</th>
                                                    <th width="25%">Podcast type</th>
                                                    <th width="25%">Created At</th>
                                                    <th width="20%">Uploaded By</th>
                                                    <th width="5%">Download</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($casts as $cast)
                                                    <?php $user = \App\User::find($cast->uploaded_by); ?>
                                                    <tr>
                                                        <td>{{$cast->name}}</td>
                                                        <td>
                                                            @if($cast->type == 2)
                                                                Inspiring Stories
                                                            @elseif($cast->type == 3)
                                                                Educator School Talk
                                                            @elseif($cast->type == 4)
                                                                Veteran Talk
                                                            @elseif($cast->type == 5)
                                                                Financial Talk
                                                            @elseif($cast->type == 6)
                                                                Real Talk
                                                            @elseif($cast->type == 7)
                                                                Entrepreneurs Talk
                                                            @endif

                                                        </td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$cast->created_at)->format('m/d/Y h:i:s A')}}</td>
                                                        <td>@if($user) {{$user->name}} @endif</td>
                                                        <td>
                                                            <a href="{{route('download_form_video')}}?id={{$cast->id}}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="download this form" download><i class="fa ft-download-cloud"></i></a>
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


    <div class="modal fade text-left" id="castModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-file-o"></i> Podcast Upload</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('upload_form_video')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" name="mode" value="0">
                            <h4 class="form-section"><i class="fa fa-list-alt"></i> Podcast Details</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="castName">Podcast Name</label>
                                        <input type="text" id="castName" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="castName">Podcast Name</label>
                                        <select class="form-control" id="castType" name="type">
                                            <option value="2">Inspiring Stories – 15 -30 interview</option>
                                            <option value="3">Educator School Talk – 15 -30 interview</option>
                                            <option value="4">Veteran Talk - 15 -30 interview</option>
                                            <option value="5">Financial Talk - 15 -30 interview</option>
                                            <option value="6">Real Talk – 45 minutes – call ins</option>
                                            <option value="7">Entrepreneurs Talk - 15 -30 interview</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="castFile">Upload Podcast File</label>
                                        <input type="file" id="castFile" name="file" class="form-control" accept=".mp4,.mp3,.wav,.avi,.web" required>
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


    <div class="modal fade text-left" id="editCastModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-file-o"></i> Podcast Upload</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('upload_form_video')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <input type="hidden" name="mode" value="1">
                            <input type="hidden" name="currentID" id="currentCastID">
                            <h4 class="form-section"><i class="fa fa-list-alt"></i> Podcast Details</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editCastName">Podcast Name</label>
                                        <input type="text" id="editCastName" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editCastCurrent">File Name</label>
                                        <input type="text" id="editCastCurrent" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editCastType">Podcast Name</label>
                                        <select class="form-control" id="editCastType" name="type">
                                            <option value="2">Inspiring Stories – 15 -30 interview</option>
                                            <option value="3">Educator School Talk – 15 -30 interview</option>
                                            <option value="4">Veteran Talk - 15 -30 interview</option>
                                            <option value="5">Financial Talk - 15 -30 interview</option>
                                            <option value="6">Real Talk – 45 minutes – call ins</option>
                                            <option value="7">Entrepreneurs Talk - 15 -30 interview</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editCastFile">Upload Podcast File</label>
                                        <input type="file" id="editCastFile" name="file" class="form-control" accept=".mp4,.mp3,.wav,.avi,.web">
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
        
        function onFilter() {
            var currentURL= $("#currentURL").val();
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();
            if (startDate !="" && endDate != "" ){
                currentURL += "?start_date="+startDate+"&end_date="+endDate;
            }
            var url = window.location.href;
            if (url.indexOf("#") != -1){
                var activeTab = url.substring(url.indexOf("#") + 1);
                currentURL += "#"+activeTab;
            }
            document.location.href = currentURL;
        }

        function uploadCast() {
            $("#castName").val();
            $("#castFile").val();
            $("#castModal").modal('show');
        }
        
        function editCast(id) {
            $.post("{{route('get_form_video')}}",{
                _token:'{{csrf_token()}}',
                id:id,
            }).done(
                function (data) {
                    var jsonData = JSON.parse(data);
                    $("#currentCastID").val(jsonData.id);
                    $("#editCastName").val(jsonData.name);
                    $("#editCastCurrent").val(jsonData.original_name);
                    $("#editCastType").val(jsonData.type);
                    $("#editCastFile").val("");
                    console.log(data);
                    $("#editCastModal").modal('show');
                }
            );
        }

        function removeCast(id) {
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