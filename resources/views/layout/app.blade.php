
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
    <title>@yield('title')</title>
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
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/chartist.min.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- END VENDOR CSS-->
    @yield('style')
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/app.css')}}">
    <!-- END APEX CSS-->
    <!-- BEGIN Page Level CSS-->
    <!-- END Page Level CSS-->
    <style>
        th,td{
            text-align: center;
        }
        .aster{
            color: red;
        }

    </style>


</head>
<!-- END : Head-->

<!-- BEGIN : Body-->
<body data-col="2-columns" class=" 2-columns ">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="wrapper">


    <!-- main menu-->
    <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
    <div data-active-color="white" data-background-color="man-of-steel" data-image="{{asset('app-assets/img/sidebar-bg/01.jpg')}}" class="app-sidebar">
        <!-- main menu header-->
        <!-- Sidebar Header starts-->
        <div class="sidebar-header">
            <div class="logo clearfix"><a href="{{route('home')}}" class="logo-text float-left">
                    <div class="logo-img"><img src="{{asset('app-assets/img/logo.png')}}"/></div><span class="text align-middle" style="font-size:20px;">BACKOFFICE</span></a><a id="sidebarToggle" href="javascript:;" class="nav-toggle d-none d-sm-none d-md-none d-lg-block"><i data-toggle="expanded" class="toggle-icon ft-toggle-right"></i></a><a id="sidebarClose" href="javascript:;" class="nav-close d-block d-md-block d-lg-none d-xl-none"><i class="ft-x"></i></a></div>
        </div>
        <!-- Sidebar Header Ends-->
        <!-- / main menu header-->
        <!-- main menu content-->
        <div class="sidebar-content">
            <div class="nav-container">
                <ul id="main-menu-navigation" data-menu="menu-navigation" data-scroll-to-active="true" class="navigation navigation-main">
                    <li class="{{Route::is('home') ? 'active':''}} nav-item"><a href="{{route('home')}}"><i class="ft-home"></i><span data-i18n="" class="menu-title">Dashboard</span></a>
                    </li>
                    <li class="{{Route::is('users_page') ? 'active':''}} nav-item"><a href="{{route('users_page')}}"><i class="ft-user"></i><span data-i18n="" class="menu-title">Users</span></a>
                    </li>

                    <li class="has-sub nav-item"><a href="#"><i class="ft-box"></i><span data-i18n="" class="menu-title">Contacts</span></a>
                        <ul class="menu-content">
                            <li class="{{Route::is('sponsor_page') ? 'active':''}}"><a href="{{route('sponsor_page')}}" class="menu-item">Sponsors </a>
                            </li>
                            <li class="{{Route::is('participant_page') ? 'active':''}}"><a href="{{route('participant_page')}}" class="menu-item">School Participants</a>
                            </li>
                            <li class="{{Route::is('vendor_page') ? 'active':''}}"><a href="{{route('vendor_page')}}" class="menu-item">Vendors</a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-sub nav-item"><a href="#"><i class="ft-aperture"></i><span data-i18n="" class="menu-title">Goal Settings</span></a>
                        <ul class="menu-content">
                            <li class="{{Route::is('financial_list_page') || Route::is('financial_page')  ? 'active':''}}"><a href="{{route('financial_list_page')}}" class="menu-item">Financial Goal </a>
                            </li>
                            <li class="{{Route::is('educational_list_page') || Route::is('educational_page') ? 'active':''}}"><a href="{{route('educational_list_page')}}" class="menu-item">Educational Goal </a>
                            </li>
                            <li class="{{Route::is('career_list_page') || Route::is('career_page') ? 'active':''}}"><a href="{{route('career_list_page')}}" class="menu-item">Career Goal </a>
                            </li>
                            <li class="{{Route::is('personal_list_page') || Route::is('personal_page') ? 'active':''}}"><a href="{{route('personal_list_page')}}" class="menu-item">Personal Goal </a>
                            </li>
                            <li class="{{Route::is('weight_list_page') || Route::is('weight_loss_page') ? 'active':''}}"><a href="{{route('weight_list_page')}}" class="menu-item">Weight Loss Goal </a>
                            </li>
                            <li class="{{Route::is('vacation_list_page') || Route::is('vacation_page') ? 'active':''}}"><a href="{{route('vacation_list_page')}}" class="menu-item">Vacation Goal </a>
                            </li>
                            <li class="{{Route::is('insurance_list_page') || Route::is('insurance_page') ? 'active':''}}"><a href="{{route('insurance_list_page')}}" class="menu-item">Insurance Coverage</a>
                            </li>
                            <li class="{{Route::is('retirement_list_page') || Route::is('retirement_page') ? 'active':''}}"><a href="{{route('retirement_list_page')}}" class="menu-item">Retirement Planning</a>
                            </li>
                            <li class="{{Route::is('purchase_list_page') || Route::is('purchase_page') ? 'active':''}}"><a href="{{route('purchase_list_page')}}" class="menu-item">RE Purchase</a>
                            </li>
                            <li class="{{Route::is('listing_list_page') || Route::is('listing_page') ? 'active':''}}"><a href="{{route('listing_list_page')}}" class="menu-item">RE Listing</a>
                            </li>
                            <li class="{{Route::is('mortgage_list_page') || Route::is('mortgage_page') ? 'active':''}}"><a href="{{route('mortgage_list_page')}}" class="menu-item">Mortgage Loan</a>
                            </li>
                            <li class="{{Route::is('report_list_page') || Route::is('goal_report_page') ? 'active':''}}"><a href="{{route('report_list_page')}}" class="menu-item">Goal Report</a>
                            </li>
                            {{--<li class="{{Route::is('booster_list_page') || Route::is('goal_booster_page') ? 'active':''}}"><a href="{{route('booster_list_page')}}" class="menu-item">Goal Booster</a>--}}
                            {{--</li>--}}
                        </ul>
                    </li>
                    <li class="{{Route::is('goal_type_page') ? 'active':''}} nav-item"><a href="{{route('goal_type_page')}}"><i class="ft-server"></i><span data-i18n="" class="menu-title">Goal Types</span></a>
                    </li>
                    <li class="has-sub nav-item"><a href="#"><i class="ft-link"></i><span data-i18n="" class="menu-title">Leads</span></a>
                        <ul class="menu-content">
                            <li class="{{Route::is('insurance_lead_list_page') ? 'active':''}}"><a href="{{route('insurance_lead_list_page')}}" class="menu-item"> Insurance Leads </a>
                            </li>
                            <li class="{{Route::is('retirement_lead_list_page') ? 'active':''}}"><a href="{{route('retirement_lead_list_page')}}" class="menu-item">Retirement Leads</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{Route::is('achiever_report_page') ? 'active':''}} nav-item"><a href="{{route('achiever_report_page')}}"><i class="ft-monitor"></i><span data-i18n="" class="menu-title">Goal Achiever Report</span></a>
                    </li>
                    <li class="has-sub nav-item"><a href="#"><i class="ft-star"></i><span data-i18n="" class="menu-title">Apparel</span></a>
                        <ul class="menu-content">
                            <li class="{{Route::is('apparel_item_page') ? 'active':''}}"><a href="{{route('apparel_item_page')}}" class="menu-item"> Items</a>
                            </li>
                            <li class="{{Route::is('orders_list_page') || Route::is('apparel_proceed_list_page') || Route::is('apparel_proceed_page') || Route::is('main_order_page') ? 'active':''}}"><a href="{{route('orders_list_page')}}" class="menu-item"> Purchase Orders</a>
                            </li>
                            <li class="{{Route::is('apparel_comm_page') ? 'active':''}}"><a href="{{route('apparel_comm_page')}}" class="menu-item"> Commissions</a>
                            </li>
                            <li class="{{Route::is('apparel_ur_page') ? 'active':''}}"><a href="{{route('apparel_ur_page')}}" class="menu-item"> UR Credits</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub nav-item"><a href="#"><i class="ft-star"></i><span data-i18n="" class="menu-title">Goal Booster BBB</span></a>
                        <ul class="menu-content">
                            <li class="{{Route::is('bbb_item_page') ? 'active':''}}"><a href="{{route('bbb_item_page')}}" class="menu-item"> Items</a>
                            </li>
                            <li class="{{Route::is('bbb_orders_list_page') || Route::is('bbb_proceed_list_page') || Route::is('bbb_proceed_page') || Route::is('bbb_main_order_page') ? 'active':''}}"><a href="{{route('bbb_orders_list_page')}}" class="menu-item"> Purchase Orders</a>
                            </li>
                            <li class="{{Route::is('bbb_comm_page') ? 'active':''}}"><a href="{{route('bbb_comm_page')}}" class="menu-item"> Commissions</a>
                            </li>
                            <li class="{{Route::is('bbb_ur_page') ? 'active':''}}"><a href="{{route('bbb_ur_page')}}" class="menu-item"> BBB Credits</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub nav-item"><a href="#"><i class="ft-star"></i><span data-i18n="" class="menu-title">Goal Booster Purchase Plans</span></a>
                        <ul class="menu-content">
                            <li class="{{Route::is('goalBooster_item_page') ? 'active':''}}"><a href="{{route('goalBooster_item_page')}}" class="menu-item"> Items</a>
                            </li>
                            <li class="{{Route::is('gb_orders_list_page') || Route::is('goalBooster_proceed_list_page') || Route::is('goalBooster_proceed_page') || Route::is('gb_main_order_page') ? 'active':''}}"><a href="{{route('gb_orders_list_page')}}" class="menu-item"> Purchase Orders</a>
                            </li>
                            <li class="{{Route::is('goalBooster_comm_page') ? 'active':''}}"><a href="{{route('goalBooster_comm_page')}}" class="menu-item"> Commissions</a>
                            </li>
                            <li class="{{Route::is('goalBooster_ur_page') ? 'active':''}}"><a href="{{route('goalBooster_ur_page')}}" class="menu-item"> Purchase Plans</a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-sub nav-item"><a href="#"><i class="ft-star"></i><span data-i18n="" class="menu-title">Sponsor</span></a>
                        <ul class="menu-content">
                            <li class="{{Route::is('sponsor_item_page') ? 'active':''}}"><a href="{{route('sponsor_item_page')}}" class="menu-item"> Items</a>
                            </li>
                            <li class="{{Route::is('sponsor_orders_list_page') || Route::is('sponsor_proceed_list_page') || Route::is('sponsor_proceed_page') || Route::is('sponsor_main_order_page') ? 'active':''}}"><a href="{{route('sponsor_orders_list_page')}}" class="menu-item"> Purchase Orders</a>
                            </li>
                            <li class="{{Route::is('sponsor_comm_page') ? 'active':''}}"><a href="{{route('sponsor_comm_page')}}" class="menu-item"> Commissions</a>
                            </li>
                            <li class="{{Route::is('sponsor_ur_page') ? 'active':''}}"><a href="{{route('sponsor_ur_page')}}" class="menu-item"> Package Plans</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub nav-item"><a href="#"><i class="ft-star"></i><span data-i18n="" class="menu-title">Subscription</span></a>
                        <ul class="menu-content">
                            <li class="{{Route::is('subscription_item_page') ? 'active':''}}"><a href="{{route('subscription_item_page')}}" class="menu-item"> Items</a>
                            </li>
                            <li class="{{Route::is('subscription_orders_list_page') || Route::is('subscription_proceed_list_page') || Route::is('subscription_proceed_page') || Route::is('subscription_main_order_page') ? 'active':''}}"><a href="{{route('subscription_orders_list_page')}}" class="menu-item"> Purchase Orders</a>
                            </li>
                            <li class="{{Route::is('subscription_comm_page') ? 'active':''}}"><a href="{{route('subscription_comm_page')}}" class="menu-item"> Commissions</a>
                            </li>
                            <li class="{{Route::is('subscription_ur_page') ? 'active':''}}"><a href="{{route('subscription_ur_page')}}" class="menu-item"> Plans</a>
                            </li>
                        </ul>
                    </li>


                    <li class="{{Route::is('form_video_page') ? 'active':''}} nav-item"><a href="{{route('form_video_page')}}"><i class="fa fa-film"></i><span data-i18n="" class="menu-title">Forms/Videos</span></a>
                    </li>
                    <li class="{{Route::is('podcast_page') ? 'active':''}} nav-item"><a href="{{route('podcast_page')}}"><i class="fa ft-video"></i><span data-i18n="" class="menu-title">Podcast</span></a>
                    </li>


                </ul>
            </div>
        </div>
        <!-- main menu content-->
        <div class="sidebar-background"></div>
        <!-- main menu footer-->
        <!-- include includes/menu-footer-->
        <!-- main menu footer-->
    </div>
    <!-- / main menu-->


    <!-- Navbar (Header) Starts-->
    <nav class="navbar navbar-expand-lg navbar-light bg-faded header-navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a aria-controls="navbarSupportedContent" href="javascript:;" class="open-navbar-container black"><i class="ft-more-vertical"></i></a></span>
                <form role="search" class="navbar-form navbar-right mt-1">
                    <div class="position-relative has-icon-right">
                        <input type="text" placeholder="Search" class="form-control round"/>
                        <div class="form-control-position"><i class="ft-search"></i></div>
                    </div>
                </form>
            </div>

            <?php $user = Auth::user(); ?>
            <div class="navbar-container">
                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item mr-2 d-none d-lg-block"><a id="navbar-fullscreen" href="javascript:;" class="nav-link apptogglefullscreen"><i class="ft-maximize font-medium-3 blue-grey darken-4"></i>
                                <p class="d-none">fullscreen</p></a></li>
                        <li class="dropdown nav-item">
                            <a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative" style="display: inline-flex"><p class="mt-2 mr-3"><b>{{$user->name}}</b></p>
                                @if($user->avatar)
                                    <img class="media-object d-flex mr-3 round-media" src="{{asset('uploads/avatars')}}/{{$user->avatar}}" alt="Generic placeholder image" style="width: 50px;height: 50px;border-radius: 50%;border: 3px solid #3eaef3;">
                                @else
                                    <img class="media-object d-flex mr-3 round-media" src="{{asset('app-assets/img/default-avatar.png')}}" alt="Generic placeholder image" style="width: 50px;height: 50px;border-radius: 50%;border: 3px solid #3eaef3;">
                                @endif
                            </a>
                            <div aria-labelledby="dropdownBasic3" class="dropdown-menu text-left dropdown-menu-right">
                                <a href="{{route('profile_page')}}" class="dropdown-item py-1"><i class="ft-settings mr-2"></i><span>User Settings</span></a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ft-power mr-2"></i><span>Logout</span></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </div>
                        </li>


                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar (Header) Ends-->

    <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
            @yield('content')
        </div>
        <!-- END : End Main Content-->

        <!-- BEGIN : Footer-->
        <footer class="footer footer-static footer-light">
            <p class="clearfix text-muted text-sm-center px-2"><span> 2019 - 2020 <a href="#" id="pixinventLink" target="_blank" class="text-bold-800 primary darken-2">Lee Bin </a>, All rights reserved. </span></p>
        </footer>
        <!-- End : Footer-->

    </div>
</div>
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
@yield('script')
<script>
    $('.alert-success').fadeIn().delay(5000).fadeOut();
    $('[data-toggle="tooltip"]').tooltip()
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('app-assets/js/enable-datepicker.js')}}"></script>

<!-- BEGIN APEX JS-->
<script src="{{asset('app-assets/js/app-sidebar.js')}}" type="text/javascript"></script>
<!-- END APEX JS-->
</body>
<!-- END : Body-->
</html>