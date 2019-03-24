@extends('layouts.index')
@section('title')
    CVCS | Gallery
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin page-title bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center wow fadeInUp">
                    <!-- page title -->
                    <h1 class="black-text">গ্যালারি</h1>
                    <!-- end page title -->
                    <!-- page title tagline -->
                    <span class="black-text xs-display-none">CVCS-এর স্থিরচিত্র সংকলন</span>
                    <!-- end title tagline -->
                </div>
            </div>
        </div>
    </section>
    <!-- end head section -->

    <!-- gallery items  -->
    @php
      $oddoreven = 1;
    @endphp
    @foreach($albums as $album)
    <section class="portfolio-short-description no-padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portfolio-short-description-bg pull-left" 
                    @if(file_exists(public_path('images/gallery/'.$album->thumbnail)))
                      style="background-image:url('{{asset('images/gallery/'.$album->thumbnail) }}');"
                    @else
                      style="background-image:url('{{asset('images/gallery/default_thumbnail.jpg') }}');"
                    @endif >
                        <figure class="@if($oddoreven % 2 == 0) pull-left wow fadeInLeft @else pull-right wow fadeInRight @endif">
                            <figcaption>
                                <div class="separator-line bg-yellow no-margin-lr margin-ten no-margin-top"></div>
                                <h3 class="white-text">{{ $album->name }}</h3>
                                <p class="light-gray-text text-uppercase margin-seven text-med">
                                  {{ $album->description }}
                                </p>
                                <a href="{{ route('index.gallery.single', $album->id) }}" class="btn-small-white-background btn margin-ten no-margin-bottom">ছবিগুলো দেখুন!</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
      $oddoreven++;
    @endphp
    @endforeach
    <!-- end gallery items  -->
      
@endsection

@section('js')
   
@endsection