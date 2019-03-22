@extends('layouts.index')
@section('title')
    IIT Alumni | Ad Hoc Committee
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
                      <h1 class="black-text">Ad Hoc Committee...</h1>
                      <!-- end page title -->
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                      <!-- breadcrumb -->
                      <ul>
                          <li><a href="{{ route('index.index') }}">Home</a></li>
                          <li><a href="#">Committee</a></li>
                          <li>Ad Hoc Committee</li>
                      </ul>
                      <!-- end breadcrumb -->
                  </div>
              </div>
          </div>
      </section>
      <!-- end head section -->
      <!-- feature section -->
      <section>
          <div class="container">
              <div class="row margin-six">
              @foreach($adhocmembers as $adhocmember)
                <div class="col-md-3 col-sm-4 bottom-margin text-center xs-margin-bottom-one wow fadeInUp">
                    <div class="key-person">
                        <div class="key-person-img">
                          @if($adhocmember->image != null)
                          <img src="{{ asset('images/committee/adhoc/'.$adhocmember->image)}}" style="width: 100%; height: auto;" alt="">
                          @else
                          <img src="{{ asset('images/user.png') }}" alt="">
                          @endif
                        </div>
                        <div class="key-person-details no-border transparent">
                            <span class="person-name black-text margin-three no-margin-top">
                              {{ $adhocmember->name }}
                            </span>  
                            <span class="text-uppercase letter-spacing-2 display-block">
                                {{ $adhocmember->designation }}
                            </span>
                            <div class="person-social no-margin-bottom">
                                <a href="{{ $adhocmember->fb }}"><i class="fa fa-facebook"></i></a>
                                <a href="{{ $adhocmember->twitter }}"><i class="fa fa-twitter"></i></a>
                                <a href="{{ $adhocmember->gplus }}"><i class="fa fa-google-plus"></i></a>
                                <a href="{{ $adhocmember->linkedin }}"><i class="fa fa-linkedin"></i></a>
                            </div>
                            <div class="thin-separator-line bg-black"></div>
                        </div>
                    </div>
                </div>
              @endforeach
              </div>
          </div>
      </section> 
      <!-- end feature section -->
@endsection

@section('js')
   
@endsection