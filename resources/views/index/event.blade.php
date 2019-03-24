@extends('layouts.index')
@section('title')
    CVCS | Events
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin page-title-small bg-gray">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-12 col-sm-12 xs-margin-bottom-four text-center wow fadeInUp">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">ইভেন্ট তালিকা</span>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
    <!-- end head section -->

    <section style="padding: 13px 0;">
        <div class="container">
            <div class="row">
                <!-- features item -->
                <div class="col-md-4 col-sm-6 xs-margin-bottom-ten xs-text-center">
                    <div class="blog-post">
                        <div class="blog-post-images"><a href="#!"><img src="{{ asset('images/portfolio-img27.jpg') }}" alt=""></a></div>
                        <div class="post-details">
                            <a href="#!" class="post-title text-large">Standard post with picture</a>
                            <span class="post-author">10 January 2015</span>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                            <br/>
                            <a href="#" class="highlight-link text-uppercase white-text">Read More
                                <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 xs-margin-bottom-ten xs-text-center">
                    <div class="blog-post">
                        <div class="blog-post-images"><a href="#!"><img src="{{ asset('images/portfolio-img27.jpg') }}" alt=""></a></div>
                        <div class="post-details">
                            <a href="#!" class="post-title text-large">Standard post with picture</a>
                            <span class="post-author">10 January 2015</span>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                            <br/>
                            <a href="#" class="highlight-link text-uppercase white-text">Read More
                                <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 xs-margin-bottom-ten xs-text-center">
                    <div class="blog-post">
                        <div class="blog-post-images"><a href="#!"><img src="{{ asset('images/portfolio-img27.jpg') }}" alt=""></a></div>
                        <div class="post-details">
                            <a href="#!" class="post-title text-large">Standard post with picture</a>
                            <span class="post-author">10 January 2015</span>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                            <br/>
                            <a href="#" class="highlight-link text-uppercase white-text">Read More
                                <i class="fa fa-long-arrow-right extra-small-icon white-text"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end features item -->
            </div>
        </div>
    </section>
@endsection

@section('js')
   
@endsection