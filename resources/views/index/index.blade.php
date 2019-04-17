@extends('layouts.index')
@section('title')
    কাস্টমস এন্ড ভ্যাট কর্মকর্তা-কর্মচারী সমবায় সমিতি (সিভিসিএস) লিমিটেড
@endsection

@section('css')
    {!!Html::style('css/wowslider/wowslider.css')!!}
    <style type="text/css">
        body {
            overflow: hidden;
        }

        /* Preloader */
        #preloader {
            position: fixed;
            top:0;
            left:0;
            right:0;
            bottom:0;
            background-color:#fff; /* change if the mask should have another color then white */
            z-index:99999;
        }

        #status {
            width:200px;
            height:200px;
            position:absolute;
            left:50%;
            top:50%;
            background-image:url({{ asset('images/3362406.gif') }}); /* path to your loading animation */
            background-repeat:no-repeat;
            background-position:center;
            margin:-100px 0 0 -100px;
        }
    </style>
@endsection

@section('content')
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <section class="no-padding content-top-margin">
        <div id="wowslider-container1">
            <div class="ws_images">
                <ul>
                    @foreach($sliders as $slider)
                        @if($slider->image != null)
                            @if(file_exists(public_path('images/slider/'. $slider->image)))
                            <li>
                                <img src="{{ asset('images/slider/'. $slider->image) }}" alt="{{ $slider->title }}" title="" id="wows1_0"/>
                                <span>{{ $slider->title }}</span>
                            </li>
                            @endif
                        @endif
                    @endforeach
                    
                </ul>
            </div>
            <div class="ws_bullets">
                <div>
                    @foreach($sliders as $slider)
                        @if($slider->image != null)
                            @if(file_exists(public_path('images/slider/'. $slider->image)))
                            <a href="#" title=""><span><img src="{{ asset('images/slider/'. $slider->image) }}" alt="{{ $slider->title }}" style="height: 50px; width: 150px;" /></span></a>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="ws_shadow"></div>
        </div>    
    </section>
    <section class="page-title bg-blue-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                    <!-- page title -->
                    <h1 class="white-text">কাস্টমস এন্ড ভ্যাট কর্মকর্তা-কর্মচারী সমবায় সমিতি লিমিটেড</h1>
                    <!-- end page title -->
                    <!-- page title tagline -->
                    <span class="white-text xs-display-none">(সিভিসিএস)</span>

                    <div class="separator-line margin-three bg-white sm-margin-top-three sm-margin-bottom-three no-margin-bottom"></div>
                    <!-- end title tagline -->
                </div>
            </div>
        </div>
    </section>
    
    <section id="about-studio" class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">সিভিসিএস সম্পর্কে</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                    <span class="text-extra-large font-weight-400"></span>
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>
    <!-- section text -->
    <section class="wow fadeInUp bg-gray padding-three-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-sm-10 text-center center-col">
                    <span class="margin-five no-margin-top display-block letter-spacing-2">স্থাপিত ২০১৮</span>
                    <h1>কাস্টমস এন্ড ভ্যাট কর্মকর্তা-কর্মচারী সমবায় সমিতি (সিভিসিএস) লিমিটেড</h1>
                    <p class="text-med width-90 center-col margin-seven no-margin-bottom about-us-page-text">
                        {{ $about->text }}
                    </p>
                </div>
            </div>
        </div>
        {{-- <div class="container-fluid margin-five no-margin-bottom">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 bg-fast-yellow padding-three text-center">
                    <span class="text-small text-uppercase font-weight-600 black-text letter-spacing-2">Web Design &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Graphics &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Magento &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WordPress &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Applications</span>
                </div>
            </div>
        </div> --}}
    </section>
    <section id="about-studio" class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">গ্যালারি</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                    <span class="text-extra-large font-weight-400"></span>
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>
    <section class="bg-blue-1 wow fadeIn padding-four">
        <div class="container">
            <div class="row">
                @php
                    $albumwaitduration = 300;
                @endphp
                @foreach($albums as $album)
                    <div class="col-md-3 col-sm-6 text-center wow fadeInUp features-2" data-wow-duration="{{ $albumwaitduration }}ms">
                        <a href="{{ route('index.gallery.single', $album->id) }}">
                            <div class="key-person">
                                <div class="key-person-img"><img src="{{ asset('images/gallery/'.$album->thumbnail) }}" alt=""></div>
                                <div class="key-person-details bg-gray no-border no-padding-bottom"><h5>অ্যালবামঃ {{ $album->name }}</h5>
                                    <div class="separator-line bg-black"></div>
                                    <p>{{-- {{ $album->description }} --}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @php
                        $albumwaitduration = $albumwaitduration + 300;
                    @endphp
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 no-margin-bottom">
                    <center>
                        <a href="{{ route('index.gallery') }}" class="highlight-link text-uppercase white-text">আরও দেখুন
                            <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                        </a>
                    </center>
                </div>
            </div>
        </div>
    </section>
    <section id="about-studio" class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">সর্বশেষ নোটিশ</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                    <span class="text-extra-large font-weight-400"></span>
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>
    <!-- section text -->
    <section class="bg-gray padding-four">
        <div class="container">
            <div class="row">
                @php
                    $noticewaitduration = 1200;
                @endphp
                @foreach($notices as $notice)
                    <div class="col-md-3 col-sm-6 sm-margin-bottom-ten xs-text-center wow fadeInLeft" data-wow-duration="{{ $noticewaitduration }}ms">
                        <div class="box-notice">
                            <h3 class="font-weight-700 black-text margin-seven display-block">{{ $notice->name }}</h3>
                            <span class="text-large">
                                {{ date('F d, Y', strtotime($notice->created_at)) }}
                            </span>
                            <p class="margin-ten no-margin-top width-90 xs-center-col xs-display-block"></p>
                            <a href="{{ asset('files/'. $notice->attachment) }}" class="highlight-link text-uppercase white-text" style="position: absolute; bottom: 10px;" download="">ফাইল ডাউনলোড করুন
                                <i class="fa fa-long-arrow-down extra-small-icon white-text"></i>
                            </a>
                        </div>
                    </div>
                    @php
                        $noticewaitduration = $noticewaitduration - 300;
                    @endphp
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 margin-two">
                    <center>
                        <a href="{{ route('index.notice') }}" class="highlight-link text-uppercase white-text">আরও দেখুন
                            <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                        </a>
                    </center>
                </div>
            </div>
        </div>
    </section>
    <section id="about-studio" class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">সর্বশেষ ইভেন্ট</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                    <span class="text-extra-large font-weight-400"></span>
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>
    <!-- section text -->
    <section class="bg-gray padding-three">
        <div class="container">
            <div class="row">
                @php
                    $eventwaitduration = 300;
                @endphp
                @foreach($events as $event)
                    <div class="col-md-3 col-sm-6 sm-margin-bottom-ten xs-text-center wow fadeInRight" data-wow-duration="{{ $eventwaitduration }}ms">
                        <div class="blog-post box-event">
                            <div class="blog-post-images">
                                <a href="{{ route('index.singleevent', $event->id) }}">
                                    @if(($event->image != null) || !file_exists(public_path('images/events/'.$event->image)))
                                        <img src="{{ asset('images/events/'.$event->image) }}" alt="">
                                    @else
                                        <img src="{{ asset('images/events/default_event.jpg') }}" alt="">
                                    @endif
                                </a>
                            </div>
                            <div class="post-details">
                                <a href="{{ route('index.singleevent', $event->id) }}" class="post-title text-large">{{ $event->name }}</a>
                                <span class="post-author">
                                    {{ date('F d, Y', strtotime($event->created_at)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @php
                        $eventwaitduration = $eventwaitduration + 300;
                    @endphp
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 margin-two no-margin-bottom">
                    <center>
                        <a href="{{ route('index.events') }}" class="highlight-link text-uppercase white-text">আরও দেখুন
                            <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                        </a>
                    </center>
                </div>
            </div>
        </div>
    </section>
    <!-- end section text -->
    <section class="wow fadeIn bg-yellow">
        <div class="container">
            <div class="row">
                <!-- call to action -->
                <div class="col-md-7 col-sm-12 text-center center-col">
                    <p class="title-large text-uppercase letter-spacing-1 royal-blue-text font-weight-600 wow fadeIn">সিভিসিএস-এর সদস্যপদ পেতে...</p>
                    <a href="{{ route('index.application') }}" class="highlight-button-royal-blue-border btn margin-six wow fadeInUp">আবেদন করুন!</a>
                </div>
                <!-- end call to action -->
            </div>
        </div>
    </section>
    <!-- <section style="">
        <div class="container">
            <div class="row">
                features item
                <div class="col-md-4 col-sm-6 sm-margin-bottom-ten xs-text-center">
                    <h3>ইভেন্ট</h3>
                    <span class="title-small text-uppercase font-weight-700 black-text letter-spacing-1 margin-seven display-block">ইভেন্ট একঃ টাইটেল</span>
                    <p class="margin-ten no-margin-top width-90 xs-center-col xs-display-block">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the text.</p>
                    <a href="#" class="highlight-link text-uppercase white-text">আরও পড়ুন
                        <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                    </a>
                </div>
                end features item
                features item
                <div class="col-md-4 col-sm-6 sm-margin-bottom-ten xs-text-center">
                    <h3>ইভেন্ট</h3>
                    <span class="title-small text-uppercase font-weight-700 black-text letter-spacing-1 margin-seven display-block">ইভেন্ট দুইঃ টাইটেল</span>
                    <p class="margin-ten no-margin-top width-90 xs-center-col xs-display-block">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the text.</p>
                    <a href="#" class="highlight-link text-uppercase white-text">আরও পড়ুন
                        <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                    </a>
                </div>
                end features item
                features item
                <div class="col-md-4 col-sm-6 xs-margin-bottom-ten xs-text-center">
                    <h3>ইভেন্ট</h3>
                    <span class="title-small text-uppercase font-weight-700 black-text letter-spacing-1 margin-seven display-block">ইভেন্ট তিনঃ টাইটেল</span>
                    <p class="margin-ten no-margin-top width-90 xs-center-col xs-display-block">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the text.</p>
                    <a href="#" class="highlight-link text-uppercase white-text">আরও পড়ুন
                        <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                    </a>
                </div>
                end features item
    
            </div>
        </div>
    </section> -->
    <!-- blog content section -->

    <!-- end blog content section -->
@endsection

@section('js')
    {{-- {!!Html::script('js/wowslider/jquery_for_wow.js')!!} --}}
    {!!Html::script('js/wowslider/wowslider.js')!!}
    {!!Html::script('js/wowslider/wowslider.script.js')!!}
    <!-- Preloader -->
    <script type="text/javascript">
        //<![CDATA[
            $(window).load(function() { // makes sure the whole site is loaded
                $('#status').fadeOut(); // will first fade out the loading animation
                $('#preloader').delay(1000).fadeOut('slow'); // will fade out the white DIV that covers the website.
                $('body').delay(1000).css({'overflow':'visible'});
            })
        //]]>
    </script>
@endsection