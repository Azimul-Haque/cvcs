@extends('layouts.index')
@section('title')
    IIT Alumni | Blogs
@endsection

@section('css')

@endsection

@section('content')
    <!-- head section -->
    <section class="content-top-margin page-title page-title-small bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 wow fadeInUp" data-wow-duration="300ms">
                    <!-- page title -->
                    <h1 class="black-text">Blogs...</h1>
                    <!-- end page title -->
                </div>
                <div class="col-md-4 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none" data-wow-duration="600ms">
                    <!-- breadcrumb -->
                    <ul>
                        <li><a href="{{ route('index.index') }}">Home</a></li>
                        <li><a href="{{ route('blogs.index') }}">Blog</a></li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
        </div>
    </section>
    <!-- end head section -->

    <!-- content section -->
    <section class="wow fadeIn no-margin-top">
        <div class="container">
            <div class="row">
                <!-- content  -->
                <div class="col-md-8 col-sm-8">
                    {{-- <h2 class="hidden-xs margin-four">Blogs</h2>
                    <h2 class="visible-xs margin-ten xs-no-margin-bottom">Blogs</h2> --}}
                    <!-- post item -->
                    @foreach ($blogs as $blog)
                    <div class="blog-listing blog-listing-classic no-margin-top wow fadeIn">
                        <!-- post image -->
                        @if($blog->featured_image != null)
                            <div class="blog-image"><a href="{{ route('blog.single', $blog->slug) }}"><img src="{{ asset('images/blogs/'.$blog->featured_image) }}" alt="" style="width: 100%;" /></a></div>
                        @endif
                        <!-- end post image -->
                        <div class="blog-details">
                            <div class="blog-date">Posted by <a href="{{ route('blogger.profile', $blog->user->unique_key) }}"><b>{{ $blog->user->name }}</b></a> | {{ date('F d, Y', strtotime($blog->created_at)) }} | <a href="{{ route('blog.categorywise', $blog->category->name) }}">{{ $blog->category->name }}</a> </div>
                            <div class="blog-title"><a href="{{ route('blog.single', $blog->slug) }}">
                                {{ $blog->title }}
                            </a></div>
                            <div style="text-align: justify;">
                                @if(strlen(strip_tags($blog->body))>600)
                                    {{ mb_substr(strip_tags($blog->body), 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+500))." [...] " }}

                                @else
                                    {{ strip_tags($blog->body) }}
                                @endif
                            </div>
                            <div class="separator-line bg-black no-margin-lr margin-four"></div>
                            <div>
                                <a href="#!" class="blog-like"><i class="fa fa-heart-o"></i>{{ $blog->likes }} Like(s)</a>
                                <a href="#!" class="comment"><i class="fa fa-comment-o"></i>
                                <span id="comment_count{{ $blog->id }}"></span>
                                 comment(s)</a>
                            </div>
                            <a class="highlight-button btn btn-small xs-no-margin-bottom" href="{{ route('blog.single', $blog->slug) }}">Continue Reading</a>
                        </div>
                    </div>
                    <script type="text/javascript" src="{{ asset('vendor/hcode/js/jquery.min.js') }}"></script>
                    <script type="text/javascript">
                        $.ajax({
                            url: "https://graph.facebook.com/v2.2/?fields=share{comment_count}&id={{ url('/blog/'.$blog->slug) }}",
                            dataType: "jsonp",
                            success: function(data) {
                                $('#comment_count{{ $blog->id }}').text(data.share.comment_count);
                            }
                        });
                    </script>
                    @endforeach
                    <!-- end post item -->
                    {{-- paginating --}}
                    {{ $blogs->links() }}

                </div>
                <!-- end content  -->
                <!-- sidebar  -->
                <div class="col-md-3 col-sm-4 col-md-offset-1 xs-margin-top-ten sidebar">
                    @include('partials._blog_sidebar')
                </div>
                <!-- end sidebar  -->
            </div>
        </div>
    </section>
    <!-- end content section -->
@endsection

@section('js')

@endsection