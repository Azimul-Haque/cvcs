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
    <!-- BCS Exam Aid Widget - Professional Version -->
    <style>
        /* কনফ্লিক্ট এড়াতে স্পেসিফিক ক্লাস ব্যবহার করা হয়েছে */
        .bcs-widget-card {
            max-width: 360px;
            margin: 15px auto;
            border: 1px solid #e1e4e8;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .bcs-widget-card:hover {
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
            transform: translateY(-3px);
        }
        .bcs-widget-header {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            color: #ffffff;
            padding: 20px 15px;
            text-align: center;
        }
        .bcs-widget-header h4 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 19px;
        }
        .bcs-widget-header p {
            margin: 5px 0 0;
            font-size: 12px;
            opacity: 0.9;
        }
        .bcs-widget-body {
            padding: 20px 25px;
            background: #ffffff;
        }
        .bcs-widget-body .desc {
            color: #586069;
            font-size: 13.5px;
            line-height: 1.5;
            margin-bottom: 20px;
            text-align: center;
        }
        .bcs-btn-group .btn {
            margin-bottom: 12px;
            padding: 10px;
            font-weight: 600;
            font-size: 13px;
            border-radius: 6px;
            transition: opacity 0.2s;
        }
        .bcs-btn-group .btn:last-child { margin-bottom: 0; }
        
        /* আইকন ও কালার কাস্টমাইজেশন */
        .btn-google { background-color: #00875f !important; border-color: #00875f !important; color: #fff !important; }
        .btn-site { background-color: #1a237e !important; border-color: #1a237e !important; color: #fff !important; }
        .btn-blog { background-color: #03a9f4 !important; border-color: #03a9f4 !important; color: #fff !important; }
    </style>

    <div class="panel panel-default bcs-widget-card">
        <div class="bcs-widget-header">
            <h4>BCS Exam Aid</h4>
            <p>Your Gateway to Civil Service Excellence</p>
        </div>
        <div class="bcs-widget-body">
            <p class="desc">
                ১ লক্ষাধিক প্রশ্ন এবং বিসিএস ক্যাডারদের প্রত্যক্ষ তত্ত্বাবধানে তৈরি বাংলাদেশের অন্যতম ডিজিটাল লার্নিং প্ল্যাটফর্ম।
            </p>
            
            <div class="bcs-btn-group">
                <!-- App Link -->
                <a href="https://play.google.com/store" target="_blank" class="btn btn-success btn-block btn-google">
                    <i class="glyphicon glyphicon-play"></i> Get Android App
                </a>
                
                <!-- Website Link -->
                <a href="https://bcsexamaid.com" target="_blank" class="btn btn-primary btn-block btn-site">
                    <i class="glyphicon glyphicon-globe"></i> Official Website
                </a>
                
                <!-- Blog Link -->
                <a href="https://bcsexamaid.com/blogs" target="_blank" class="btn btn-info btn-block btn-blog">
                    <i class="glyphicon glyphicon-edit"></i> Preparation Blogs
                </a>
            </div>
        </div>
    </div>
@endsection

@section('js')
   
@endsection