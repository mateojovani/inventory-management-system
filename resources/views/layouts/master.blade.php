<!DOCTYPE html>
<html>
<head>

    <!-- Title -->
    <title>@yield('title')</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <meta name="description" content="Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    @yield('sources_top')
    <style>
        .custom-input{padding: 5px; margin-right: 5px}
    </style>

</head>
<body class="page-header-fixed">

<form class="search-form" action="#" method="GET">
    <div class="input-group">
        <input type="text" name="search" class="form-control search-input" placeholder="Search...">
        <span class="input-group-btn">
                    <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
        </span>
    </div><!-- Input Group -->
</form><!-- Search Form -->

<main class="page-content content-wrap">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="sidebar-pusher">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="logo-box">
                <a href="{{URL::asset('/')}}" class="logo-text"><span>Inventory</span></a>
            </div><!-- Logo Box -->
            <div class="search-button">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
            </div>
            <div class="topmenu-outer">
                <div class="top-menu">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic">
                                <span class="bfh-languages" data-language="{{session('lang_detail')}}" data-flags="true"></span>
                            </a>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                <span class="user-name">{{Auth::user()->username}}<i class="fa fa-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu dropdown-list" role="menu">
                                <li role="presentation"><a href="{{URL::asset('/profile')}}"><i class="fa fa-user"></i>Profile</a></li>
                                <li role="presentation"><a href="{{URL::asset('/logout')}}"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                            </ul>
                        </li>
                    </ul><!-- Nav -->
                </div><!-- Top Menu -->
            </div>
        </div>
    </div><!-- Navbar -->
    <div class="page-sidebar sidebar">
        <div class="page-sidebar-inner slimscroll">

            <ul class="menu accordion-menu">
                <li @yield('db')><a href="{{URL::asset('/')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>{{trans('ui.side_menu.dashboard')}}</p></a></li>
                <li @yield('rm')>
                    <a href="{{URL::asset('/raw-materials')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-scissors"></span><p>{{trans('ui.side_menu.raw_materials')}}</p></a>
                </li>
                <li @yield('pr')>
                    <a href="{{URL::asset('/products')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-book"></span><p>{{trans('ui.side_menu.products')}}</p></a>
                </li>
                <li @yield('cf')>
                    <a href="{{URL::asset('/configure')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-wrench"></span><p>{{trans('ui.side_menu.configure')}}</p></a>
                </li>
                <li @yield('cl')>
                    <a href="{{URL::asset('/clients')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>{{trans('ui.side_menu.clients')}}</p></a>
                </li>
                <li @yield('fu')>
                    <a href="{{URL::asset('/furnishers')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-sort-by-attributes-alt"></span><p>{{trans('ui.side_menu.furnishers')}}</p></a>
                </li>
                <li @yield('en')>
                    <a href="{{URL::asset('/entrysheet')}}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-list-alt"></span><p>{{trans('ui.side_menu.entrysheet')}}</p></a>
                </li>
            </ul>
        </div><!-- Page Sidebar Inner -->
    </div><!-- Page Sidebar -->
    <div class="page-inner">
        <div id="main-wrapper">
            @yield('main')
        </div><!-- Main Wrapper -->
        <div class="page-footer">
            <p class="no-s">2016 &copy; Inventory</p>
        </div>
    </div><!-- Page Inner -->
</main><!-- Page Content -->

@yield('sources_bottom')
</body>
</html>