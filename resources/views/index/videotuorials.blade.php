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
                        <iframe class="youtubeiframe" width="560" height="315" src="https://www.youtube.com/embed/BRPgv1D14DQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
   
@endsection