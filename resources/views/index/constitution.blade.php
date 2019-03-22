@extends('layouts.index')
@section('title')
    IIT Alumni | Constitution
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
                      <h1 class="black-text">Constitution...</h1>
                      <!-- end page title -->
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                      <!-- breadcrumb -->
                      <ul>
                          <li><a href="{{ route('index.index') }}">Home</a></li>
                          <li><a href="#">About</a></li>
                          <li>Constitution</li>
                      </ul>
                      <!-- end breadcrumb -->
                  </div>
              </div>
          </div>
      </section>
      <!-- end head section -->
      <!-- end slide section -->
      <section class="wow fadeIn cover-background" style="background-image:url('{{ asset('vendor/hcode/images/intro-agency2-07-01.jpg')  }}');">
          <div class="opacity-medium bg-dark-gray"></div>
          <div class="container">
              <div class="row">
                  <div class="col-md-5 col-sm-8 center-col text-center position-relative">
                      <p class="title-med text-uppercase letter-spacing-1 white-text font-weight-600 wow bounceIn">Over 1500<br> Happy clients worldwide</p>
                      <p class="text-large margin-ten no-margin-bottom light-gray-text wow fadeInUp">We're fortunate to work with fantastic clients from across the globe in over...
              </div>
          </div>
      </section>
      <!-- end slide section -->
      <!-- content section -->
      <section class="wow fadeIn border-top">
          <div class="container">
              <div class="row">
                  <div class="col-md-7 col-sm-10 center-col text-center margin-ten no-margin-top xs-margin-bottom-seven">
                      <h6 class="no-margin-top margin-ten xs-margin-bottom-seven"><strong class="black-text">Tab Style #6</strong></h6>
                  </div>
              </div>
              <div class="row">
                  <!-- tab -->
                  <div class="col-md-12 col-sm-12 center-col text-center" id="animated-tab">
                      <!-- tab navigation -->
                      <ul class="nav nav-tabs margin-five no-margin-top">
                          <li class="nav active"><a href="#tab6_sec1" data-toggle="tab"><span><i class="icon-tools"></i></span></a></li>
                          <li class="nav"><a href="#tab6_sec2" data-toggle="tab"><span><i class="icon-laptop"></i></span></a></li>
                          <li class="nav"><a href="#tab6_sec3" data-toggle="tab"><span><i class="icon-target"></i></span></a></li>
                          <li class="nav"><a href="#tab6_sec4" data-toggle="tab"><span><i class="icon-camera"></i></span></a></li>
                          <li class="nav"><a href="#tab6_sec5" data-toggle="tab"><span><i class="icon-hotairballoon"></i></span></a></li>
                      </ul>
                      <!-- end tab navigation -->
                      <!-- tab content section -->
                      <div class="tab-content">
                          <!-- tab content -->
                          <div id="tab6_sec1" class="col-md-9 col-sm-12 text-center center-col tab-pane fade in active"> 
                              <div class="tab-pane fade in"> 
                                  <div class="row"> 
                                      <div class="col-md-6 col-sm-12 text-left gray-text">
                                          <h5>Graphic Design</h5>
                                          <div class="separator-line bg-yellow no-margin-lr sm-margin-five"></div>
                                          <p class="text-large margin-five margin-right-ten">We believe in the power of design, the strength of strategy, and the ability of technology to transform businesses and lives.</p>
                                      </div>
                                      <div class="col-md-6 col-sm-12 text-left text-med gray-text">
                                          <p class="text-uppercase">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                      </div>
                                  </div>
                                  <div class="row"> 
                                      <div class="wide-separator-line"></div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12 col-sm-12 text-center service-year black-text">
                                          <strong>1999 to 2014</strong> - Graphic Design Experience
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- end tab content -->
                          <!-- tab content -->
                          <div id="tab6_sec2" class="col-md-9 col-sm-12 text-center center-col tab-pane fade in"> 
                              <div class="tab-pane fade in"> 
                                  <div class="row"> 
                                      <div class="col-md-6 col-sm-12 text-left gray-text">
                                          <h5>Web Design</h5>
                                          <div class="separator-line bg-yellow no-margin-lr sm-margin-five"></div>
                                          <p class="text-large margin-five margin-right-ten">Every website we design is bespoke, fuelled with years of industry experience. Proudly designed in the World.</p>
                                      </div>
                                      <div class="col-md-6 col-sm-12 text-left text-med gray-text">
                                          <p class="text-uppercase">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                      </div>
                                  </div>
                                  <div class="row"> 
                                      <div class="wide-separator-line"></div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12 col-sm-12 text-center service-year black-text">
                                          <strong>1995 to 2014</strong> - Web Design Experience
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- end tab content -->
                          <!-- tab content -->
                          <div id="tab6_sec3" class="col-md-9 col-sm-12 text-center center-col tab-pane fade in"> 
                              <div class="tab-pane fade in"> 
                                  <div class="row"> 
                                      <div class="col-md-6 col-sm-12 text-left gray-text">
                                          <h5>Branding</h5>
                                          <div class="separator-line bg-yellow no-margin-lr sm-margin-five"></div>
                                          <p class="text-large margin-five margin-right-ten">We create meaningful experiences through innovation in storytelling, technology, entertainment and products.</p>
                                      </div>
                                      <div class="col-md-6 col-sm-12 text-left text-med gray-text">
                                          <p class="text-uppercase">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                      </div>
                                  </div>
                                  <div class="row"> 
                                      <div class="wide-separator-line"></div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12 col-sm-12 text-center service-year black-text">
                                          <strong>1997 to 2014</strong> - Branding
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- end tab content -->
                          <!-- tab content -->
                          <div id="tab6_sec4" class="col-md-9 col-sm-12 text-center center-col tab-pane fade in"> 
                              <div class="tab-pane fade in"> 
                                  <div class="row"> 
                                      <div class="col-md-6 col-sm-12 text-left gray-text">
                                          <h5>Photography</h5>
                                          <div class="separator-line bg-yellow no-margin-lr sm-margin-five"></div>
                                          <p class="text-large margin-five margin-right-ten">A first impression can make or break you. we can help you find the precise message to clearly.</p>
                                      </div>
                                      <div class="col-md-6 col-sm-12 text-left text-med gray-text">
                                          <p class="text-uppercase">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                      </div>
                                  </div>
                                  <div class="row"> 
                                      <div class="wide-separator-line"></div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12 col-sm-12 text-center service-year black-text">
                                          <strong>1999 to 2014</strong> - Photography
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- end tab content -->
                          <!-- tab content -->
                          <div id="tab6_sec5" class="col-md-9 col-sm-12 text-center center-col tab-pane fade in"> 
                              <div class="tab-pane fade in"> 
                                  <div class="row"> 
                                      <div class="col-md-6 col-sm-12 text-left gray-text">
                                          <h5>Social Marketing</h5>
                                          <div class="separator-line bg-yellow no-margin-lr sm-margin-five"></div>
                                          <p class="text-large margin-five margin-right-ten">We believe in the power of design, the strength of strategy, and the ability of technology to transform businesses and lives.</p>
                                      </div>
                                      <div class="col-md-6 col-sm-12 text-left text-med gray-text">
                                          <p class="text-uppercase">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                      </div>
                                  </div>
                                  <div class="row"> 
                                      <div class="wide-separator-line"></div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-12 col-sm-12 text-center service-year black-text">
                                          <strong>2000 to 2014</strong> - Social Marketing
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- end tab content -->
                      </div>
                      <!-- end tab content section -->
                  </div>
                  <!-- end tab -->
              </div>
          </div>
      </section>
      <!-- end content section -->
@endsection

@section('js')
   
@endsection