
<!DOCTYPE html>
<html lang="en" class="loading">
<!-- BEGIN : Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="BackOffice for Goal Achieve">
    <meta name="keywords" content="BackOffice, Goal Achieve, donate, web app">
    <meta name="author" content="top developer">
    <title>Sign Up(School participant)</title>
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('app-assets/img/ico/apple-icon-60.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('app-assets/img/ico/apple-icon-76.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('app-assets/img/ico/apple-icon-120.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('app-assets/img/ico/apple-icon-152.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets/img/ico/favicon.ico')}}">
    <link rel="shortcut icon" type="image/png" href="{{asset('app-assets/img/ico/favicon-32.png')}}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/feather/style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/simple-line-icons/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/perfect-scrollbar.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/prism.min.css')}}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/app.css')}}">
    <!-- END APEX CSS-->
    <!-- BEGIN Page Level CSS-->
    <!-- END Page Level CSS-->
    <style>
        body{
            background-image: url({{asset('app-assets/img/gallery/dark-bg.jpg')}});
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>
<!-- END : Head-->

<!-- BEGIN : Body-->
<body data-col="1-column" class=" 1-column  blank-page">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="wrapper mb-5">
    <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
            <div class="content-wrapper"><!--Login Page Starts-->
                <section id="regestration">
                    <div class="container-fluid">
                        <div class="row full-height-vh m-0">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="card" style="width: 50vw;">
                                    <div class="card-content">
                                        <div class="card-body register-img">
                                            <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="row m-0">
                                                <div class="col-lg-6 d-none d-lg-block py-2 text-center" style="background-color: white">
                                                    <img src="{{asset('app-assets/img/gallery/register.png')}}" alt="" class="img-fluid" width="400"
                                                         height="230">
                                                </div>
                                                <input type="hidden" name="role" value="4">
                                                @if(isset($create_user))
                                                    <input type="hidden" name="created_by" value="{{$create_user}}">
                                                @else
                                                    <input type="hidden" name="created_by" value="0">
                                                @endif
                                                <div class="col-lg-6 col-md-12 px-4 pt-3 bg-white">
                                                    <h4 class="card-title mb-3">Create School Participant Account</h4>
                                                    <input type="text" name="name" id="name" class="form-control mb-3" @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Contact Person" />
                                                    @error('name')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <input type="email" name="email" id="email" class="form-control mb-3" @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" />
                                                    @error('email')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <input type="text" name="phone" id="phone" class="form-control mb-3" @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Contact #" />
                                                    @error('phone')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <input type="text" name="name2" id="name2" class="form-control mb-3" @error('name2') is-invalid @enderror" value="{{ old('name2') }}" required autocomplete="name2" placeholder="School Name" />
                                                    @error('name2')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <input type="text" name="address1" id="address1" class="form-control mb-2" @error('address1') is-invalid @enderror" value="{{ old('address1') }}" required autocomplete="address1" placeholder="School Address" />
                                                    @error('address1')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <span class="small">State : </span>
                                                    <select class="form-control mb-2" id="state" name="state" @error('state') is-invalid @enderror" value="{{ old('state') }}">
                                                    <?php $states = \App\USAState::all(); ?>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->state_code}}">{{$state->state}}</option>
                                                    @endforeach
                                                    </select>
                                                    @error('state')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <span class="small">City : </span>
                                                    <select class="form-control mb-2" id="city" name="city" @error('city') is-invalid @enderror" value="{{ old('city') }}">
                                                    </select>
                                                    @error('city')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror


                                                        <span class="small">Grade Level : </span>
                                                    <select class="form-control mb-3" name="grade_type" id="grade_type" @error('grade_type') is-invalid @enderror" required autocomplete="grade_type" autofocus>
                                                    <?php $levels = \App\GradeLevel::all(); ?>
                                                    @foreach($levels as $level)
                                                        <option value="{{$level->id}}">{{$level->name}}</option>
                                                    @endforeach
                                                    </select>
                                                    @error('grade_type')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <input type="text" name="website" id="website" class="form-control mb-3" @error('website') is-invalid @enderror" value="{{ old('website') }}" required autocomplete="website" autofocus placeholder="Website" />
                                                    @error('website')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <input type="password" name="password" id="password" class="form-control mb-3" @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="Password" />
                                                    @error('password')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control mb-3" placeholder="Confirm Password" />
                                                    @error('password_confirmation')
                                                    <div class="alert alert-danger mb-2" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror

                                                    <div class="custom-control custom-checkbox custom-control-inline mb-3">
                                                        <input type="checkbox" id="customCheckboxInline1" name="customCheckboxInline1" class="custom-control-input"
                                                               required />
                                                        <label class="custom-control-label" for="customCheckboxInline1">
                                                            I accept the terms & conditions.
                                                        </label>
                                                    </div>
                                                    <div class="fg-actions d-flex justify-content-between">
                                                        <div class="login-btn">
                                                            <a href="/" class="btn btn-outline-primary">
                                                                Back To Sign In
                                                            </a>
                                                        </div>
                                                        <div class="recover-pass">
                                                            <button class="btn btn-primary" type="submit">
                                                                Sign Up
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <!-- END : End Main Content-->
    </div>
</div>

<br>
<br>
<br>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!-- BEGIN VENDOR JS-->
<script src="{{asset('app-assets/vendors/js/core/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/prism.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/jquery.matchHeight-min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/screenfull.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/vendors/js/pace/pace.min.js')}}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN APEX JS-->
<script src="{{asset('app-assets/js/app-sidebar.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/notification-sidebar.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/customizer.js')}}" type="text/javascript"></script>
<!-- END APEX JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
<script>
    $(document).ready(function () {

        var curState = $("#state").val();
        $.ajax({
            type: "get",
            url: '{{route('get_cities')}}',
            data: {
                state: curState,
            },
            success: function (data) {
//                    console.log(data);
                var jsondata = JSON.parse(data);
                var htm = "";
                for (var i = 0; i < jsondata.length; i++){
                    var row = jsondata[i];
                    htm += "<option value='"+row.city+"'>"+row.city+"</option>";
                }
                $("#city").html(htm);
            }
        });

        $( "#state" ).change(function() {
            $.ajax({
                type: "get",
                url: '{{route('get_cities')}}',
                data: {
                    state: this.value,
                },
                success: function (data) {
//                    console.log(data);
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
    });

</script>

</body>
<!-- END : Body-->
</html>