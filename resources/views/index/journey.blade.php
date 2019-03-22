@extends('layouts.index')
@section('title')
    IIT Alumni | Journey of DUIITAA
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->
      <section class="content-top-margin page-title page-title-small bg-gray">
          <div class="container">
              <div class="row">
                  <div class="col-lg-8 col-md-7 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                      <!-- page title -->
                      <h1 class="black-text">Journey at a Glance...</h1>
                      <!-- end page title -->
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                      <!-- breadcrumb -->
                      <ul>
                          <li><a href="{{ route('index.index') }}">Home</a></li>
                          <li><a href="#">About</a></li>
                          <li>Journey</li>
                      </ul>
                      <!-- end breadcrumb -->
                  </div>
              </div>
          </div>
      </section>
      <!-- end head section -->
      <!-- WHATWEDO section -->
      <section class="border-bottom-light sm-text-center">
          <div class="container">
              <div class="row">
                  <div class="col-md-7 wow fadeInUp" data-wow-duration="400ms"><img src="{{ asset('vendor/hcode/images/about-us-img-12.png') }}" alt=""/></div>
                  <div class="col-md-5 wow fadeInUp" data-wow-duration="800ms">
                      <h1 class="title-extra-large font-weight-700 black-text margin-five text-transform-none">What we do</h1>
                      <p class="title-small font-weight-300">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum industry's standard dummy text.</p>
                      <p class="title-small font-weight-300">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                  </div>
              </div>
          </div>
      </section>
      <!-- end WHATWEDO section -->
      <!-- content section -->
      <section class="content-section">
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
      </section>
      <!-- end content section -->
@endsection

@section('js')
   
@endsection