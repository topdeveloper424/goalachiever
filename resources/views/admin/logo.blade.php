@extends('layout.app')
@section('title')
    User Logo/Documents
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/dropzone.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/toastr.css')}}">
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
                        <h4 class="card-title" id="basic-layout-colored-form-control">User Logo/Document</h4>
                        <p class="mb-0">You can see all logo and document you uploaded.</p>
                    </div>
                    <div class="card-content">
                        <div class="px-3">
                            <div class="row mt-4 mb-4">
                                @if($files->count() == 0)
                                    <div class="col-md-12 text-center">
                                        <div class="content-header">There is no any logo/documents.</div>
                                    </div>
                                @endif
                                @foreach($files as $file)
                                <div class="col-md-3" id="logo{{$file->id}}">
                                    @if($file->type == false)
                                        <img class="media-object round-media height-100" src="{{asset('uploaded')}}\{{$file->path}}" height="100px">
                                        <a href="{{asset('uploaded')}}\{{$file->path}}" class="dark p-0" data-toggle="tooltip" data-placement="top" title="Download Logo/Document" download>
                                            <i class="ft-download-cloud font-medium-3 mr-2"></i>
                                        </a>
                                        <a class="dark p-0" data-toggle="tooltip" data-placement="top" title="Remove Logo/Document" onclick="removeLogo({{$file->id}})">
                                            <i class="ft-trash-2 font-medium-3 mr-2"></i>
                                        </a>
                                        <br>
                                        <span>{{$file->path}}</span>
                                    @else
                                        <img class="media-object round-media height-100" src="{{asset('app-assets/img/document.png')}}" height="100px">
                                        <a href="{{asset('uploaded')}}\{{$file->path}}" class="dark p-0" data-toggle="tooltip" data-placement="top" title="Download Logo/Document" download>
                                            <i class="ft-download-cloud font-medium-3 mr-2"></i>
                                        </a>
                                        <a class="dark p-0" data-toggle="tooltip" data-placement="top" title="Remove Logo/Document" onclick="removeLogo({{$file->id}})">
                                            <i class="ft-trash-2 font-medium-3 mr-2"></i>
                                        </a>
                                        <br>
                                        <span>{{$file->path}}</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <br>
                                    <br>
                                    <form action="{{route('logo_upload')}}" method="post" class="dropzone dropzone-area" id="dpz-multiple-files" enctype="multipart/form-data" >
                                        @csrf
                                        <input type="hidden" name="id" value="{{$id}}">
                                        <div class="dz-message">Drop Files Here To Upload</div>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Statistics cards Ends-->



    </div>

@endsection

@section('script')
    <script src="{{asset('app-assets/vendors/js/dropzone.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/prism.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/sweetalert2.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/vendors/js/toastr.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.alert-success').fadeIn().delay(5000).fadeOut();
            Dropzone.options.dpzMultipleFiles = {
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 2.5, // MB
                acceptedFiles:'image/*,application/pdf,.doc,.docx,.txt',
                addRemoveLinks: true,
                timeout: 5000,
                success: function(file, response)
                {
                    toastr.success("Successfully Uploaded!","Server Status")
                    console.log(response);
                },
                error: function(file, response)
                {
                    toastr.error("Error Happened!","Server Status")
                    return false;
                }
            }

        });

        function removeLogo(id) {
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
                    $.post("{{route('logo_delete')}}",{
                        _token:'{{csrf_token()}}',
                        id:id,
                    }).done(
                        function (data) {
                            $("#logo"+id).remove();
                            toastr.success("Successfully Removed!","Server Status")
                        }
                    );
                }
            }).catch(swal.noop);
        }
    </script>
@endsection