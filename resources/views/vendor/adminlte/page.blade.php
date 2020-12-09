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
                        <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="navbar-brand">
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
            <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                  <img src="{{ asset('images/custom.png') }}" style="height: 30px; width: auto;">
                  {{-- {!! config('adminlte.logo_mini', '<b>A</b>LT') !!} --}}
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                  <img src="{{ asset('images/custom.png') }}" style="height: 30px; width: auto;"> 
                  {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                </span>
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
                        @if(Auth::user()->role == 'admin') {{-- eita apatoto, karon kichudin por eita normal user er jonnou kora hobe --}}
                        <li class="dropdown notifications-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bell-o"></i>
                            @if($notifcount > 0)
                            <span class="label label-warning">{{ $notifcount }}</span>
                            @endif
                          </a>
                          <ul class="dropdown-menu">
                            @if($notifcount > 0)
                              <li class="header">{{ $notifcount }} টি নোটিফিকেশন আছে</li>
                            @else
                              <li class="header">কোন নোটিফিকেশন নেই!</li>
                            @endif
                            
                            <li>
                              <!-- inner menu: contains the actual data -->
                              <ul class="menu">
                                @if($notifpendingapplications > 0)
                                  <li>
                                    <a href="{{ route('dashboard.applications') }}">
                                      <i class="fa fa-users text-aqua"></i> {{ $notifpendingapplications }} জন নিবন্ধন আবেদন করেছেন
                                    </a>
                                  </li>
                                @endif

                                @if($notifdefectiveapplications > 0)
                                  <li>
                                    <a href="{{ route('dashboard.defectiveapplications') }}">
                                      <i class="fa fa-exclamation-triangle text-maroon"></i> {{ $notifdefectiveapplications }} টি অসম্পূর্ণ আবেদন আছে
                                    </a>
                                  </li>
                                @endif

                                @if($notifpendingpayments > 0)
                                  <li>
                                    <a href="{{ route('dashboard.memberspendingpayments') }}">
                                      <i class="fa fa-hourglass-start text-yellow"></i> {{ $notifpendingpayments }} টি প্রক্রিয়াধীন পরিশোধ রয়েছে
                                    </a>
                                  </li>
                                @endif

                                @if($notiftempmemdatas > 0)
                                  <li>
                                    <a href="{{ route('dashboard.membersupdaterequests') }}">
                                      <i class="fa fa-pencil-square-o text-green"></i> {{ $notiftempmemdatas }} টি তথ্য হালনাগাদ অনুরোধ
                                    </a>
                                  </li>
                                @endif 

                                @if($notifsmsbalance > 0 && $notifsmsbalance < 21)
                                  <li>
                                    <a href="#">
                                      <i class="fa fa-envelope-o text-red"></i> অপর্যাপ্ত SMS ব্যালেন্সঃ ৳ {{ $notifsmsbalance }}
                                    </a>
                                  </li>
                                @endif                                
                              </ul>
                            </li>
                            <li class="footer"><a href="{{ route('dashboard.notifications') }}">সব দেখুন</a></li>
                          </ul>
                        </li>
                        @endif
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
                      {{-- <li class="header">ড্যাশবোর্ড</li> --}}
                      <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                          <a href="{{ route('dashboard.index') }}">
                              <i class="fa fa-fw fa-tachometer"></i>
                              <span>ড্যাশবোর্ড</span>
                          </a>
                      </li>
                      
                      <li class="{{ Request::is('dashboard/branches/payments') ? 'active menu-open' : '' }} {{ Request::is('dashboard/donors') ? 'active menu-open' : '' }} {{ Request::is('dashboard/donor/*') ? 'active menu-open' : '' }} {{ Request::is('dashboard/admins') ? 'active menu-open' : '' }} {{ Request::is('dashboard/admins/create') ? 'active menu-open' : '' }} {{ Request::is('dashboard/bulk/payers') ? 'active menu-open' : '' }} {{ Request::is('dashboard/bulk/payers/create') ? 'active menu-open' : '' }} {{ Request::is('dashboard/branches') ? 'active menu-open' : '' }} {{ Request::is('dashboard/branch/*') ? 'active menu-open' : '' }} {{ Request::is('dashboard/designations') ? 'active menu-open' : '' }} {{ Request::is('dashboard/designation/*') ? 'active menu-open' : '' }} treeview">
                        <a href="#">
                            <i class="fa fa-fw fa-key"></i>
                            <span>অ্যাডমিন কার্যক্রম</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                          @if((Auth::user()->role_type == 'admin') && (Auth::user()->email != 'dataentry@cvcsbd.com'))
                          <li class="{{ Request::is('dashboard/admins') ? 'active' : '' }} {{ Request::is('dashboard/admins/create') ? 'active' : '' }}"><a href="{{ route('dashboard.admins') }}"><i class="fa fa-user-secret text-aqua"></i> অ্যাডমিনগণ</a></li>
                          <li class="{{ Request::is('dashboard/bulk/payers') ? 'active' : '' }} {{ Request::is('dashboard/bulk/payers/create') ? 'active' : '' }}"><a href="{{ route('dashboard.bulkpayers') }}"><i class="fa fa-users text-yellow"></i> একাধিক পরিশোধকারীগণ</a></li>
                          @endif
                          <li class="{{ Request::is('dashboard/donors') ? 'active' : '' }} {{ Request::is('dashboard/donor/*') ? 'active' : '' }}"><a href="{{ route('dashboard.donors') }}"><i class="fa fa-trophy text-lightgreen"></i> ডোনেশন</a></li>
                          <li class="{{ Request::is('dashboard/branches/payments') ? 'active' : '' }}"><a href="{{ route('dashboard.branches.payments') }}"><i class="fa fa-list-ol text-green"></i> বিল অব এন্ট্রি</a></li>
                          <li class="{{ Request::is('dashboard/branches') ? 'active' : '' }} {{ Request::is('dashboard/branch/*') ? 'active' : '' }}"><a href="{{ route('dashboard.branches') }}"><i class="fa fa-home text-aqua"></i> দপ্তর সমূহ</a></li>
                          <li class="{{ Request::is('dashboard/designations') ? 'active' : '' }} {{ Request::is('dashboard/designation/*') ? 'active' : '' }}"><a href="{{ route('dashboard.designations') }}"><i class="fa fa-id-card-o text-lightgreen"></i> পদবি সমূহ</a></li>
                        </ul>
                      </li>
                      
                      {{-- <li class="header">হোমপেইজ কাস্টমাইজেশন</li> --}}
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
                    @endif

                    @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'manager') || (Auth::user()->role_type == 'bulkpayer'))
                      {{-- <li class="header">মেম্বারশিপ ম্যানেজমেন্ট</li> --}}
                      <li class="{{ Request::is('dashboard/applications') ? 'active menu-open' : '' }} {{ Request::is('dashboard/defective/applications') ? 'active menu-open' : '' }} {{ Request::is('dashboard/application/*') ? 'active menu-open' : '' }} {{ Request::is('dashboard/member/*') ? 'active menu-open' : '' }} {{ Request::is('dashboard/members') ? 'active menu-open' : '' }} {{ Request::is('dashboard/members/payments/pending') ? 'active menu-open' : '' }} {{ Request::is('dashboard/members/payments/approved') ? 'active menu-open' : '' }} {{ Request::is('dashboard/members/payments/disputed') ? 'active menu-open' : '' }} {{ Request::is('dashboard/members/update/requests') ? 'active menu-open' : '' }} treeview">
                        <a href="#">
                            <i class="fa fa-fw fa-handshake-o"></i>
                            <span>মেম্বারশিপ ম্যানেজমেন্ট</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                          <li class="{{ Request::is('dashboard/applications') ? 'active' : '' }}"><a href="{{ route('dashboard.applications') }}"><i class="fa fa-user-plus"></i> আবেদনসমূহ</a></li>
                          <li class="{{ Request::is('dashboard/defective/applications') ? 'active' : '' }}"><a href="{{ route('dashboard.defectiveapplications') }}"><i class="fa fa-exclamation-triangle"></i> অসম্পূর্ণ আবেদনসমূহ</a></li>
                          <li class="{{ Request::is('dashboard/members') ? 'active' : '' }}"><a href="{{ route('dashboard.members') }}"><i class="fa fa-users"></i><span> সদস্যগণ</span></a></li>
                          @if(Auth::user()->role == 'admin')
                          <li class="{{ Request::is('dashboard/members/payments/pending') ? 'active' : '' }}"><a href="{{ route('dashboard.memberspendingpayments') }}"><i class="fa fa-hourglass-start"></i> প্রক্রিয়াধীন পরিশোধসমূহ</a></li>
                          <li class="{{ Request::is('dashboard/members/payments/approved') ? 'active' : '' }}"><a href="{{ route('dashboard.membersapprovedpayments') }}"><i class="fa fa-check-square-o"></i> অনুমোদিত পরিশোধসমূহ</a></li>
                          <li class="{{ Request::is('dashboard/members/payments/disputed') ? 'active' : '' }}"><a href="{{ route('dashboard.membersdisputedpayments') }}"><i class="fa fa-exclamation-triangle"></i> অনিষ্পন্ন পরিশোধসমূহ</a></li>
                          <li class="{{ Request::is('dashboard/members/update/requests') ? 'active' : '' }}"><a href="{{ route('dashboard.membersupdaterequests') }}"><i class="fa fa-pencil-square"></i> তথ্য পরিবর্তন অনুরোধসমূহ</a></li>
                          @endif
                        </ul>
                      </li>
                    @endif
                    
                    @if((Auth::user()->role == 'admin') || (Auth::user()->role == 'member'))
                      {{-- <li class="header">একাউন্ট ম্যানেজমেন্ট (ব্যক্তিগত)</li> --}}
                      <li class="{{ Request::is('dashboard/profile') ? 'active menu-open' : '' }} {{ Request::is('dashboard/member/payment') ? 'active menu-open' : '' }} {{ Request::is('dashboard/member/payment/self') ? 'active menu-open' : '' }} {{ Request::is('dashboard/member/payment/self/online') ? 'active menu-open' : '' }} {{ Request::is('dashboard/member/transaction/summary') ? 'active menu-open' : '' }} {{ Request::is('dashboard/member/change/password') ? 'active menu-open' : '' }} treeview">
                        <a href="#">
                            <i class="fa fa-fw fa-wrench"></i>
                            <span>একাউন্ট ম্যানেজমেন্ট (ব্যক্তিগত)</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                          <li class="{{ Request::is('dashboard/profile') ? 'active' : '' }}">
                              <a href="{{ route('dashboard.profile') }}">
                                  <i class="fa fa-fw fa-user"></i>
                                  <span>ব্যক্তিগত প্রোফাইল</span>
                              </a>
                          </li>
                          <li class="{{ Request::is('dashboard/member/payment') ? 'active' : '' }} {{ Request::is('dashboard/member/payment/self') ? 'active' : '' }} {{ Request::is('dashboard/member/payment/self/online') ? 'active' : '' }}">
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
                          <li class="{{ Request::is('dashboard/member/change/password') ? 'active' : '' }}">
                              <a href="{{ route('dashboard.member.getchangepassword') }}">
                                  <i class="fa fa-fw fa-lock"></i>
                                  <span>পাসওয়ার্ড পরিবর্তন</span>
                              </a>
                          </li>
                        </ul>
                      </li>
                    @endif
                    

                    
                    @if(Auth::user()->role_type == 'member' && Auth::user()->activation_status == 1)
                    <li class="{{ Request::is('dashboard/members/for/all') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.membersforall') }}">
                            <i class="fa fa-fw fa-users"></i>
                            <span>সদস্যগণ</span>
                        </a>
                    </li>
                    @endif

                    @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'manager') || (Auth::user()->role_type == 'bulkpayer'))
                    {{-- <li class="header">একাধিক পরিশোধ সংক্রান্ত</li> --}}
                    <li class="{{ Request::is('dashboard/member/payment/bulk') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.memberpaymentbulk') }}">
                            <i class="fa fa-fw fa-cubes"></i>
                            <span>একাধিক পরিশোধ</span>
                        </a>
                    </li>
                    @endif
                    @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'manager'))
                    <li class="{{ Request::is('dashboard/sms/*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.smsmodule') }}">
                            <i class="fa fa-fw fa-envelope-o"></i>
                            <span>SMS মডিউল</span>
                        </a>
                    </li>
                    @endif
                    @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'manager') || (Auth::user()->role_type == 'bulkpayer'))
                    <li class="{{ Request::is('dashboard/reports') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.reports') }}">
                            <i class="fa fa-fw fa-pie-chart"></i>
                            <span>রিপোর্ট</span>
                        </a>
                    </li>
                    @endif
                    <li class="{{ Request::is('dashboard/member/user/manual') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.memberusermanual') }}">
                            <i class="fa fa-fw fa-umbrella"></i>
                            <span>ব্যবহার বিধি</span>
                        </a>
                    </li>
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
