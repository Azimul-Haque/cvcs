@extends('layouts.index')
@section('title')
    CVCS | Video Tutorial |
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin wow fadeInUp bg-gray">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">ভিডিও টিউটোরিয়াল</span>
                </div>
                <!-- end section title -->
                <!-- section highlight text -->
                <div class="col-md-6 col-sm-6 text-right xs-text-left">
                    <span class="text-extra-large font-weight-400"></span>
                </div>
                <!-- end section highlight text -->
            </div>
        </div>
    </section>
    <!-- end head section -->

    <section style="padding: 13px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>সিভিসিএস অনলাইন প্লাটফর্মে যেভাবে 'আবেদন' ও 'লগইন' করবেন</h1>
                    <div class="youtibecontainer">
                        <iframe class="youtubeiframe" width="560" height="315" src="https://www.youtube.com/embed/EsIS_YulP4g" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div><br/><br/><br/><br/>
                </div>
                <div class="col-md-12">
                    <h1>সিভিসিএস অনলাইন প্লাটফর্মে 'একক পরিশোধ' করবেন যেভাবে</h1>
                    <div class="youtibecontainer">
                        <iframe class="youtubeiframe" width="560" height="315" src="https://www.youtube.com/embed/hpiRlo6Zxj4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div><br/><br/><br/><br/>
                </div>
                <div class="col-md-12">
                    <h1>সিভিসিএস অনলাইন প্লাটফর্মে পেমেন্ট গেটওয়ের মাধ্যমে 'অনলাইন পরিশোধ' করবেন যেভাবে</h1>
                    <div class="youtibecontainer">
                        <iframe class="youtubeiframe" width="560" height="315" src="https://www.youtube.com/embed/brWcNO5xcKw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
            <h2 style="font-family: 'Arial'; color: #ffffff;">BCS Exam Aid</h2>
            <p>বিসিএস ও সরকারি চাকরির স্মার্ট প্ল্যাটফর্ম</p>
        </div>
        <div class="bcs-pro-body">
            <p class="info-text">
                ক্যাডারদের তত্ত্বাবধানে তৈরি ২২০০+ টপিকে ১ লক্ষাধিক প্রশ্ন এবং নির্ভুল সমাধানের মাধ্যমে আপনার স্মার্ট প্রস্তুতি নিশ্চিত করুন।
            </p>
            
            <div class="bcs-btn-container">
                <!-- App Link -->
                <a href="https://play.google.com/store/apps/details?id=com.orbachinujbuk.bcs" target="_blank" class="bcs-action-btn btn-app">
                    📱 অ্যাপ ডাউনলোড করুন
                </a>
                
                <!-- Website Link -->
                <a href="https://bcsexamaid.com" target="_blank" class="bcs-action-btn btn-web">
                    🌐 ওয়েবসাইট ভিজিট করুন
                </a>
                
                <!-- Blog Link -->
                <a href="https://bcsexamaid.com/blogs" target="_blank" class="bcs-action-btn btn-blog">
                    ✒️ প্রস্তুতি ব্লগ পড়ুন
                </a>
            </div>
        </div>
    </div>
@endsection

@section('js')
   
@endsection