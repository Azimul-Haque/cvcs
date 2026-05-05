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
    <!-- BCS Exam Aid Widget - Ultra Modern Version -->
    <style>
        .bcs-pro-widget {
            max-width: 340px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #e0e6ed;
            border-radius: 12px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
            overflow: hidden;
        }
        .bcs-pro-header {
            background: #0d47a1; /* Deep Professional Blue */
            padding: 25px 15px;
            color: #ffffff;
        }
        .bcs-pro-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .bcs-pro-header p {
            margin: 8px 0 0;
            font-size: 13px;
            opacity: 0.85;
            font-weight: 300;
        }
        .bcs-pro-body {
            padding: 25px;
        }
        .bcs-pro-body .info-text {
            font-size: 14px;
            color: #455a64;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        /* Buttons Customization */
        .bcs-action-btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .bcs-action-btn:last-child { margin-bottom: 0; }
        
        .btn-app { background: #1b5e20; color: #ffffff !important; } /* Success Green */
        .btn-web { background: #0d47a1; color: #ffffff !important; } /* Primary Blue */
        .btn-blog { border: 2px solid #0d47a1; color: #0d47a1 !important; background: transparent; }
        
        .bcs-action-btn:hover { opacity: 0.9; transform: scale(1.02); }
    </style>

    <div class="bcs-pro-widget">
        <div class="bcs-pro-header">
            <h2>BCS Exam Aid</h2>
            <p>বিসিএস ও সরকারি চাকরির স্মার্ট প্ল্যাটফর্ম</p>
        </div>
        <div class="bcs-pro-body">
            <p class="info-text">
                ক্যাডারদের তত্ত্বাবধানে তৈরি ১ লক্ষাধিক প্রশ্ন এবং নির্ভুল সমাধানের মাধ্যমে আপনার স্মার্ট প্রস্তুতি নিশ্চিত করুন।
            </p>
            
            <div class="bcs-btn-container">
                <!-- App Link -->
                <a href="https://play.google.com/store" target="_blank" class="bcs-action-btn btn-app">
                    <i class="glyphicon glyphicon-phone"></i> অ্যাপ ডাউনলোড করুন
                </a>
                
                <!-- Website Link -->
                <a href="https://bcsexamaid.com" target="_blank" class="bcs-action-btn btn-web">
                    <i class="glyphicon glyphicon-globe"></i> ওয়েবসাইট ভিজিট করুন
                </a>
                
                <!-- Blog Link -->
                <a href="https://bcsexamaid.com/blogs" target="_blank" class="bcs-action-btn btn-blog">
                    <i class="glyphicon glyphicon-book"></i> প্রস্তুতি ব্লগ পড়ুন
                </a>
            </div>
        </div>
    </div>
@endsection

@section('js')
   
@endsection