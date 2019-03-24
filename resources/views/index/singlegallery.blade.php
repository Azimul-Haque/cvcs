@extends('layouts.index')
@section('title')
    CVCS | Gallery | {{ $album->name }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin page-title parallax3 parallax-fix page-title-large">
        <div class="opacity-medium bg-black"></div>
        <img class="parallax-background-img" 
        @if(file_exists(public_path('images/gallery/'.$album->thumbnail)))
            src="{{asset('images/gallery/' . $album->thumbnail) }}"
        @else
            src="{{asset('images/gallery/default_thumbnail.jpg') }}"
        @endif
        alt="" />
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center animated fadeInUp">
                    <div class="separator-line bg-yellow no-margin-top margin-four"></div>
                    <!-- page title -->
                    <h1 class="white-text">{{ $album->name }}</h1>
                    <!-- end page title -->
                    <!-- page title tagline -->
                    <span class="white-text">{{ $album->description }}</span>
                    <!-- end title tagline -->
                </div>
            </div>
        </div>
    </section>
    <!-- end head section -->

    {{-- album photos --}}
    <section class="work-3col gutter no-margin-top content-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 grid-gallery overflow-hidden" >
                    <!-- work grid -->
                    <ul class="grid masonry-items lightbox-gallery">
                        @foreach($album->albumphotoes as $albumphoto)
                            <li class="html magento">
                                <figure>
                                    <div class="gallery-img"><a href="{{ asset('images/gallery/'.$albumphoto->image) }}" title=""><img src="{{ asset('images/gallery/'.$albumphoto->image) }}" alt=""></a></div>
                                    <figcaption>
                                        <h3>{{ $albumphoto->caption }}</h3>
                                        <p></p>
                                    </figcaption>
                                </figure>
                            </li>
                        @endforeach
                    </ul>
                    <!-- end work grid -->
                </div>
            </div>
        </div>
    </section>
    {{-- album photos --}}
@endsection

@section('js')
   
@endsection