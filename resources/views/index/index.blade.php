@extends('layouts.index')
@section('title')
    CVCS
@endsection

@section('css')
    {!!Html::style('css/wowslider.css')!!}
@endsection

@section('content')
    <section class="no-padding content-top-margin ">
        <div id="wowslider-container1">
            <div class="ws_images"><ul>
                <li><img src="{{ asset('images/slider/1.jpg') }}" alt="Writing" title="টেস্ট ডাটা" id="wows1_0"/>টেস্ট ডাটা</li>
                <li><img src="{{ asset('images/slider/2.jpg') }}" alt="Old Letters" title="টেস্ট ডাটা" id="wows1_1"/>টেস্ট ডাটা</li>
                <li><img src="{{ asset('images/slider/3.jpg') }}" alt="Stack Letters" title="টেস্ট ডাটা" id="wows1_2"/>টেস্ট ডাটা</li>
            </ul></div>
            <div class="ws_bullets"><div>
                <a href="#" title="Writing"><img src="{{ asset('images/slider/1.jpg') }}" alt="Writing"/></a>
                <a href="#" title="Old Letters"><img src="{{ asset('images/slider/2.jpg') }}" alt="Old Letters"/></a>
                <a href="#" title="Stack Letters"><img src="{{ asset('images/slider/3.jpg') }}" alt="Stack Letters"/></a>
            </div></div>
            <div class="ws_shadow"></div>
        </div>    
    </section>
    <section class="page-title bg-blue-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                    <!-- page title -->
                    <h1 class="white-text">কাস্টমস অ্যান্ড ভ্যাট কো-অপারেটিভ সোসাইটি</h1>
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
                    <span class="margin-five no-margin-top display-block letter-spacing-2">স্থাপিত ২০১৯</span>
                    <h1>কাস্টমস অ্যান্ড ভ্যাট কো-অপারেটিভ সোসাইটি</h1>
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
    <section class="bg-royal-blue wow fadeIn">
        <div class="container">
            <div class="row">
                @foreach($albumphotoes as $albumphoto)
                    
                        <div class="col-md-3 col-sm-3 text-center wow fadeIn features-2" data-wow-duration="300ms">
                            <a href="{{ route('index.gallery.single', $albumphoto->album->id) }}">
                                <div class="key-person">
                                    <div class="key-person-img"><img src="{{ asset('images/gallery/'.$albumphoto->image) }}" alt=""></div>
                                    <div class="key-person-details bg-gray no-border no-padding-bottom"><h5>অ্যালবামঃ {{ $albumphoto->album->name }}</h5>
                                        <div class="separator-line bg-black"></div>
                                        <p>{{ $albumphoto->caption }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                @endforeach
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
    {!!Html::script('js/wowslider.js')!!}
    {!!Html::script('js/wowslider.custom.js')!!}
@endsection