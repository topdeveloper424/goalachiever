@extends('layout.app')
@section('title')
    User Management
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
                                <h4 class="card-title">Users Table</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group mr-1 mb-1" style="float: right">
                                    <button type="button" class="btn btn-raised btn-danger btn-min-width dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">ADD USER<i class="fa ft-user-plus ml-2"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" onclick="addUser(0)">Administrator</a>
                                        <a class="dropdown-item" onclick="addUser(1)">Member</a>
                                        <a class="dropdown-item" onclick="addUser(2)">Representative</a>
                                        <a class="dropdown-item" onclick="addUser(3)">Regional Representative</a>
                                        <a class="dropdown-item" onclick="addUser(4)">School Participant</a>
                                        <a class="dropdown-item" onclick="addUser(5)">Sponsor</a>
                                    </div>
                                </div>

                                <button type="button" style="float: right" class="btn btn-raised btn-primary btn-min-width mr-1 mb-1" data-toggle="tooltip" data-placement="top" title="Invite member" onclick="inviteUser()">INVITE MEMBER <i class="fa ft-plus ml-2"></i></button>
                            </div>

                        </div>
                    </div>
                    <div class="card-content ">
                        <div class="card-body card-dashboard table-responsive">
                            <table class="table table-striped table-bordered file-export">
                                <thead>
                                <tr>
                                    <th width="10%">Logo</th>
                                    <th width="25%">Name</th>
                                    <th width="20%">Email</th>
                                    <th width="10%">Level</th>
                                    <th width="20%">City</th>
                                    <th width="15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <?php
                                        $logo = null;
                                        $files = \App\UserFile::where('user_id',$user->id)->where('type',0)->get();
                                        if ($files->count() > 0){
                                            $logo = $files[0]->path;
                                        }

                                    ?>
                                    <tr>
                                        <td>@if($logo)<img class="media-object round-media height-50" src="{{asset('uploaded')}}\{{$logo}}" alt="logo image">@endif</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @if($user->role == 0)
                                                <span class="badge-pill badge-primary">Admin</span>
                                                @elseif($user->role == 1)
                                                <span class="badge-pill badge-success">Member</span>
                                                @elseif($user->role == 2)
                                                <span class="badge-pill badge-danger">Rep.</span>
                                                @elseif($user->role == 3)
                                                <span class="badge-pill badge-info">Regional</span>
                                                @elseif($user->role == 4)
                                                <span class="badge-pill badge-warning">School p.</span>
                                                @else
                                                <span class="badge-pill badge-dark">Sponsor</span>

                                            @endif
                                        </td>
                                        <td>{{ $user->city}}</td>
                                        <td>
                                            <a class="success p-0"  data-toggle="tooltip" data-placement="top" title="Edit this user" onclick="editUser({{$user->id}})">
                                                <i class="ft-edit-2 font-medium-3 mr-2"></i>
                                            </a>
                                            <a href="/user-logo/{{$user->id}}" class="dark p-0" data-toggle="tooltip" data-placement="top" title="Upload Logo/Document" target="_blank">
                                                <i class="ft-upload-cloud font-medium-3 mr-2"></i>
                                            </a>
                                            <a class="info p-0" data-toggle="tooltip" data-placement="top" title="Reset Password" onclick="resetPassword({{$user->id}})">
                                                <i class="ft-refresh-ccw font-medium-3 mr-2"></i>
                                            </a>
                                            <a class="danger p-0" data-toggle="tooltip" data-placement="top" title="Remove this user" onclick="removeUser({{$user->id}})">
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
    <?php $states = \App\USAState::all(); ?>


    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-user-plus"></i> Add New <span id="new_add_label">Administrator</span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('save_user')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="mode" value="0">
                        <input type="hidden" name="role" id="new_role">
                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_name" id="new_name_label">Full Name</label>
                                        <input type="text" id="new_name" class="form-control" name="name" required>
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
                                <div class="col-md-6" id="new_name2_row">
                                    <div class="form-group">
                                        <label for="new_name2" id="new_name2_label">Company Name</label>
                                        <input type="text" id="new_name2" class="form-control" name="name2">
                                    </div>
                                </div>
                                <div class="col-md-6" id="new_address1_row">
                                    <div class="form-group">
                                        <label for="new_address1" id="new_address1_label">Company Address</label>
                                        <input type="text" id="new_address1" class="form-control" name="address1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_phone">Contact #</label>
                                        <input type="text" id="new_phone" class="form-control" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6" id="new_address2_row">
                                    <div class="form-group">
                                        <label for="new_address2" id="new_address2_label">Business Address</label>
                                        <input type="text" id="new_address2" class="form-control" name="address2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_state">State</label>
                                        <select id="new_state" class="form-control" name="state" required onchange="changeState(0)">
                                            @foreach($states as $state)
                                                <option value="{{$state->state_code}}">{{$state->state}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_city">City</label>
                                        <select id="new_city" class="form-control" name="city" required></select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="new_grade_level_row">
                                    <div class="form-group">
                                        <label for="new_grade_level">Grade Level</label>
                                        <select class="form-control" id="new_grade_level" name="grade_type">
                                            @foreach($grade_levels as $level)
                                                <option value="{{$level->id}}">{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="new_bus_type_row">
                                    <div class="form-group">
                                        <label for="new_bus_type">Type Of Business</label>
                                        <select class="form-control" id="new_bus_type" name="grade_type">
                                            @foreach($type_businesses as $type_business)
                                                <option value="{{$type_business->id}}">{{$type_business->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="new_website_row">
                                    <div class="form-group">
                                        <label for="new_website">Website</label>
                                        <input type="text" id="new_website" class="form-control" name="website">
                                    </div>
                                </div>
                                <div class="col-md-6" id="new_rep_row">
                                    <div class="form-group">
                                        <label for="new_rep">Representative</label>
                                        <select id="new_rep" class="form-control" name="rep">
                                            @foreach($reps as $rep)
                                                <option  value="{{$rep->id}}">{{$rep->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="new_reg_row">
                                    <div class="form-group">
                                        <label for="new_reg">Regional Representative</label>
                                        <select id="new_reg" class="form-control" name="rep">
                                            @foreach($regs as $reg)
                                                <option value="{{$reg->id}}">{{$reg->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_password">Password</label>
                                        <input type="password" id="new_password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_confirm">Confirm</label>
                                        <input type="password" id="new_confirm" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>

                            <h4 class="form-section"><i class="ft-file-text"></i> Other Info</h4>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_educator">Educator</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="educator" id="new_educator">
                                            <label class="custom-control-label" for="new_educator"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_veteran">Veteran</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="veteran" id="new_veteran">
                                            <label class="custom-control-label" for="new_veteran"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_app_purchase">Personal Apparel</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="app_purchase" id="new_app_purchase">
                                            <label class="custom-control-label" for="new_app_purchase"></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_app_commission">Member Apparel</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="app_commission" id="new_app_commission">
                                            <label class="custom-control-label" for="new_app_commission"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="new_representative">Representative</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="representative" id="new_representative">
                                            <label class="custom-control-label" for="new_representative"></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_donation">Donation</label>
                                        <select id="new_donation" name="donation" class="form-control" required>
                                            <option value="0">Scholarship</option>
                                            <option value="1">School Donations</option>
                                            <option value="2">Cancer Awareness </option>
                                            <option value="3">Disable Veterans </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_amount">Amount</label>
                                        <input type="number" id="new_amount" class="form-control" name="amount" required>
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


    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-user-plus"></i> Edit This <span id="add_label">Administrator</span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('save_user')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="mode" value="1">
                        <input type="hidden" name="cur_user" id="cur_user">
                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="photoFile" class="ml-4">Avatar</label>
                                        <img class="media-object d-flex ml-2 round-media" id="photoImage" src="{{asset('app-assets/img/default-avatar.png')}}" alt="No Avatar" style="width: 100px;height: 100px;border-radius: 50%">
                                        <button type="button" class="btn btn-danger btn-sm mt-2" id="changePhotoButton"><i class="ft-upload mr-1"></i>Upload Photo</button>
                                        <input type="file" class="form-control-file" id="photoFile" name="photoFile" accept="image/x-png,image/gif,image/jpeg" style="display: none" onchange="onLoadPhoto(event)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">User Level</label>
                                        <select class="form-control" id="role" name="role" onchange="changeRole()">
                                            <option value="0">Administrator</option>
                                            <option value="1">Member</option>
                                            <option value="2">Representative </option>
                                            <option value="3">Regional Representative</option>
                                            <option value="4">School Participant</option>
                                            <option value="5">Sponsor</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" id="name_label">Full Name</label>
                                        <input type="text" id="name" class="form-control" name="name" required>
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
                                <div class="col-md-6" id="name2_row">
                                    <div class="form-group">
                                        <label for="name2" id="name2_label">Company Name</label>
                                        <input type="text" id="name2" class="form-control" name="name2">
                                    </div>
                                </div>
                                <div class="col-md-6" id="address1_row">
                                    <div class="form-group">
                                        <label for="address1" id="address1_label">Company Address</label>
                                        <input type="text" id="address1" class="form-control" name="address1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Contact #</label>
                                        <input type="text" id="phone" class="form-control" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6" id="address2_row">
                                    <div class="form-group">
                                        <label for="address2" id="address2_label">Business Address</label>
                                        <input type="text" id="address2" class="form-control" name="address2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select id="state" class="form-control" name="state" required onchange="changeState(1)">
                                            @foreach($states as $state)
                                                <option value="{{$state->state_code}}">{{$state->state}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select id="city" class="form-control" name="city" required></select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="grade_level_row">
                                    <div class="form-group">
                                        <label for="grade_level">Grade Level</label>
                                        <select class="form-control" id="grade_level" name="grade_type">
                                            @foreach($grade_levels as $level)
                                                <option value="{{$level->id}}">{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="bus_type_row">
                                    <div class="form-group">
                                        <label for="bus_type">Type Of Business</label>
                                        <select class="form-control" id="bus_type" name="grade_type">
                                            @foreach($type_businesses as $type_business)
                                                <option value="{{$type_business->id}}">{{$type_business->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="website_row">
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="text" id="website" class="form-control" name="website">
                                    </div>
                                </div>
                                <div class="col-md-6" id="rep_row">
                                    <div class="form-group">
                                        <label for="rep">Representative</label>
                                        <select id="rep" class="form-control" name="rep">
                                            @foreach($reps as $rep)
                                                <option value="{{$rep->id}}">{{$rep->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="reg_row">
                                    <div class="form-group">
                                        <label for="reg">Regional Representative</label>
                                        <select id="reg" class="form-control" name="rep">
                                            @foreach($regs as $reg)
                                                <option value="{{$reg->id}}">{{$reg->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="member_id">Member ID</label>
                                        <input type="text" id="member_id" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="created_at">Sign Up Date</label>
                                        <input type="text" id="created_at" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>


                            <h4 class="form-section"><i class="ft-file-text"></i> Other Info</h4>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="educator">Educator</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="educator" id="educator">
                                            <label class="custom-control-label" for="educator"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="veteran">Veteran</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="veteran" id="veteran">
                                            <label class="custom-control-label" for="veteran"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="app_purchase">Personal Apparel</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="app_purchase" id="app_purchase">
                                            <label class="custom-control-label" for="app_purchase"></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="app_commission">Member Apparel</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="app_commission" id="app_commission">
                                            <label class="custom-control-label" for="app_commission"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="representative">Representative</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="representative" id="representative">
                                            <label class="custom-control-label" for="representative"></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="donation">Donation</label>
                                        <select id="donation" name="donation" class="form-control" required>
                                            <option value="0">Scholarship</option>
                                            <option value="1">School Donations</option>
                                            <option value="2">Cancer Awareness </option>
                                            <option value="3">Disable Veterans </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" id="amount" class="form-control" name="amount" required>
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


    <div class="modal fade text-left" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-user-check"></i> Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('reset_pass')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="reset_user" name="user_id">
                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-lock"></i> Enter Password</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">New Password</label>
                                        <input type="password" id="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Confirm</label>
                                        <input type="password" id="confirm" class="form-control" name="password_confirmation" required>
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

    <div class="modal fade text-left" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa ft-user-check"></i> Invite Member</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form" method="post" action="{{route('invite_user')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <h4 class="form-section"><i class="ft-mail"></i> Enter Email</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="inviteEmail">Email Address</label>
                                        <input type="email" id="inviteEmail" class="form-control" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="shareLink">Share Link</label>
                                    <input type="text" id="shareLink" class="form-control" value="{{route('invite_register',['user_id'=>Auth::user()->user_id])}}" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-10">
                                    <a class="btn btn-social-icon btn-round mr-2 mb-2 btn-twitter" href="https://twitter.com/intent/tweet?url={{urlencode(route('invite_register',['user_id'=>Auth::user()->user_id]))}}&text=goal+achieve+backOffice" target="_blank"><span class="fa fa-twitter"></span></a>
                                    <a class="btn btn-social-icon btn-round mr-2 mb-2 btn-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(route('invite_register',['user_id'=>Auth::user()->user_id]))}}&title=goal+achieve+backOffice" target="_blank"><span class="fa fa-facebook"></span></a>
                                    <a class="btn btn-social-icon btn-round mr-2 mb-2 btn-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url={{urlencode(route('invite_register',['user_id'=>Auth::user()->user_id]))}}&title=goal+achieve+backOffice" target="_blank"><span class="fa fa-linkedin"></span></a>
                                    <a class="btn btn-social-icon btn-round mr-3 mb-2 btn-google" href="https://mail.google.com/mail/?view=cm&fs=1&to&ui=2&tf=1&su={{urlencode(route('invite_register',['user_id'=>Auth::user()->user_id]))}}&body=goal+achieve+backOffice" target="_blank"><span class="fa fa-google"></span></a>
                                    <a class="mr-2" href="https://www.messenger.com/"><img src="{{asset('app-assets/img/fm.png')}}" style="width: 40px"></a>
                                    <a class="mr-2" href="mailto: goalachieve@afmc1.com"><img src="{{asset('app-assets/img/message.png')}}" style="width: 40px"></a>
                                </div>
                                <div class="col-md-2"><button type="button" id="copyLink" class="btn mt-1 mr-1 mb-1 btn-primary btn-sm">Copy</button></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Send Invitation</button>
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
    <script src="{{asset('app-assets/js/jquery.copy-to-clipboard.js')}}" type="text/javascript"></script>


    <script>
        $(document).ready(function () {
            $('.file-export').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            $('.alert-success').fadeIn().delay(5000).fadeOut();
            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-outline-primary mr-1');
            $("#copyLink").click(function(){
                $(this).CopyToClipboard();
                $(this).html('Copied').hide().fadeIn('slow');
                var copyText = document.getElementById("shareLink");

                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /*For mobile devices*/

                /* Copy the text inside the text field */
                document.execCommand("copy");
            });
            $("#changePhotoButton").click(function () {
                $("#photoFile").trigger('click');
            });


        });
        var onLoadPhoto = function(event) {
            var image = document.getElementById('photoImage');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        function addUser(role) {
            $("#new_role").val(role);
            if (role == 0 || role == 1){
                $("#new_name_label").html("Full Name");
                $("#new_name2_row").hide();
                $("#new_address1_row").hide();
                $("#new_address2_row").hide();
                $("#new_website_row").hide();
                $("#new_grade_level_row").hide();
                $("#new_bus_type_row").hide();
                if (role == 0){
                    $("#new_add_label").html("Administrator");
                } else{
                    $("#new_add_label").html("Member");
                }
                $("#new_rep_row").hide();
                $("#new_reg_row").hide();
            }else if (role == 2){
                $("#new_name_label").html("Full Name");
                $("#new_address1_row").show();
                $("#new_address1").val("");
                $("#new_address1_label").html("Address");
                $("#new_name2_row").hide();
                $("#new_address2_row").hide();
                $("#new_website_row").hide();
                $("#new_grade_level_row").hide();
                $("#new_bus_type_row").hide();
                $("#new_add_label").html("Representative");
                $("#new_rep_row").hide();
                $("#new_reg_row").show();
            }else if (role == 3){
                $("#new_name_label").html("Company Name");
                $("#new_address1_row").show();
                $("#new_address1").val("");
                $("#new_address1_label").html("Company Address");
                $("#new_name2_row").hide();
                $("#new_address2_row").show();
                $("#new_address2").val("");
                $("#new_address2_label").html("Business Address");
                $("#new_website_row").show();
                $("#new_website").val("");
                $("#new_grade_level_row").hide();
                $("#new_bus_type_row").hide();
                $("#new_add_label").html("Regional Representative");
                $("#new_rep_row").hide();
                $("#new_reg_row").hide();
            }else if (role == 4){
                $("#new_name_label").html("Contact Person");
                $("#new_address1_row").show();
                $("#new_address1_label").html("School Address");
                $("#new_name2_row").show();
                $("#new_name2_label").html("School Name");
                $("#new_address2_row").hide();
                $("#new_website_row").show();
                $("#new_grade_level_row").show();
                $("#new_bus_type_row").hide();
                $("#new_add_label").html("School Participant");
                $("#new_address1").val("");
                $("#new_name2").val("");
                $("#new_website").val("");
                $("#new_grade_level").val("");
                $("#new_rep_row").show();
                $("#new_reg_row").hide();
            }else {
                $("#new_name_label").html("Contact Person");
                $("#new_address1_row").show();
                $("#new_address1_label").html("Company Address");
                $("#new_name2_row").show();
                $("#new_name2_label").html("Company Name");
                $("#new_address2_row").hide();
                $("#new_website_row").show();
                $("#new_grade_level_row").hide();
                $("#new_bus_type_row").show();
                $("#new_add_label").html("Sponsor");
                $("#new_address1").val("");
                $("#new_name2").val("");
                $("#new_website").val("");
                $("#new_bus_type").val("");
                $("#new_rep_row").show();
                $("#new_reg_row").hide();

            }

            $("#new_name").val("");
            $("#new_email").val("");
            $("#new_city").val("");
            $("#new_state").val("");
            $("#new_phone").val("");
            $("#new_rep").val("");
            $("#new_reg").val("");
            $("#new_educator").prop( "checked", false );
            $("#new_veteran").prop( "checked", false );
            $("#new_app_purchase").prop( "checked", false );
            $("#new_app_commission").prop( "checked", false );
            $("#new_representative").prop( "checked", false );
            $("#new_donation").val("");
            $("#new_amount").val("");
            $("#password").val("");
            $("#password_confirmation").val("");


            $('#addModal').modal('show');

        }

        function editUser(id) {
            $("#name").val("");
            $("#name2").val("");
            $("#email").val("");
            $("#address1").val("");
            $("#address2").val("");
            $("#city").val("");
            $("#state").val("");
            $("#phone").val("");
            $("#website").val("");
            $("#grade_level").val("");
            $("#bus_type").val("");
            $("#member_id").val("");
            $("#created_at").val("");
            $("#cur_user").val(id);
            $("#educator").prop( "checked", false );
            $("#veteran").prop( "checked", false );
            $("#app_purchase").prop( "checked", false );
            $("#app_commission").prop( "checked", false );
            $("#representative").prop( "checked", false );
            $("#donation").val("");
            $("#amount").val("");
            $("#rep").val("");
            $("#reg").val("");
            $.ajax({
                type: "get",
                url: '{{route('get_user')}}',
                data: {
                    id: id
                },
                success: function (data) {
                    console.log(data);
                    var jsondata = JSON.parse(data);
                    var role = jsondata.role;
                    $("#name").val(jsondata.name);
                    $("#email").val(jsondata.email);
                    $("#phone").val(jsondata.phone);
                    $("#address").val(jsondata.address);
                    var state = jsondata.state;
                    $("#state").val(state);
                    if(jsondata.avatar){
                        $("#photoImage").attr("src","{{asset('uploads/avatars')}}/"+jsondata.avatar)
                    }else{
                        $("#photoImage").attr("src","{{asset('app-assets/img/default-avatar.png')}}")
                    }

                    $.ajax({
                        type: "get",
                        url: '{{route('get_cities')}}',
                        data: {
                            state: state,
                        },
                        success: function (data) {
                            var resJson = JSON.parse(data);
                            var htm = "";
                            for (var i = 0; i < resJson.length; i++){
                                var row = resJson[i];
                                htm += "<option value='"+row.city+"'>"+row.city+"</option>";
                            }
                            $("#city").html(htm);
                            $("#city").val(jsondata.city);

                        }
                    });


                    $("#role").val(role);
                    var created_at = jsondata.signup;
                    $("#created_at").val(created_at);
                    $("#member_id").val(jsondata.user_id);
                    $("#user_id").val(jsondata.id);
                    if (jsondata.educator == 0){
                        $("#educator").prop( "checked", false );
                    }else{
                        $("#educator").prop( "checked", true );
                    }
                    if (jsondata.veteran == 0){
                        $("#veteran").prop( "checked", false );
                    }else{
                        $("#veteran").prop( "checked", true );
                    }
                    if (jsondata.app_purchase == 0){
                        $("#app_purchase").prop( "checked", false );
                    }else{
                        $("#app_purchase").prop( "checked", true );
                    }
                    if (jsondata.app_commission == 0){
                        $("#app_commission").prop( "checked", false );
                    }else{
                        $("#app_commission").prop( "checked", true );
                    }
                    if (jsondata.representative == 0){
                        $("#representative").prop( "checked", false );
                    }else{
                        $("#representative").prop( "checked", true );
                    }

                    $("#donation").val(jsondata.donation);
                    $("#amount").val(jsondata.amount);

                    if (role == 0 || role == 1){
                        $("#name_label").html("Full Name");
                        $("#name2_row").hide();
                        $("#address1_row").hide();
                        $("#address2_row").hide();
                        $("#website_row").hide();
                        $("#grade_level_row").hide();
                        $("#bus_type_row").hide();
                        if (role == 0){
                            $("#add_label").html("Administrator");
                        } else{
                            $("#add_label").html("Member");
                        }
                        $("#rep_row").hide();
                        $("#reg_row").hide();
                    }else if (role == 2){
                        $("#name_label").html("Full Name");
                        $("#address1_row").show();
                        $("#address1").val(jsondata.address1);
                        $("#address1_label").html("Address");
                        $("#name2_row").hide();
                        $("#address2_row").hide();
                        $("#website_row").hide();
                        $("#grade_level_row").hide();
                        $("#bus_type_row").hide();
                        $("#add_label").html("Representative");
                        $("#rep_row").hide();
                        $("#reg_row").show();
                        $("#reg_row").val(jsondata.rep);
                    }else if (role == 3){
                        $("#name_label").html("Company Name");
                        $("#address1_row").show();
                        $("#address1").val(jsondata.address1);
                        $("#address1_label").html("Company Address");
                        $("#name2_row").hide();
                        $("#address2_row").show();
                        $("#address2").val(jsondata.address2);
                        $("#address2_label").html("Business Address");
                        $("#website_row").show();
                        $("#website").val(jsondata.website);
                        $("#grade_level_row").hide();
                        $("#bus_type_row").hide();
                        $("#add_label").html("Regional Representative");
                        $("#rep_row").hide();
                        $("#reg_row").hide();
                    }else if (role == 4){
                        $("#name_label").html("Contact Person");
                        $("#address1_row").show();
                        $("#address1_label").html("School Address");
                        $("#name2_row").show();
                        $("#name2_label").html("School Name");
                        $("#address2_row").hide();
                        $("#website_row").show();
                        $("#grade_level_row").show();
                        $("#bus_type_row").hide();
                        $("#add_label").html("School Participant");
                        $("#address1").val(jsondata.address1);
                        $("#name2").val(jsondata.name2);
                        $("#website").val(jsondata.website);
                        $("#grade_level").val(jsondata.grade_type);
                        $("#rep_row").show();
                        $("#reg_row").hide();
                        $("#rep").val(jsondata.rep);
                    }else {
                        $("#name_label").html("Contact Person");
                        $("#address1_row").show();
                        $("#address1_label").html("Company Address");
                        $("#name2_row").show();
                        $("#name2_label").html("Company Name");
                        $("#address2_row").hide();
                        $("#website_row").show();
                        $("#grade_level_row").hide();
                        $("#bus_type_row").show();
                        $("#add_label").html("Sponsor");
                        $("#address1").val(jsondata.address1);
                        $("#name2").val(jsondata.name2);
                        $("#website").val(jsondata.website);
                        $("#bus_type").val(jsondata.grade_type);
                        $("#rep_row").show();
                        $("#reg_row").hide();
                        $("#rep").val(jsondata.rep);
                    }

                    $("#editModal").modal('show');
                }
            });

        }

        function changeRole() {
            var role = $("#role").val();
            if (role == 0 || role == 1){
                $("#name_label").html("Full Name");
                $("#name2_row").hide();
                $("#address1_row").hide();
                $("#address2_row").hide();
                $("#website_row").hide();
                $("#grade_level_row").hide();
                $("#bus_type_row").hide();
                if (role == 0){
                    $("#add_label").html("Administrator");
                } else{
                    $("#add_label").html("Member");
                }
            }else if (role == 2){
                $("#name_label").html("Full Name");
                $("#address1_row").show();
                $("#address1").val("");
                $("#address1_label").html("Address");
                $("#name2_row").hide();
                $("#address2_row").hide();
                $("#website_row").hide();
                $("#grade_level_row").hide();
                $("#bus_type_row").hide();
                $("#add_label").html("Representative");
            }else if (role == 3){
                $("#name_label").html("Company Name");
                $("#address1_row").show();
                $("#address1").val("");
                $("#address1_label").html("Company Address");
                $("#name2_row").hide();
                $("#address2_row").show();
                $("#address2").val("");
                $("#address2_label").html("Business Address");
                $("#website_row").show();
                $("#website").val("");
                $("#grade_level_row").hide();
                $("#bus_type_row").hide();
                $("#add_label").html("Regional Representative");
            }else if (role == 4){
                $("#name_label").html("Contact Person");
                $("#address1_row").show();
                $("#address1_label").html("School Address");
                $("#name2_row").show();
                $("#name2_label").html("School Name");
                $("#address2_row").hide();
                $("#website_row").show();
                $("#grade_level_row").show();
                $("#bus_type_row").hide();
                $("#add_label").html("School Participant");
                $("#address1").val("");
                $("#name2").val("");
                $("#website").val("");
                $("#grade_level").val("");
            }else {
                $("#name_label").html("Contact Person");
                $("#address1_row").show();
                $("#address1_label").html("Company Address");
                $("#name2_row").show();
                $("#name2_label").html("Company Name");
                $("#address2_row").hide();
                $("#website_row").show();
                $("#grade_level_row").hide();
                $("#bus_type_row").show();
                $("#add_label").html("Sponsor");
                $("#address1").val("");
                $("#name2").val("");
                $("#website").val("");
                $("#bus_type").val("");

            }

        }
        function resetPassword(id) {
            $("#password").val("");
            $("#password_confirmation").val("");
            $("#reset_user").val(id);
            $("#resetModal").modal('show');

        }
        function removeUser(id) {
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

                    $.post("{{route('remove_user')}}",{
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
        
        function inviteUser() {
            $("#inviteEmail").val("");
            $("#inviteModal").modal('show');
        }

        function getCities(state) {
            return "";

        }

        function changeState(mode) {
            var state = "";
            if (mode == 0){
                state = $("#new_state").val();
            } else{
                state = $("#state").val();
            }

            $.ajax({
                type: "get",
                url: '{{route('get_cities')}}',
                data: {
                    state: state,
                },
                success: function (data) {
//                    console.log(data);
                    var jsondata = JSON.parse(data);
                    var htm = "";
                    for (var i = 0; i < jsondata.length; i++){
                        var row = jsondata[i];
                        htm += "<option value='"+row.city+"'>"+row.city+"</option>";
                    }

                    if (mode == 0){
                        $("#new_city").html(htm);
                    } else{
                        $("#city").html(htm);
                    }
                }
            });


        }

    </script>
@endsection