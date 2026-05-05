@extends('layouts.index')
@section('title')
    CVCS | FAQ
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
                      <h1 class="black-text">FAQs (সাধারণ জিজ্ঞাসা)</h1>
                      <!-- end page title -->
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                      <!-- breadcrumb -->
                      {{-- <ul>
                          <li><a href="{{ route('index.index') }}">Home</a></li>
                          <li><a href="#">About</a></li>
                          <li>FAQ</li>
                      </ul> --}}
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
                    <h1 class="white-text">কীভাবে আপনাকে সাহায্য করতে পারি?</h1>
                    <div class="faq-search margin-five no-margin-bottom position-relative">
                        <input type="text" name="search" class="input-round big-input no-margin" placeholder="আপনার প্রশ্নটি খুঁজুন">
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
                        @php
                          $counter = 1;
                        @endphp
                        @foreach($faqs as $faq)
                          <div class="panel panel-default" id="collapse-{{ $counter }}">
                              <div role="tablist" id="heading{{ $counter }}" class="panel-heading">
                                  <a data-toggle="collapse" data-parent="#collapse-{{ $counter }}" href="#collapse-{{ $counter }}-link1">
                                      <h4 class="panel-title">প্রশ্নঃ {{ $faq->question }}
                                          <span class="pull-right">
                                              <i class="fa fa-plus"></i>
                                          </span>
                                      </h4>
                                  </a>
                              </div>
                              <div id="collapse-{{ $counter }}-link1" class="panel-collapse collapse">
                                  <div class="panel-body">
                                      উত্তরঃ {{ $faq->answer }}
                                  </div>
                              </div>
                          </div>
                          @php
                            $counter++;
                          @endphp
                        @endforeach
                        <!-- end faq item -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end content section -->
    <br>
    <br>
    <!-- Custom Style to Modernize BS3 -->
    <style>
        .bcs-modern-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
            max-width: 350px;
            margin: 20px auto;
            transition: transform 0.3s ease;
        }
        .bcs-modern-card:hover {
            transform: translateY(-5px);
        }
        .bcs-card-header {
            background: #1a237e; /* Royal Blue */
            color: white;
            padding: 20px;
            text-align: center;
        }
        .bcs-card-body {
            padding: 20px;
            background: #ffffff;
        }
        .btn-bcs {
            margin-bottom: 10px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-google-play { background-color: #00875f; color: white; }
        .btn-google-play:hover { background-color: #006b4b; color: white; }
    </style>

    <div class="panel panel-default bcs-modern-card">
        <div class="bcs-card-header">
            <h3 style="margin:0; font-size: 20px;">BCS Exam Aid</h3>
            <small style="opacity: 0.8;">স্মার্ট প্রস্তুতির আধুনিক মাধ্যম</small>
        </div>
        <div class="bcs-card-body">
            <p class="text-muted text-center" style="font-size: 14px;">
                ১ লক্ষাধিক প্রশ্ন এবং বিশেষজ্ঞ ক্যাডারদের তত্ত্বাবধানে তৈরি সেরা লার্নিং প্ল্যাটফর্ম।
            </p>
            
            <!-- App Link -->
            <a href="https://play.google.com/store" class="btn btn-block btn-bcs btn-google-play">
                <i class="glyphicon glyphicon-download-alt"></i> প্লে-স্টোর থেকে অ্যাপ নিন
            </a>
            
            <!-- Website Link -->
            <a href="https://bcsexamaid.com" class="btn btn-block btn-bcs btn-primary">
                <i class="glyphicon glyphicon-globe"></i> ওয়েবসাইট ভিজিট করুন
            </a>
            
            <!-- Blog Link -->
            <a href="https://bcsexamaid.com/blogs" class="btn btn-block btn-bcs btn-info">
                <i class="glyphicon glyphicon-list-alt"></i> টিপস ও ব্লগ পড়ুন
            </a>
        </div>
    </div>
@endsection

@section('js')
   
@endsection