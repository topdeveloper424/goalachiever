@extends('layout.app')
@section('title')
    User Profile
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
                        <h4 class="card-title" id="basic-layout-colored-form-control">User Profile</h4>
                        <p class="mb-0">You can see all information about you.</p>
                    </div>
                    <div class="card-content">
                        <div class="px-3">
                            <form class="form mt-4" method="post" action="{{route('save_user')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="mode" value="1">
                                <input type="hidden" name="cur_user" id="cur_user" value="{{$user->id}}">

                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-info"></i> ABOUT USER</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="photoFile" class="ml-4">Your Photo</label>
                                                @if($user->avatar)
                                                    <img class="media-object d-flex ml-2 round-media" id="photoImage" src="{{asset('uploads/avatars')}}/{{$user->avatar}}" alt="User Avatar" style="width: 100px;height: 100px;border-radius: 50%">
                                                @else
                                                    <img class="media-object d-flex ml-2 round-media" id="photoImage" src="{{asset('app-assets/img/default-avatar.png')}}" alt="No Avatar" style="width: 100px;height: 100px;border-radius: 50%">
                                                @endif
                                                <button type="button" class="btn btn-danger btn-sm mt-2" id="changePhotoButton"><i class="ft-upload mr-1"></i>Upload Photo</button>
                                                <input type="file" class="form-control-file" id="photoFile" name="photoFile" accept="image/x-png,image/gif,image/jpeg" style="display: none" onchange="onLoadPhoto(event)">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="userinput1">@if($user->role == 3)Company Name @elseif($user->role == 4 || $user->role == 5) Contact Person @else Full Name @endif</label>
                                                <input type="text" id="userinput1" name="name" class="form-control border-primary" value="{{$user->name}}">
                                            </div>
                                        </div>
                                        @if($user->role == 2)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address1">Address</label>
                                                    <input type="text" id="address1" name="address1" class="form-control border-primary" value="{{$user->address1}}">
                                                </div>
                                            </div>
                                        @endif
                                        @if($user->role == 3)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address1">Company Address</label>
                                                    <input type="text" id="address1" name="address1" class="form-control border-primary" value="{{$user->address1}}">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="userinput2">Email Address</label>
                                                <input type="email" id="userinput2" class="form-control border-primary" value="{{$user->email}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="userinput3">User Level</label>
                                                <input type="text" id="userinput3" class="form-control border-primary" value="@if($user->role == 0) Administrator @elseif($user->role == 1) Member @elseif($user->role == 2) Representative @elseif($user->role == 3) Regional Representative @else School Participant @endif" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="userinput4">Contact #</label>
                                                <input type="text" id="userinput4" name="phone" class="form-control border-primary" value="{{$user->phone}}">
                                            </div>
                                        </div>
                                    </div>
                                    @if($user->role == 4)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name2">School Name</label>
                                                <input type="text" id="name2" name="name2" class="form-control border-primary" value="{{$user->name2}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address1">School Address</label>
                                                <input type="text" id="address1" name="address1" class="form-control border-primary" value="{{$user->address1}}">
                                            </div>
                                        </div>
                                    @endif
                                    @if($user->role == 3)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address2">Business Address</label>
                                                <input type="text" id="address2" name="address2" class="form-control border-primary" value="{{$user->name}}">
                                            </div>
                                        </div>
                                    @endif
                                    @if($user->role == 4)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="website">Grade Level</label>
                                                <select class="form-control" id="grade_type" name="grade_type">
                                                    @foreach($grade_levels as $level)
                                                        <option value="{{$level->id}}" @if($level->id == $user->grade_type) selected @endif>{{$level->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($user->role == 5)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="website">Type Of Business</label>
                                                <select class="form-control" id="grade_type" name="grade_type">
                                                    @foreach($type_businesses as $type_business)
                                                        <option value="{{$type_business->id}}" @if($type_business->id == $user->grade_type) selected @endif>{{$type_business->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    @if($user->role >= 3)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="website">Website</label>
                                                <input type="text" id="website" name="website" class="form-control border-primary" value="{{$user->name}}">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="state">State</label>
                                                <select id="state" class="form-control" name="state" required>
                                                    <?php $states = \App\USAState::all(); ?>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->state_code}}" @if($state->state_code == $user->state) selected @endif>{{$state->state}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <?php $cities = \App\USACity::where('state_code',$user->state)->get(); ?>
                                                <select id="city" class="form-control" name="city" required>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->city}}" @if($city->city == $user->city) selected @endif>{{$city->city}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="userinput3">Member ID</label>
                                                <input type="text" id="userinput3" class="form-control border-primary" value="{{$user->user_id}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="userinput3">Sign Up Date</label>
                                                <input type="text" id="userinput3" class="form-control border-primary" value="{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$user->created_at)->format('m/d/Y h:i:s A')}}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="userinput3">Educator : </label>
                                                <br>
                                                @if($user->educator == 0)
                                                    <span class="badge badge-danger">Yes</span>
                                                @else
                                                    <span class="badge badge-primary">No</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="userinput3">Veteran : </label>
                                                <br>
                                                @if($user->veteran == 0)
                                                    <span class="badge badge-danger">Yes</span>
                                                @else
                                                    <span class="badge badge-primary">No</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="userinput3">Personal Apparel Purchases  : </label>
                                                <br>
                                                @if($user->app_purchase == 0)
                                                    <span class="badge badge-danger">Yes</span>
                                                @else
                                                    <span class="badge badge-primary">No</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="userinput3">Member Apparel Purchases : </label>
                                                <br>
                                                @if($user->app_commission == 0)
                                                    <span class="badge badge-danger">Yes</span>
                                                @else
                                                    <span class="badge badge-primary">No</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="userinput3">Representative : </label>
                                                <br>
                                                @if($user->representative == 0)
                                                    <span class="badge badge-danger">Yes</span>
                                                @else
                                                    <span class="badge badge-primary">No</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="userinput3">Donation</label>
                                                <input type="text" id="userinput3" class="form-control border-primary" value="@if($user->donation == 0) Scholarship @elseif($user->donation == 1) School Donations @elseif($user->donation == 2) Cancer Awareness @else Disable Veterans  @endif" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="userinput3">Amount</label>
                                                <input type="text" id="userinput3" class="form-control border-primary" value="{{$user->amount}}" readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-actions right">
                                        <button type="submit" class="btn btn-raised btn-primary">
                                            <i class="fa fa-check-square-o"></i> Save
                                        </button>
                                    </div>

                                </div>
                            </form>

                            <div class="form-body">

                                <h4 class="form-section"><i class="ft-file-plus"></i> UPLOAD LOGO/DOCUMENT(S)</h4>
                                <hr>
                                <div class="row">
                                    @if($files->count() == 0)
                                        <div class="col-md-12 text-center">
                                            <div class="content-header">There is no any logo/documents.</div>
                                        </div>
                                    @endif
                                    @foreach($files as $file)
                                        <div class="col-md-3" id="logo{{$file->id}}">
                                            @if($file->type == false)
                                                <img class="media-object round-media height-100" src="{{asset('uploaded')}}/{{$file->path}}" height="100px">
                                                <a href="{{asset('uploaded')}}/{{$file->path}}" class="dark p-0" data-toggle="tooltip" data-placement="top" title="Download Logo/Document" download>
                                                    <i class="ft-download-cloud font-medium-3 mr-2"></i>
                                                </a>
                                                <a class="dark p-0" data-toggle="tooltip" data-placement="top" title="Remove Logo/Document" onclick="removeLogo({{$file->id}})">
                                                    <i class="ft-trash-2 font-medium-3 mr-2"></i>
                                                </a>
                                                <br>
                                                <span>{{$file->path}}</span>
                                            @else
                                                <img class="media-object round-media height-100" src="{{asset('app-assets/img/document.png')}}" height="100px">
                                                <a href="{{asset('uploaded')}}/{{$file->path}}" class="dark p-0" data-toggle="tooltip" data-placement="top" title="Download Logo/Document" download>
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
                                            <input type="hidden" name="id" value="{{$user->id}}">
                                            <div class="dz-message">Drop Files Here To Upload</div>
                                        </form>

                                    </div>
                                </div>

                            </div>



                            <form class="form mt-5" method="post" action="{{route('reset_user')}}">
                                @csrf
                                <div class="form-body">

                                    <h4 class="form-section"><i class="ft-lock"></i> CHANGE PASSWORD</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <input class="form-control border-primary" type="password" id="password" name="password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input class="form-control border-primary" type="password" id="password_confirmation" name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>

                                <div class="form-actions right">
                                    <button type="button" class="btn btn-raised btn-warning mr-1" onclick="onCancel()">
                                        <i class="ft-x"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-raised btn-primary">
                                        <i class="fa fa-check-square-o"></i> Save
                                    </button>
                                </div>
                                </div>
                            </form>

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
                    console.log(response);
                },
                error: function(file, response)
                {
                    return false;
                }
            }

            $( "#state" ).change(function() {
                $.ajax({
                    type: "get",
                    url: '{{route('get_cities')}}',
                    data: {
                        state: this.value,
                    },
                    success: function (data) {
                        var jsondata = JSON.parse(data);
                        var htm = "";
                        for (var i = 0; i < jsondata.length; i++){
                            var row = jsondata[i];
                            htm += "<option value='"+row.city+"'>"+row.city+"</option>";
                        }
                        $("#city").html(htm);
                    }
                });
            });

            $("#changePhotoButton").click(function () {
                $("#photoFile").trigger('click');
            });


        });
        var onLoadPhoto = function(event) {
            var image = document.getElementById('photoImage');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        function onCancel() {
            $("#password").val("");
            $("#password_confirmation").val("");
        }

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