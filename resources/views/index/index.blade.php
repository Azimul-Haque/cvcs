@extends('layouts.index')
@section('title')
    CVCS
@endsection

@section('css')
    
@endsection

@section('content')
    @extends('partials._slider')
    <section id="about-studio" class="padding-three">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">CVCS সম্পর্কে</span>
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
    <section class="wow fadeInUp bg-gray no-padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-sm-10 text-center center-col">
                    <span class="margin-five no-margin-top display-block letter-spacing-2">স্থাপিত ২০১৯</span>
                    <h1>কো-অপারেটিভ সোসাইটি সম্পর্কে</h1>
                    <p class="text-med width-90 center-col margin-seven no-margin-bottom">
                        {{ $about->text }}
                    </p>
                </div>
            </div>
        </div>
        <div class="container-fluid margin-five no-margin-bottom">
            <div class="row">
                {{-- <div class="col-md-12 col-sm-12 col-xs-12 bg-fast-yellow padding-three text-center">
                    <span class="text-small text-uppercase font-weight-600 black-text letter-spacing-2">Web Design &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Graphics &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Magento &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WordPress &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Applications</span>
                </div> --}}
            </div>
        </div>
    </section>
    <!-- end section text -->
    <section class="wow fadeIn bg-yellow">
        <div class="container">
            <div class="row">
                <!-- call to action -->
                <div class="col-md-7 col-sm-12 text-center center-col">
                    <p class="title-large text-uppercase letter-spacing-1 black-text font-weight-600 wow fadeIn">CVCS-এর সদস্যপদ পেতে...</p>
                    <a href="contact-us.html" class="highlight-button-black-border btn margin-six wow fadeInUp">আবেদন করুন!</a>
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

@endsection