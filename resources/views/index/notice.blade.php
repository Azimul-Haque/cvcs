@extends('layouts.index')
@section('title')
    CVCS | Notice
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin wow fadeInUp bg-fast-pink">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">নোটিশ</span>
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

    <section style="padding: 13px 0;">
        <div class="container">
            <div class="row">
                <!-- features item -->
                <div class="col-md-4 col-sm-6 sm-margin-bottom-ten xs-text-center">
                    <span class="title-small text-uppercase font-weight-700 black-text letter-spacing-1 margin-seven display-block">We're ready to start now</span>
                    <span class="text-large">March 24, 2019</span>
                    <p class="margin-ten no-margin-top width-90 xs-center-col xs-display-block">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the text.</p>
                    <a href="#" class="highlight-link text-uppercase white-text">Download Attachment
                        <i class="fa fa-long-arrow-down extra-small-icon white-text"></i>
                    </a>
                </div>
                <!-- end features item -->
                <!-- features item -->
                <div class="col-md-4 col-sm-6 sm-margin-bottom-ten xs-text-center">
                    <span class="title-small text-uppercase font-weight-700 black-text letter-spacing-1 margin-seven display-block">Always on time call support</span>
                    <span class="text-large">March 24, 2019</span>
                    <p class="margin-ten no-margin-top width-90 xs-center-col xs-display-block">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the text.</p>
                    <a href="#" class="highlight-link text-uppercase white-text">Download Attachment
                        <i class="fa fa-long-arrow-down extra-small-icon white-text"></i>
                    </a>
                </div>
                <!-- end features item -->
                <!-- features item -->
                <div class="col-md-4 col-sm-6 xs-margin-bottom-ten xs-text-center">
                    <span class="title-small text-uppercase font-weight-700 black-text letter-spacing-1 margin-seven display-block">We Deliver the highest quality</span>
                    <span class="text-large">March 24, 2019</span>
                    <p class="margin-ten no-margin-top width-90 xs-center-col xs-display-block">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the text.</p>
                    <a href="#" class="highlight-link text-uppercase white-text">Download Attachment
                        <i class="fa fa-long-arrow-down extra-small-icon white-text"></i>
                    </a>
                </div>
                <!-- end features item -->

            </div>
        </div>
    </section>
@endsection

@section('js')
   
@endsection