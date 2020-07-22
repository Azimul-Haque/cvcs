<!-- end page title -->





@extends('layouts.index')
@section('title')
    CVCS | আমাদের সম্পর্কে
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->

    <section class="content-top-margin bg-gray">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">গঠনতন্ত্র <a class="btn btn-warning btn-sm"
                                                                                                                                  href="{{ asset('files/সিভিসিএস_এর_উপ-আইণ.pdf') }}"
                                                                                                                                  title="উপ-আইণ ডাউনলোড করুন" download="">download</i></a></span>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
{{--    <section class="content-top-margin">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <!-- section title -->--}}
{{--                <div class="col-md-6 col-sm-6 xs-margin-bottom-four">--}}
{{--                    <h1 class="black-text"></h1>--}}
{{--                </div>--}}
{{--                <!-- end section title -->--}}
{{--               --}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <object data="{{ asset('files/সিভিসিএস_এর_উপ-আইণ.pdf') }}" type="application/pdf" width="100%"
                            height="1000">
                        <p>ডাউনলোড করুন <a href="{{ asset('files/সিভিসিএস_এর_উপ-আইণ.pdf') }}">গঠনতন্ত্র</a></p>
                    </object>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

@endsection
