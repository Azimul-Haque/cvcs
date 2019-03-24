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
                    <div class="position-relative"><img src="{{ asset('images/contact2.jpg') }}" alt=""/><a class="highlight-button-dark btn btn-very-small view-map no-margin bg-black white-text" href="https://www.google.co.in/maps" target="_blank">View Map</a></div>
                    <p class="text-med black-text letter-spacing-1 margin-ten no-margin-bottom text-uppercase font-weight-600 xs-margin-top-five">London - Head Office</p>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Suite 4 Level 1, 141 Bridge Road<br> London, E2 8DY.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="black-text no-margin-bottom"><strong>T.</strong> 123 456 7890</p>
                            <p class="black-text"><strong>E.</strong> <a href="mailto:no-reply@domain.com">no-reply@domain.com</a></p>
                        </div>
                    </div>
                </div>
                <!-- end office address -->

                <div class="col-md-6 col-sm-6">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 agency-title">যোগাযোগ ফরম</span><br/><br/><br/>
                    <form id="contactusform" action="javascript:void(0)" method="post">
                        <div id="success" class="no-margin-lr"></div>
                        <input name="name" type="text" placeholder="Your Name" />
                        <input name="email" type="text" placeholder="Your Email"  />
                        <textarea placeholder="Your Message" name="comment"></textarea>
                        <input name="email" type="text" placeholder="5 + 7 = ?"  />
                        <button id="contact-us-button" type="submit" class="highlight-button-dark btn btn-small button xs-margin-bottom-five">Send message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="wow fadeIn no-padding">
        <div class="container-fuild">
            <div class="row no-margin">
                <div id="canvas1" class="col-md-12 col-sm-12 no-padding contact-map map">
                    <iframe id="map_canvas1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.843821917424!2d144.956054!3d-37.817127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sin!4v1427947693651"></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
   
@endsection