@extends('layouts.index')
@section('title')
    IIT Alumni | Members
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
   <!-- head section -->
    <section class="content-top-margin page-title page-title-small border-bottom-light border-top-light">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                    <!-- page title -->
                    <h1 class="black-text">Alumni Association Members</h1>
                    <!-- end page title -->
                </div>
                
            </div>
        </div>
    </section>
    <!-- end head section -->
    <!-- content section -->
    <section class="wow fadeIn">
        <div class="container">
            <div class="row">
                <!-- team member -->
                @php $counter = 1; @endphp
                @foreach($members as $member)
                <div class="col-md-3 col-sm-6 text-center team-member position-relative wow fadeInUp" 
                @if((($counter+1)%2==0) && (($counter+1)%4!=0))
                    data-wow-duration="300ms" 
                @elseif(($counter%2==0) && ($counter%4!=0))
                    data-wow-duration="600ms"
                @elseif((($counter+1)%4==0))
                    data-wow-duration="900ms"
                @elseif($counter%4==0)
                    data-wow-duration="1200ms"
                @endif
                >
                    <img src="{{ asset('images/users/'.$member->image) }}" alt="" style="width: 100%;" />
                    <figure class="position-relative bg-white">
                        <span class="team-name text-uppercase black-text letter-spacing-2 display-block font-weight-600">{{ $member->name }}</span>
                        <span class="team-post text-uppercase letter-spacing-2 display-block">
                            {{ $member->degree }} {{ $member->batch }}
                        </span>
                        <div class="person-social margin-five no-margin-bottom">
                            <a href="{{ $member->fb }}"><i class="fa fa-facebook"></i></a>
                            <a href="{{ $member->twitter }}"><i class="fa fa-twitter"></i></a>
                            <a href="{{ $member->gplus }}"><i class="fa fa-google-plus"></i></a>
                            <a href="{{ $member->linkedin }}"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </figure>
                    <div class="team-details">
                        <h5 class="team-headline white-text text-uppercase font-weight-600">{{ $member->designation }}</h5>
                        <p class="width-70 center-col light-gray-text margin-five">
                            {{ $member->current_job }}
                        </p>
                        <div class="separator-line-thick bg-white"></div>
                    </div>
                </div>
                @php $counter++; @endphp
                @endforeach
                <!-- end team member -->
            </div>
        </div>
    </section>
@endsection

@section('js')

@endsection