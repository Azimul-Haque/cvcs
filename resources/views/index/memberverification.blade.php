@extends('layouts.index')
@section('title')
    CVCS | Member Verification
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin page-title-small bg-gray">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-md-12 col-sm-12 xs-margin-bottom-four wow fadeInUp">
                    <span class="text-large letter-spacing-2 black-text font-weight-600 text-uppercase agency-title">সদস্য যাচাইকরণ</span>
                </div>
                <!-- end section title -->
            </div>
        </div>
    </section>
    <!-- end head section -->

    <section style="padding: 13px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    @if($member)
                        <center>
                            <big>
                                <b>সদস্য খুঁজে পাওয়া গেছে!</b>
                            </big>
                        </center>
                        <table class="table table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <center>
                                            @if($member->image != null)
                                                <img src="{{ asset('images/users/'.$member->image)}}" alt="image of {{ $member->name }}" class="img-responsive img-circle shadow" style="max-width: 220px; height: auto; padding: 2px; margin: 10px;" />
                                            @else
                                                <img src="{{ asset('images/user.png')}}" alt="image of {{ $member->name }}" class="img-responsive img-circle shadow" style="max-width: 220px; height: auto; padding: 2px; margin: 10px;" />
                                            @endif
                                        </center>
                                    </td>
                                </tr>
                                <tr>
                                    <td>সদস্যপদ নং</td>
                                    <td>{{ bangla($member->member_id) }}</td>
                                </tr>
                                <tr>
                                    <td>নাম</td>
                                    <td>{{ $member->name_bangla }}<br/>{{ $member->name }}</td>
                                </tr>
                                <tr>
                                    <td>পদবি</td>
                                    <td>{{ $member->designation }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <img src="{!! QrCode::size(500) ->format('png') ->generate('ItSolutionStuff.com', public_path('images/qrcode.png')); !!}">
                        {!! QrCode::size(200)->generate('Make me into a QrCode!'); !!}
                    @else
                        <center>
                            <big>
                                <b style="color: Red;">কোন সদস্য খুঁজে পাওয়া যায়নি!</b>
                            </big>
                        </center>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
   
@endsection