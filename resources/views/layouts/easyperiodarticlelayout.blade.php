<!doctype html>
<html class="no-js" lang="en">

<head>
    <title>@yield('title')</title>
    <meta name="description" content="EasyPeriod Period Tracker App. &copy; {{ date('Y') }} Copyright Reserved. Developed By A. H. M. Azimul Haque.">
    <meta name="keywords" content="EasyPeriod, Period Tracker">
    <meta charset="utf-8">
    <meta name="author" content="A. H. M. Azimul Haque">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
    
    <meta name="google-site-verification" content="M_ahWtl3h3gjjzpkH2T6nGc6JzWkbQlkOGy5J3oVEJY" />
    <meta name="google-site-verification" content="EKx16eUcw6_GT9tSfJux_-bXDfCMh1S3e3lzRQtZDN0" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146817361-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-146817361-1');
    </script>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/favicons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons//manifest.json') }}">
    <meta name="msapplication-TileColor" content="#022265">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicons/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#022265">
    <!-- animation -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/animate.css') }}" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/bootstrap.css') }}" />
    <!-- et line icon -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/et-line-icons.css') }}" />
    <!-- font-awesome icon -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/font-awesome.min.css') }}" />
    <!-- revolution slider -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/extralayers.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/settings.css') }}" />
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/magnific-popup.css') }}" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/owl.transitions.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/full-slider.css') }}" />
    <!-- text animation -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/text-effect.css') }}" />
    <!-- hamburger menu  -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/menu-hamburger.css') }}" />
    <!-- common -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/style.css') }}" />
    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('vendor/hcode/css/responsive.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}" />
    <!--[if IE]>
            <link rel="stylesheet" href="{{ asset('vendor/hcode/css/style-ie.css') }}" />
        <![endif]-->
    <!--[if IE]>
            <script src="{{ asset('vendor/hcode/js/html5shiv.js') }}"></script>
        <![endif]-->
    @yield('css')
    <style type="text/css">
        @font-face {
          font-family: kalpurush;
          src: url({{ asset('font/kalpurush.woff') }});
        }
        body, h1, h2, h3, h4, h5, h6, p, a, span, li, td, div {
            font-family: kalpurush;
        }
    </style>
</head>

<body>
    <main>
        @yield('content')
    </main>

    <!-- footer -->
    <footer>
        <div class="container-fluid bg-dark-gray footer-bottom">
            <div class="container">
                <div class="row margin-three">
                    <!-- copyright -->
                    <div class="col-md-6 col-sm-6 col-xs-12 copyright text-left letter-spacing-1 xs-text-center xs-margin-bottom-one">
                        &copy; {{ date('Y') }} EasyPeriod Team.
                    </div>
                    <!-- end copyright -->
                    <!-- logo -->
                    {{-- <div class="col-md-6 col-sm-6 col-xs-12 footer-logo text-right xs-text-center">
                        <a href="{{ route('index.index') }}">
                            <img src="{{ asset('images/custom.png') }}" alt="" />
                        </a>
                    </div> --}}
                    <!-- end logo -->
                </div>
            </div>
        </div>
        <!-- scroll to top -->
        <a href="javascript:;" class="scrollToTop">
            <i class="fa fa-angle-up"></i>
        </a>
        <!-- scroll to top End... -->
    </footer>
    <!-- end footer -->

    <!-- javascript libraries / javascript files set #1 -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/bootstrap-hover-dropdown.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.easing.1.3.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/skrollr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/smooth-scroll.js') }}"></script>
    <!-- jquery appear -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.appear.js') }}"></script>
    <!-- animation -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/wow.min.js') }}"></script>
    <!-- page scroll -->
    {{-- <script type="text/javascript" src="{{ asset('vendor/hcode/js/page-scroll.js') }}"></script> --}}
    <!-- easy piechart-->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.easypiechart.js') }}"></script>
    <!-- parallax -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.parallax-1.1.3.js') }}"></script>
    <!--portfolio with shorting tab -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.isotope.min.js') }}"></script>
    <!-- owl slider  -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/owl.carousel.min.js') }}"></script>
    <!-- magnific popup  -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.magnific-popup.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/popup-gallery.js') }}"></script>
    <!-- text effect  -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/text-effect.js') }}"></script>
    <!-- revolution slider  -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.revolution.js') }}"></script>
    <!-- counter  -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/counter.js') }}"></script>
    <!-- countTo -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.countTo.js') }}"></script>
    <!-- fit videos  -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.fitvids.js') }}"></script>
    <!-- imagesloaded  -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- hamburger menu-->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/classie.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/hamburger-menu.js') }}"></script>
    <!-- setting -->
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/main.js') }}"></script>
    @include('partials._messages')
    @yield('js')
</body>

<!-- Mirrored from www.themezaa.com/html/h-code/portfolio-short-description.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Sep 2018 20:27:12 GMT -->

</html>