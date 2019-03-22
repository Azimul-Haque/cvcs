@extends('layouts.index')
@section('title')
    IIT Alumni | FAQ
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
                      <h1 class="black-text">FAQs...</h1>
                      <!-- end page title -->
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                      <!-- breadcrumb -->
                      <ul>
                          <li><a href="{{ route('index.index') }}">Home</a></li>
                          <li><a href="#">About</a></li>
                          <li>FAQ</li>
                      </ul>
                      <!-- end breadcrumb -->
                  </div>
              </div>
          </div>
      </section>
      <!-- end head section -->
      <!-- content section -->
    <section class="wow fadeIn bg-black">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 wow fadeInUp center-col text-center">
                    <h1 class="white-text">Hello, how can we help you?</h1>
                    <div class="faq-search margin-five no-margin-bottom position-relative">
                        <input type="text" name="search" class="input-round big-input no-margin" placeholder="Search our Help Center...">
                        <i class="fa fa-search faq-search-button"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="wow fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 no-padding">
                    <div class="panel-group toggles-style3 no-border">
                        <!-- faq item -->
                        <div class="panel panel-default" id="collapse-one">
                            <div role="tablist" id="headingOne" class="panel-heading">
                                <a data-toggle="collapse" data-parent="#collapse-one" href="#collapse-one-link1">
                                    <h4 class="panel-title">Lorem Ipsum is simply text printing?
                                        <span class="pull-right">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </h4>
                                </a>
                            </div>
                            <div id="collapse-one-link1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                    it to make a type specimen book.
                                </div>
                            </div>
                        </div>
                        <!-- end faq item -->
                        <!-- faq item -->
                        <div class="panel panel-default">
                            <div role="tablist" id="headingTwo" class="panel-heading">
                                <a data-toggle="collapse" data-parent="#collapse-one" href="#collapse-one-link2">
                                    <h4 class="panel-title">Lorem Ipsum is simply dummy?
                                        <span class="pull-right">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </h4>
                                </a>
                            </div>
                            <div id="collapse-one-link2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                    it to make a type specimen book.
                                </div>
                            </div>
                        </div>
                        <!-- end faq item -->
                        <!-- faq item -->
                        <div class="panel panel-default">
                            <div role="tablist" id="headingThree" class="panel-heading">
                                <a data-toggle="collapse" data-parent="#collapse-one" href="#collapse-one-link3">
                                    <h4 class="panel-title">Lorem Ipsum is simply dummy text?
                                        <span class="pull-right">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </h4>
                                </a>
                            </div>
                            <div id="collapse-one-link3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                    text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                    it to make a type specimen book.
                                </div>
                            </div>
                        </div>
                        <!-- end faq item -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end content section -->
@endsection

@section('js')
   
@endsection