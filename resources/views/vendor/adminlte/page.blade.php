@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li class="tasks-menu">
                            <a href="{{ url('/') }}" target="_blank" title="View Website" data-placement="bottom">
                                <i class="fa fa-fw fa-eye" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            @if((Auth::User()->image != '') && (file_exists(public_path('images/users/'.Auth::User()->image))))
                              <img src="{{ asset('images/users/'.Auth::User()->image)}}" class="user-image" alt="{{ Auth::User()->name_bangla }}-এর মুখছবি">
                            @else
                              <img src="{{ asset('images/user.png')}}" class="user-image" alt="{{ Auth::User()->name_bangla }}-এর মুখছবি">
                            @endif
                            
                            {{ Auth::User()->name_bangla }}</a>
                            <ul class="dropdown-menu" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                              <!-- User image -->
                              <li class="user-header">
                                @if((Auth::User()->image != '') && (file_exists(public_path('images/users/'.Auth::User()->image))))
                                  <img src="{{ asset('images/users/'.Auth::User()->image)}}" class="img-circle" alt="{{ Auth::User()->name_bangla }}-এর মুখছবি">
                                @else
                                  <img src="{{ asset('images/user.png') }}" class="img-circle" alt="{{ Auth::User()->name_bangla }}-এর মুখছবি">
                                @endif
                                <p>
                                  {{ Auth::User()->name_bangla }}
                                  <small>সদস্যপদ প্রাপ্তিঃ {{ date('F, Y', strtotime(Auth::User()->created_at)) }}</small>
                                </p>
                              </li>
                              <!-- Menu Body -->
                              <li class="user-body">
                                {{-- <div class="row">
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                  </div>
                                </div> --}}
                                <!-- /.row -->
                              </li>
                              <!-- Menu Footer-->
                              <li class="user-footer">
                                <div class="pull-left">
                                  <a href="{{ route('dashboard.profile') }}" class="btn btn-default btn-flat"><i class="fa fa-fw fa-user-o"></i> প্রোফাইল</a>
                                </div>
                                <div class="pull-right">
                                  @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                      <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" class="btn btn-default btn-flat">
                                          <i class="fa fa-fw fa-power-off"></i> লগ আউট
                                      </a>
                                  @else
                                      <a href="#"
                                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                                          <i class="fa fa-fw fa-power-off"></i> লগ আউট
                                      </a>
                                      <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;" class="btn btn-default btn-flat">
                                          @if(config('adminlte.logout_method'))
                                              {{ method_field(config('adminlte.logout_method')) }}
                                          @endif
                                          {{ csrf_field() }}
                                      </form>
                                  @endif
                                </div>
                              </li>
                            </ul>                            
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    {{-- @each('adminlte::partials.menu-item', $adminlte->menu(), 'item') --}}
                    @if(Auth::user()->role == 'admin')
                    <li class="header">ড্যাশবোর্ড</li>
                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.index') }}">
                            <i class="fa fa-fw fa-tachometer"></i>
                            <span>ড্যাশবোর্ড</span>
                        </a>
                    </li>
                    @if(Auth::user()->role_type == 'admin')
                    <li class="{{ Request::is('dashboard/admins') ? 'active menu-open' : '' }} {{ Request::is('dashboard/admins/create') ? 'active menu-open' : '' }} {{ Request::is('dashboard/bulk/payers') ? 'active menu-open' : '' }} {{ Request::is('dashboard/bulk/payers/create') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-key"></i>
                          <span>অ্যাডমিন ও অন্যান্য</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{ Request::is('dashboard/admins') ? 'active' : '' }} {{ Request::is('dashboard/admins/create') ? 'active' : '' }}"><a href="{{ route('dashboard.admins') }}"><i class="fa fa-user-secret"></i> অ্যাডমিনগণ</a></li>
                        <li class="{{ Request::is('dashboard/bulk/payers') ? 'active' : '' }} {{ Request::is('dashboard/bulk/payers/create') ? 'active' : '' }}"><a href="{{ route('dashboard.bulkpayers') }}"><i class="fa fa-users"></i> একাধিক পরিশোধকারীগণ</a></li>
                      </ul>
                    </li>
                    @endif
                    <li class="header">হোমপেইজ কাস্টমাইজেশন</li>
                    <li class="{{ Request::is('dashboard/committee') ? 'active menu-open' : '' }} {{ Request::is('dashboard/abouts') ? 'active menu-open' : '' }} {{ Request::is('dashboard/gallery') ? 'active menu-open' : '' }} {{ Request::is('dashboard/gallery/*') ? 'active menu-open' : '' }} {{ Request::is('dashboard/events') ? 'active menu-open' : '' }} {{ Request::is('dashboard/notice') ? 'active menu-open' : '' }} {{ Request::is('dashboard/form/messages') ? 'active menu-open' : '' }} {{ Request::is('dashboard/slider') ? 'active menu-open' : '' }} {{ Request::is('dashboard/faq') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-cogs"></i>
                          <span>হোমপেইজ কাস্টমাইজেশন</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{ Request::is('dashboard/committee') ? 'active' : '' }}"><a href="{{ route('dashboard.committee') }}"><i class="fa fa-coffee"></i> কমিটি</a></li>
                        <li class="{{ Request::is('dashboard/slider') ? 'active' : '' }}"><a href="{{ route('dashboard.slider') }}"><i class="fa fa-list-alt"></i> স্লাইডার</a></li>
                        <li class="{{ Request::is('dashboard/abouts') ? 'active' : '' }}"><a href="{{ route('dashboard.abouts') }}"><i class="fa fa-pencil"></i> তথ্য এবং টেক্সট</a></li>
                        <li class="{{ Request::is('dashboard/gallery') ? 'active' : '' }} {{ Request::is('dashboard/gallery/*') ? 'active' : '' }}"><a href="{{ route('dashboard.gallery') }}"><i class="fa fa-picture-o"></i> গ্যালারি</a></li>
                        <li class="{{ Request::is('dashboard/events') ? 'active' : '' }}"><a href="{{ route('dashboard.events') }}"><i class="fa fa-bullhorn"></i> ইভেন্ট</a></li>
                        <li class="{{ Request::is('dashboard/notice') ? 'active' : '' }}"><a href="{{ route('dashboard.notice') }}"><i class="fa fa-bell-o"></i> নোটিশ</a></li>
                        <li class="{{ Request::is('dashboard/faq') ? 'active' : '' }}"><a href="{{ route('dashboard.faq') }}"><i class="fa fa-question-circle-o"></i> FAQ</a></li>
                        <li class="{{ Request::is('dashboard/form/messages') ? 'active' : '' }}"><a href="{{ route('dashboard.formmessage') }}"><i class="fa fa-envelope-o"></i> ফরম মেসেজ</a></li>
                      </ul>
                    </li>

                    <li class="header">মেম্বারশিপ ম্যানেজমেন্ট</li>
                    <li class="{{ Request::is('dashboard/applications') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.applications') }}">
                            <i class="fa fa-fw fa-user-plus"></i>
                            <span>আবেদনসমূহ</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('dashboard/members') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.members') }}">
                            <i class="fa fa-fw fa-users"></i>
                            <span>সদস্যগণ</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('dashboard/members/payments/pending') ? 'active menu-open' : '' }} {{ Request::is('dashboard/members/payments/approved') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-handshake-o"></i>
                          <span>পরিশোধসমূহ</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{ Request::is('dashboard/members/payments/pending') ? 'active' : '' }}"><a href="{{ route('dashboard.memberspendingpayments') }}"><i class="fa fa-hourglass-start"></i> প্রক্রিয়াধীন পরিশোধসমূহ</a></li>
                        <li class="{{ Request::is('dashboard/members/payments/approved') ? 'active' : '' }}"><a href="{{ route('dashboard.membersapprovedpayments') }}"><i class="fa fa-check-square-o"></i> অনুমোদিত পরিশোধসমূহ</a></li>
                      </ul>
                    </li>
                    @endif
                    
                    @if((Auth::user()->role == 'admin') || (Auth::user()->role == 'member'))
                    <li class="header">একাউন্ট ম্যানেজমেন্ট (ব্যক্তিগত)</li>
                    <li class="{{ Request::is('dashboard/profile') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.profile') }}">
                            <i class="fa fa-fw fa-user"></i>
                            <span>ব্যক্তিগত প্রোফাইল</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('dashboard/member/payment') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.memberpayment') }}">
                            <i class="fa fa-fw fa-handshake-o"></i>
                            <span>পরিশোধ</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('dashboard/member/transaction/summary') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.membertransactionsummary') }}">
                            <i class="fa fa-fw fa-bar-chart"></i>
                            <span>লেনদেন বিবরণ</span>
                        </a>
                    </li>
                    @endif
                    
                    @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'bulkpayer'))
                    <li class="header">একাধিক পরিশোধ সংক্রান্ত</li>
                    <li class="{{ Request::is('dashboard/member/payment/bulk') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.memberpaymentbulk') }}">
                            <i class="fa fa-fw fa-cubes"></i>
                            <span>একাধিক পরিশোধ</span>
                        </a>
                    </li>
                    @endif
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.28
          </div>
          <strong>Copyright © {{ date('Y') }}</strong> 
          All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script type="text/javascript">
      $(function(){
       $('a[title]').tooltip();
       $('button[title]').tooltip();
      });
    </script>
    @stack('js')
    @yield('js')
@stop
