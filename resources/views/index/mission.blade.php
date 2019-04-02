@extends('layouts.index')
@section('title')
    CVCS | মিশন
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin wow fadeInUp">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">মিশন</span>
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
    <!-- end head section -->
    <!-- WHATWEDO section -->
    <section class="wow fadeInUp bg-royal-blue">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <span class="title-large text-uppercase letter-spacing-1 font-weight-600 black-text"></span>
                    <div class="separator-line-thick bg-fast-pink no-margin-lr"></div>
                    <p class="white-text about-us-page-text">
                        বিভিন্ন কো-অপারেটিভের ন্যায় এ বিভাগের কর্মকর্তা-কর্মচারীদের নানামুখী উন্নয়নমূলক কার্যক্রম গ্রহণ করার লক্ষ্যে কাস্টমস এন্ড ভ্যাট কর্মকর্তা-কর্মচারী সমবায় সমিতি (সিভিসিএস) লিমিটেড গঠন করা হয়েছে। এর লক্ষ্যগুলো এক নজরে-<br/><br/>

                        <i class="fa fa-angle-double-right white-text"></i> আবাসন ব্যবস্থা নির্মাণ<br/>
                        <i class="fa fa-angle-double-right white-text"></i> কো-অপারেটিভ মার্কেট তৈরি<br/>
                        <i class="fa fa-angle-double-right white-text"></i> বিভিন্ন বাণিজ্যিক পণ্য (পানি, আটা, ময়দা, দুগ্ধজা পণ্য) বাজারজাতকরণ<br/>
                        <i class="fa fa-angle-double-right white-text"></i> বাণিজ্যিক প্রতিষ্ঠান স্থাপন (সিমেন্ট, কাগজ ইত্যাদি)<br/>
                        <i class="fa fa-angle-double-right white-text"></i> তহবিল গঠন (স্যুভেনির প্রকাশ, অনুদান ইত্যাদি)<br/>
                        <i class="fa fa-angle-double-right white-text"></i> ব্যাংক স্থাপন<br/>
                        <i class="fa fa-angle-double-right white-text"></i> বিভাগে কর্ম্রত কর্মকর্তা-কর্মচারীদের সন্তান্দের বৃত্তি প্রদান<br/>
                        <i class="fa fa-angle-double-right white-text"></i> উচ্চশিক্ষায় সহায়তা প্রদান<br/>
                        <i class="fa fa-angle-double-right white-text"></i> দুরারোগ্য ব্যাধিতে আক্রান্ত সহকর্মীদের চিকিৎসা সেবায় সহায়তা প্রদান; ইত্যাদি<br/>
                    </p>
                </div>
                <div class="col-md-4 xs-display-none">
                    <center>
                      <img src="{{ asset('images/mission.png') }}" class="img-responsive" style="max-height: 250px; margin-top: 90px;">
                    </center>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
   
@endsection