@extends('layouts.index')
@section('title')
    CVCS | Member Verification
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
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">সদস্য যাচাইকরণ</span>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
    <!-- end head section -->

    <section style="padding: 13px 0;">
        <div class="container">
            <div class="row">
                @foreach($events as $event)
                    <div class="col-md-4 col-sm-6 sm-margin-bottom-ten xs-text-center" style="min-height: 370px;">
                        <div class="blog-post">
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
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('js')
   
@endsection