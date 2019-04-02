@extends('layouts.index')
@section('title')
    CVCS | Event
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
                <div class="col-md-12 col-sm-12 xs-margin-bottom-four wow fadeInUp">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">ইভেন্ট</span>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
    <!-- end head section -->

    <!-- content section -->
    <section class="wow fadeIn">
        <div class="container">
            <div class="row">
                <!-- content  -->
                <div class="col-md-8 col-sm-8">
                    <!-- post title  -->
                    <h2 class="blog-details-headline text-black">{{ $event->name }}</h2>
                    <!-- end post title  -->
                    <!-- post date and categories  -->
                    <div class="blog-date no-padding-top">
                        {{ date('F d, Y', strtotime($event->created_at)) }}
                    </div>
                    <!-- end date and categories   -->
                    <!-- post image -->
                    <div class="margin-eight">
                        @if(($event->image != null) || (!file_exists(public_path('images/events/'.$event->image))))
                            <img src="{{ asset('images/events/'.$event->image) }}" alt="Event Image" >
                        @else
                            <img src="{{ asset('images/events/default_event.jpg') }}" alt="Event Image" >
                        @endif
                    </div>
                    <p class="about-us-page-text">{{ $event->description }}</p>
                    
                </div>
                <!-- end content  -->
                <!-- sidebar  -->
                <div class="col-md-3 col-sm-4 col-md-offset-1 sidebar xs-margin-top-ten">
                    <!-- widget  -->
                    <div class="widget">
                        <h5 class="widget-title font-alt">সর্বশেষ ইভেন্টসমূহ</h5>
                        <div class="thin-separator-line bg-dark-gray no-margin-lr"></div>
                        <div class="widget-body">
                            <ul class="widget-posts">
                                @foreach($events as $event)
                                    <li class="clearfix">
                                        <a href="{{ route('index.singleevent', $event->id) }}">
                                            @if(($event->image != null) || (!file_exists(public_path('images/events/'.$event->image))))
                                                <img src="{{ asset('images/events/'.$event->image) }}" alt="Event Image" >
                                            @else
                                                <img src="{{ asset('images/events/default_event.jpg') }}" alt="Event Image" >
                                            @endif
                                        </a>
                                        <div class="widget-posts-details"><a href="{{ route('index.singleevent', $event->id) }}">{{ $event->name }}</a>
                                            {{ date('F d, Y', strtotime($event->created_at)) }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- end widget  -->
                </div>
                <!-- end sidebar  -->
            </div>
        </div>
    </section>
    <!-- end content section -->

    
@endsection

@section('js')
   
@endsection