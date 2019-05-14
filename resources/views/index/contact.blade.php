@extends('layouts.index')
@section('title')
    CVCS | Contact Us
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
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">যোগাযোগ</span>
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

    <section class="wow fadeIn">
        <div class="container">
            <div class="row">
                <!-- office address -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-ten">
                    <div class="position-relative"><img src="{{ asset('images/contact2.jpg') }}" alt=""/><a class="highlight-button-dark btn btn-very-small view-map no-margin bg-black white-text" href="https://www.google.co.in/maps" target="_blank">মানচিত্রে দেখুন</a></div>
                    <p class="text-med black-text letter-spacing-1 margin-ten no-margin-bottom text-uppercase font-weight-600 xs-margin-top-five">হেডঅফিস</p>
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="fa fa-map-marker black-text"></i> {{ $sharedbasicinfo->address }}</p>
                        </div>
                        <div class="col-md-6 xs-text-center">
                            <p class="black-text no-margin-bottom"><strong><i class="fa fa-phone black-text"></i></strong> {{ $sharedbasicinfo->contactno }}</p>
                            <p class="black-text"><strong><i class="fa fa-envelope black-text"></i></strong> <a href="mailto:{{ $sharedbasicinfo->email }}">{{ $sharedbasicinfo->email }}</a></p>
                        </div>
                    </div>
                </div>
                <!-- end office address -->

                <div class="col-md-6 col-sm-6">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 agency-title">যোগাযোগ ফরম</span><br/><br/><br/>
                    {!! Form::open(['route' => 'index.storeformmessage', 'method' => 'POST']) !!}
                        <div id="success" class="no-margin-lr"></div>
                        <input name="name" type="text" value="{{ old('name') }}" placeholder="আপনার নাম" required="" />
                        <input name="email" type="email" value="{{ old('email') }}" placeholder="ইমেইল এড্রেস"  required="" />
                        <textarea name="message" placeholder="বার্তা লিখুন"  required="">{{ old('message') }}</textarea>
                        
                        @php
                          $contact_num1 = rand(1,20);
                          $contact_num2 = rand(1,20);
                          $contact_sum_result_hidden = $contact_num1 + $contact_num2;
                        @endphp
                        <input type="hidden" name="contact_sum_result_hidden" value="{{ $contact_sum_result_hidden }}">
                        <input type="text" name="contact_sum_result" id="" class="form-control" placeholder="{{ $contact_num1 }} এবং {{ $contact_num2 }} এর যোগফল ইংরেজি সংখ্যায় লিখুন" required="">
                        
                        <button id="contact-us-button" type="submit" class="highlight-button-dark btn btn-small button xs-margin-bottom-five"><i class="fa fa-paper-plane"></i> বার্তা পাঠান</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="wow fadeIn no-padding">
        <div class="container-fuild">
            <div class="row no-margin">
                <div id="canvas1" class="col-md-12 col-sm-12 no-padding contact-map map">
                    <iframe id="map_canvas1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.3327701771523!2d90.40657421434813!3d23.73550999526332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8f466e346e1%3A0x156562bb3c98ad27!2sNational+Board+of+Revenue!5e0!3m2!1sen!2sbd!4v1554630821037!5m2!1sen!2sbd"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
   
@endsection