@extends('layouts.index')
@section('title')
    CVCS | আমাদের সম্পর্কে
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
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">সংক্ষিপ্ত ইতিহাস</span>
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
                        {!! $whoweare->text !!}
                    </p>
                </div>
                <div class="col-md-4 xs-display-none">
                    <center>
                      <img src="{{ asset('images/whoweare.png') }}" class="img-responsive" style="max-height: 250px;">
                    </center>
                </div>
            </div>
        </div>
    </section>

    <section class="wow fadeInUp">
        <div class="container">
            <div class="row">
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                    <span class="text-extra-large font-weight-400"></span>
                </div>
                <!-- end section highlight text -->
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four text-right">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">আমাদের মিশন</span>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
    <section class="wow fadeInUp bg-royal-blue">
        <div class="container">
            <div class="row">
                <div class="col-md-4 xs-display-none">
                    <center>
                      <img src="{{ asset('images/mission.png') }}" class="img-responsive" style="max-height: 250px;">
                    </center>
                </div>
                <div class="col-md-8">
                    <span class="title-large text-uppercase letter-spacing-1 font-weight-600 white-text"></span>
                    <div class="separator-line-thick bg-fast-pink no-margin-lr"></div>
                    <p class="white-text about-us-page-text">
                        {!! $mission->text !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
    

    {{-- <section class="wow fadeInUp">
        <div class="container">
            <div class="row">
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                    <span class="text-extra-large font-weight-400"></span>
                </div>
                <!-- end section highlight text -->
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four text-right">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">আমরা যা করি</span>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
    <section class="wow fadeInUp bg-royal-blue">
        <div class="container">
            <div class="row">
                <div class="col-md-4 xs-display-none">
                    <center>
                      <img src="{{ asset('images/whatwedo.png') }}" class="img-responsive" style="max-height: 250px;">
                    </center>
                </div>
                <div class="col-md-8">
                    <span class="title-large text-uppercase letter-spacing-1 font-weight-600 white-text"></span>
                    <div class="separator-line-thick bg-fast-pink no-margin-lr"></div>
                    <p class="white-text about-us-page-text">
                        {!! $whoweare->text !!}
                    </p>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="wow fadeInUp">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">সদস্যপদ</span>
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
    <section class="wow fadeInUp bg-royal-blue">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <span class="title-large text-uppercase letter-spacing-1 font-weight-600 black-text"></span>
                    <div class="separator-line-thick bg-fast-pink no-margin-lr"></div>
                    <p class="white-text about-us-page-text">
                        {!! $membership->text !!}
                    </p>
                </div>
                <div class="col-md-4 xs-display-none">
                    <center>
                      <img src="{{ asset('images/membership.png') }}" class="img-responsive" style="max-height: 250px;">
                    </center>
                </div>
            </div>
        </div>
    </section>
    <section class="wow fadeInUp">
        <div class="container">
            <div class="row">
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                    <span class="text-extra-large font-weight-400"></span>
                </div>
                <!-- end section highlight text -->
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four text-right">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">এক নজরে সিভিসিএস</span>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
    <section class="wow fadeInUp bg-royal-blue">
        <div class="container">
            <div class="row">
                <div class="col-md-4 xs-display-none">
                    <center>
                      <img src="{{ asset('images/ataglance.png') }}" class="img-responsive" style="max-height: 250px;">
                    </center>
                </div>
                <div class="col-md-8">
                    <span class="title-large text-uppercase letter-spacing-1 font-weight-600 black-text"></span>
                    <div class="separator-line-thick bg-fast-pink no-margin-lr"></div>
                    <p class="white-text about-us-page-text">
                        {!! $ataglance->text !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end WHATWEDO section -->
    <!-- content section -->
    {{-- <section class="content-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="features-section col-md-12 col-sm-6 no-padding wow fadeInUp" data-wow-duration="300ms">
                        <div class="col-md-3 col-sm-2 col-xs-2 no-padding"><i class="icon-desktop  medium-icon "></i></div>
                        <div class="col-md-9 col-sm-9 col-xs-9 no-padding text-left f-right">
                            <h5>Elegant / Unique design</h5>
                            <div class="separator-line bg-yellow"></div>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p>
                        </div>
                    </div>
                    <div class="features-section no-margin col-md-12 col-sm-6 no-padding wow fadeInUp" data-wow-duration="1200ms">
                        <div class="col-md-3 col-sm-2 col-xs-2 no-padding"><i class="icon-target  medium-icon"></i></div>
                        <div class="col-md-9 col-sm-9 col-xs-9 no-padding text-left f-right">
                            <h5>True Responsiveness</h5>
                            <div class="separator-line bg-yellow"></div>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="features-section col-md-12 col-sm-6 no-padding wow fadeInUp" data-wow-duration="600ms">
                        <div class="col-md-3 col-sm-2 col-xs-2 no-padding"><i class="icon-trophy medium-icon"></i></div>
                        <div class="col-md-9 col-sm-9 col-xs-9 no-padding text-left f-right">
                            <h5>Parallax Slider</h5>
                            <div class="separator-line bg-yellow"></div>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p>
                        </div>
                    </div>
                    <div class="features-section no-margin col-md-12 col-sm-6 no-padding wow fadeInUp" data-wow-duration="1500ms">
                        <div class="col-md-3 col-sm-2 col-xs-2 no-padding"><i class="icon-scissors medium-icon"></i></div>
                        <div class="col-md-9 col-sm-9 col-xs-9 no-padding text-left f-right">
                            <h5>Lightbox photo Gallery</h5>
                            <div class="separator-line bg-yellow"></div>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="features-section no-bottom-margin col-md-12 col-sm-6 no-padding wow fadeInUp" data-wow-duration="900ms">
                        <div class="col-md-3 col-sm-2 col-xs-2 no-padding"><i class="icon-hotairballoon medium-icon"></i></div>
                        <div class="col-md-9 col-sm-9 col-xs-9 no-padding text-left f-right">
                            <h5>Different Layout Type</h5>
                            <div class="separator-line bg-yellow"></div>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p>
                        </div>
                    </div>
                    <div class="features-section no-margin col-md-12 col-sm-6 no-padding wow fadeInUp" data-wow-duration="1800ms">
                        <div class="col-md-3 col-sm-2 col-xs-2 no-padding"><i class="icon-tools medium-icon"></i></div>
                        <div class="col-md-9 col-sm-9 col-xs-9 no-padding text-left f-right">
                            <h5>Skills and Accordians</h5>
                            <div class="separator-line bg-yellow"></div>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- end content section -->
@endsection

@section('js')
   
@endsection