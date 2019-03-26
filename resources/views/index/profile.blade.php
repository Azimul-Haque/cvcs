@extends('layouts.index')
@section('title')
    CVCS | {{ Auth::user()->name }}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@endsection

@section('content')
    <section id="features" class="content-top-margin border-bottom no-padding-bottom xs-onepage-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    {{-- <h2 class="section-title no-padding">{{ $user->name_bangla }}</h2> --}}
                </div>
            </div>
            @if($user->activation_status == 0)
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn highlight-button-royal-blue-border btn-lg btn-round"><i class="fa fa-exclamation-triangle"></i> একাউন্টটি প্রক্রিয়াধীন</button>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="section-title no-padding">প্রোফাইল</h2>
                </div>
            </div>
            @endif
            <div class="row margin-three no-margin-bottom">
                <div class="col-md-6 col-sm-6 text-center xs-margin-bottom-ten">
                    <center>
                        @if($user->image != null)
                            <img src="{{ asset('images/users/'.$user->image)}}" alt="image of {{ $user->name }}" class="img-responsive shadow" style="max-width: 220px; height: auto;" />
                        @else
                            <img src="{{ asset('images/user.png')}}" alt="image of {{ $user->name }}" class="img-responsive shadow" style="max-width: 220px; height: auto;" />
                        @endif
                        <br/>
                        {{-- <button class="btn highlight-button-dark btn-small btn-round margin-two"><i class="fa fa-pencil"></i> Edit Profile</button> --}}
                    </center>
                </div>
                <div class="col-md-6 col-sm-6 sm-margin-bottom-ten">
                    <div class="col-md-12 col-sm-12 no-padding">
                        <table class="table">
                            <tr>
                                <td>নামঃ</td>
                                <td>: {{ $user->name_bangla }} ({{ $user->name }})</td>
                            </tr>
                            <tr>
                                <td>দপ্তর</td>
                                <td>: {{ $user->office }}</td>
                            </tr>
                            <tr>
                                <td>পেশা ও পদবি</td>
                                <td>: {{ $user->profession }} ({{ $user->designation }})</td>
                            </tr>
                            <tr>
                                <td>ইমেইল এড্রেস</td>
                                <td>: {{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>সদস্যপদ</td>
                                <td>: 
                                    @if($user->activation_status == 0)
                                    <span style="color:red;">প্রক্রিয়াধীন</span>
                                    @else
                                    <span style="color: green;">সক্রিয়</span>
                                    @endif
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>Social</td>
                                <td>: 
                                    @if($user->fb != null)
                                    <a href="{{ $user->fb }}" style="font-size: 25px;" target="_blank"><i class="fa fa-facebook-official" style="color: #4267B0;"></i></a>
                                    @endif

                                    @if($user->twitter != null)
                                    <a href="{{ $user->twitter }}" style="font-size: 25px" target="_blank"><i class="fa fa-twitter-square" style="color: #20A1F0;"></i></a>
                                    @endif

                                    @if($user->gplus != null)
                                    <a href="{{ $user->gplus }}" style="font-size: 25px" target="_blank"><i class="fa fa-google-plus-square" style="color: #DB473B;"></i></a>
                                    @endif

                                    @if($user->linkedin != null)
                                    <a href="{{ $user->linkedin }}" style="font-size: 25px" target="_blank"><i class="fa fa-linkedin-square" style="color: #0874B1;"></i></a>
                                    @endif
                                </td>
                            </tr> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <section class="wow fadeIn bg-gray">
        <div class="container">
            {{-- blog part --}}
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="section-title no-padding">Blog</h2>
                </div>
            </div>
            <div class="row margin-three no-margin-bottom">
                <div class="col-md-12">
                    <div class="row margin-one">
                        <div class="col-md-6">
                            <span style="font-size: 20px;"><b>Your Blogs</b></span>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('blogs.create') }}" style="float: right; padding: 5px; margin-left: 10px; border: 1px solid #000">
                                <h3><i class="fa fa-plus"></i> Create New Blog</h3>
                            </a>
                            <a href="{{ route('blogger.profile', $user->unique_key) }}" style="float: right; padding: 5px; margin-left: 10px; border: 1px solid #000" target="_blank">
                                <h3><i class="fa fa-user"></i> Your Blogger Profile</h3>
                            </a>
                        </div>
                    </div>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                            <tr>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->category->name }}</td>
                                <td>{{ $blog->created_at }}</td>
                                <td>
                                    <button class="btn highlight-button-dark btn-small btn-round margin-two"><i class="fa fa-pencil"></i></button>
                                    <button class="btn highlight-button-dark btn-small btn-round margin-two"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- blog part --}}
        </div>
    </section> -->
@endsection

@section('js')

@endsection