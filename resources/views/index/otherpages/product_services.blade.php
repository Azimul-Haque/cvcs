@extends('layouts.index')
@section('title')
    CVCS | প্রোডাক্ট ও সার্ভিস
@endsection

@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}"> --}}
@endsection

@section('content')
    <!-- head section -->
      <section class="content-top-margin page-title page-title-small bg-gray">
          <div class="container">
              <div class="row">
                  <div class="col-lg-8 col-md-7 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                      <!-- page title -->
                      <h1 class="black-text agency-title">প্রোডাক্ট ও সার্ভিস</h1>
                      <!-- end page title -->
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                      <!-- breadcrumb -->
                      {{-- <ul>
                          <li><a href="{{ route('index.index') }}">Home</a></li>
                          <li><a href="#">About</a></li>
                          <li>Constitution</li>
                      </ul> --}}
                      <!-- end breadcrumb -->
                  </div>
              </div>
          </div>
      </section>
      <!-- end head section -->
      <!-- end slide section -->

      <center>
        <br/><br/>
        <h2>পাতাটি নির্মাণাধীন</h2><br/>
        <img src="{{ asset('images/under_construction.gif') }}" class="img-responsive">
      </center>
@endsection

@section('js')
   
@endsection