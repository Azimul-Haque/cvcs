@extends('layouts.index')
@section('title')
    CVCS | বর্তমান কমিটি
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
                      <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">বর্তমান কমিটি</span>
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
      <section>
          <div class="container">
              <div class="row margin-six">
              @foreach($committeemembers as $committeemember)
                <div class="col-md-3 col-sm-6 bottom-margin text-center xs-margin-bottom-one wow fadeInUp">
                    <div class="key-person box-committee">
                        <div class="key-person-img">
                          @if($committeemember->image != null)
                          <img src="{{ asset('images/committee/'.$committeemember->image)}}" style="width: 100%; height: auto;" alt="">
                          @else
                          <img src="{{ asset('images/user.png') }}" alt="">
                          @endif
                        </div>
                        <div class="key-person-details no-border no-padding-bottom transparent">
                            <span class="person-name black-text margin-three no-margin-top">
                              {{ $committeemember->name }}
                            </span>  
                            <span class="text-uppercase letter-spacing-2 display-block">
                                {{ $committeemember->designation }}
                            </span>
                            <div class="person-social no-margin-bottom">
                                <a href="{{ $committeemember->fb }}"><i class="fa fa-facebook"></i></a>
                                <a href="{{ $committeemember->twitter }}"><i class="fa fa-twitter"></i></a>
                                <a href="{{ $committeemember->gplus }}"><i class="fa fa-google-plus"></i></a>
                                <a href="{{ $committeemember->linkedin }}"><i class="fa fa-linkedin"></i></a>
                            </div>
                            <div class="thin-separator-line bg-black"></div>
                        </div>
                    </div><br/>
                </div>
              @endforeach
              </div>
          </div>
      </section> 
      <!-- end feature section -->
@endsection

@section('js')
   
@endsection