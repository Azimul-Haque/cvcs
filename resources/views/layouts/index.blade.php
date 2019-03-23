<!doctype html>
<html class="no-js" lang="en">

<head>
    <title>@yield('title')</title>
    <meta name="description" content="Official website of CVCS, Custom and Vat Cooperative Society. Developed by A. H. M. Azimul Haque.">
    <meta name="keywords" content="CVCS, Bangladesh Customs">
    <meta charset="utf-8">
    <meta name="author" content="A. H. M. Azimul Haque">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('vendor/hcode/images/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('vendor/hcode/images/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('vendor/hcode/images/apple-touch-icon-114x114.png') }}">
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
          src: url({{ asset('font/kalpurush.ttf') }});
        }
        body, h1, h2, h3, h4, h5, h6, p, a, span, li, td {
            font-family: kalpurush;
        }
    </style>
</head>

<body>

    @extends('partials._nav')

    <main style="min-height: 400px;">
        @yield('content')
    </main>

    <!-- footer -->
    <footer>
        <div class=" bg-white footer-top">
            <div class="container">
                <div class="row margin-four">
                    <!-- phone -->
                    <div class="col-md-4 col-sm-4 text-center">
                        <i class="icon-phone small-icon black-text"></i>
                        <h6 class="black-text margin-two no-margin-bottom">+88 017********</h6>
                    </div>
                    <!-- end phone -->
                    <!-- address -->
                    <div class="col-md-4 col-sm-4 text-center">
                        <i class="icon-map-pin small-icon black-text"></i>
                        <h6 class="black-text margin-two no-margin-bottom">Dhaka, Bangladesh</h6>
                    </div>
                    <!-- end address -->
                    <!-- email -->
                    <div class="col-md-4 col-sm-4 text-center">
                        <i class="icon-envelope small-icon black-text"></i>
                        <h6 class="margin-two no-margin-bottom">
                            <a href="mailto:no-reply@cvcsbd.com" class="black-text">info@cvcsbd.com</a>
                        </h6>
                    </div>
                    <!-- end email -->
                </div>
            </div>
        </div>
        <div class="container footer-middle">
            <div class="row">
                <div class="col-md-3 col-sm-3 footer-link1 xs-display-none">
                    <!-- headline -->
                    <h5>সিভিসিএস</h5>
                    <!-- end headline -->
                    <!-- text -->
                    <p class="footer-text">কাস্টোমস অ্যান্ড ভ্যাট কো=অপারেটিভ সোসাইটি</p>
                    <!-- end text -->
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4 footer-link2 col-md-offset-3">
                    
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4  footer-link3">
                    
                </div>
                <div class="col-md-2 col-sm-3 col-xs-4  footer-link4">
                    
                </div>
            </div>
            <div class="wide-separator-line bg-mid-gray no-margin-lr margin-three no-margin-bottom"></div>
            <div class="row margin-four no-margin-bottom">
                <div class="col-md-6 col-sm-12 sm-text-center sm-margin-bottom-four">
                    <!-- link -->
                    <ul class="list-inline footer-link text-uppercase">
                        <li>
                            <a href="{{ route('blogs.index') }}">নোটিশ</a>
                        </li>
                        <li>
                            <a href="{{ route('index.news') }}">গ্যালারি</a>
                        </li>
                        <li>
                            <a href="{{ route('index.events') }}">ইভেন্ট</a>
                        </li>
                    </ul>
                    <!-- end link -->
                </div>
                <div class="col-md-6 col-sm-12 footer-social text-right sm-text-center">
                    <!-- social media link -->
                    <a target="_blank" href="https://www.facebook.com/">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a target="_blank" href="https://twitter.com/">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a target="_blank" href="https://plus.google.com/">
                        <i class="fa fa-google-plus"></i>
                    </a>
                    <a target="_blank" href="https://www.youtube.com/">
                        <i class="fa fa-youtube"></i>
                    </a>
                    <a target="_blank" href="https://www.linkedin.com/">
                        <i class="fa fa-linkedin"></i>
                    </a>
                    <!-- end social media link -->
                </div>
            </div>
        </div>
        <div class="container-fluid bg-dark-gray footer-bottom">
            <div class="container">
                <div class="row margin-three">
                    <!-- copyright -->
                    <div class="col-md-6 col-sm-6 col-xs-12 copyright text-left letter-spacing-1 xs-text-center xs-margin-bottom-one">
                        &copy; {{ date('Y') }} CVCS. Developed by...
                    </div>
                    <!-- end copyright -->
                    <!-- logo -->
                    <div class="col-md-6 col-sm-6 col-xs-12 footer-logo text-right xs-text-center">
                        <a href="{{ route('index.index') }}">
                            <img src="{{ asset('images/custom.png') }}" alt="" />
                        </a>
                    </div>
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
    <script type="text/javascript" src="{{ asset('vendor/hcode/js/page-scroll.js') }}"></script>
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

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5c954f9c101df77a8be4044a/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
</body>

<!-- Mirrored from www.themezaa.com/html/h-code/portfolio-short-description.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Sep 2018 20:27:12 GMT -->

</html>