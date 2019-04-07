<nav class="navbar navbar-default navbar-fixed-top overlay-nav nav-white nav-transparent sticky-nav nav-border-bottom nav-shadow bg-royal-blue" role="navigation">
    <div class="container">
        <div class="row">
            <!-- logo -->
            <div class="col-md-2 pull-left">
                <a class="logo-light" href="{{ route('index.index') }}">
                    <img alt="" src="{{ asset('images/custom.png') }}" class="logo" style="max-height: 60px;" />
                </a>
                <a class="logo-dark" href="{{ route('index.index') }}">
                    <img alt="" src="{{ asset('images/custom_dark.png') }}" class="logo" style="max-height: 60px;" /> {{-- kaaj ta korte hobe --}}
                </a>
            </div>
            <!-- end logo -->
            <!-- search and cart  -->
           <!--  <div class="col-md-1 no-padding-left search-cart-header pull-right">
               <div id="top-search">
                   nav search
                   <a href="#search-header" class="header-search-form">
                       <i class="fa fa-search search-button"></i>
                   </a>
                   end nav search
               </div>
               search input
               <form id="search-header" method="post" action="#" name="search-header" class="mfp-hide search-form-result">
                   <div class="search-form position-relative">
                       <button type="submit" class="fa fa-search close-search search-button"></button>
                       <input type="text" name="search" class="search-input" placeholder="Enter your keywords..." autocomplete="off">
                   </div>
               </form>
           
           </div> -->
            <!-- end search and cart  -->
            <!-- toggle navigation -->
            <div class="navbar-header col-sm-8 col-xs-2 pull-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- toggle navigation end -->
            <!-- main menu -->
            <div class="col-md-9 no-padding-right accordion-menu text-right">
                <div class="navbar-collapse collapse">
                    <ul id="accordion" class="nav navbar-nav navbar-right panel-group main-menu">
                        <li>
                            <a href="{{ route('index.index') }}">হোম</a>
                        </li>
                        
                        <li class="dropdown panel simple-dropdown">
                            <a href="#nav_abouts" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">
                                এবাউট ▾
                            </a>
                            <ul id="nav_abouts" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="{{ route('index.about') }}" class="text-large">সিভিসিএস সম্পর্কে</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.previouscommittee') }}" class="text-large">পূর্বতন কমিটি</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.currentcommittee') }}" class="text-large">বর্তমান কমিটি</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('index.gallery') }}">গ্যালারি</a>
                        </li>
                        <li>
                            <a href="{{ route('index.events') }}">ইভেন্ট</a>
                        </li>
                        <li>
                            <a href="{{ route('index.notice') }}">নোটিশ</a>
                        </li>
                        <!-- <li>
                            <a href="{{ route('index.members') }}">Members</a>
                        </li>
                        <li>
                            <a href="{{ route('blogs.index') }}">Blog</a>
                        </li> -->
                        <li class="dropdown panel simple-dropdown">
                            <a href="#nav_others" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">
                                কার্যক্রমসমূহ ▾
                            </a>
                            <!-- sub menu single -->
                            <!-- sub menu item  -->
                            <ul id="nav_others" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="{{ route('index.business_entitny') }}" class="text-large">বিজনেস এন্টিটি</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.product_services') }}" class="text-large">প্রোডাক্ট/ সার্ভিসেস</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.welfare') }}" class="text-large">ওয়েলফেয়ার</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('index.faq') }}">FAQs</a>
                        </li>
                        <li>
                            <a href="{{ route('index.contact') }}">যোগাযোগ</a>
                        </li>
                        @if(Auth::check())
                        <li class="dropdown panel simple-dropdown">
                            <a href="#nav_auth_user" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">
                                @php
                                    $nav_user_name = explode(' ', Auth::user()->name_bangla);
                                    $last_name = array_pop($nav_user_name);
                                @endphp
                                {{ $last_name }} ▾
                            </a>
                            <!-- sub menu single -->
                            <!-- sub menu item  -->
                            <ul id="nav_auth_user" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="@if(Auth::user()->role == 'admin') {{ route('dashboard.index') }} @else {{ route('dashboard.profile') }} @endif" class="text-large"><i class="icon-speedometer i-plain"></i> ড্যাশবোর্ড</a>
                                </li>
                                <li>
                                    <a href="{{ route('index.profile', Auth::user()->unique_key) }}" class="text-large"><i class="icon-profile-male i-plain"></i> প্রোফাইল</a>
                                </li>
                                <li>
                                    <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" class="text-large"><i class="icon-key i-plain"></i> লগআউট</a>
                                </li>
                            </ul>
                        </li>
                        @else
                        <li class="dropdown panel simple-dropdown">
                            <a href="#nav_membership" class="dropdown-toggle collapsed" data-toggle="collapse" data-parent="#accordion" data-hover="dropdown">সদস্যপদ ▾</a>
                            <!-- sub menu single -->
                            <!-- sub menu item  -->
                            <ul id="nav_membership" class="dropdown-menu panel-collapse collapse" role="menu">
                                <li>
                                    <a href="{{ route('index.application') }}" class="text-large"><i class="icon-profile-male i-plain"></i> সদস্যপদ আবেদন</a>
                                </li>
                                <li>
                                    <a href="{{ url('login') }}" class="text-large"><i class="icon-key i-plain"></i> লগইন</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <!-- end menu item -->
                    </ul>
                </div>
            </div>
            <!-- end main menu -->
        </div>
    </div>
</nav>
<!--end navigation panel