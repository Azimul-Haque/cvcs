@extends('layouts.easyperiodarticlelayout')
@section('title')
    {{ $article->title }}
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
@if($article->featured_image != null)
    <meta property="og:image" content="{{ asset('images/easyperiod/articles/' . $article->featured_image) }}">
@else
    <meta property="og:image" content="{{ asset('images/easyperiod/articles/feature.png') }}">
@endif

<meta property="og:title" content="{{ $article->title }}"/>
<meta name="description" property="og:description" content="{{ substr(strip_tags($article->body), 0, 200) }}" />
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{ Request::url() }}" />
<meta property="og:site_name" content="TenX">
<meta name="og:locale" content="en_US">
<meta name="fb:admins" content="100001596964477">
<meta name="fb:app_id" content="163879201229487">
<meta name="og:type" content="article">
<!-- Open Graph - Article -->
<meta name="article:section" content="{{ $article->category }}">
<meta name="article:published_time" content="{{ $article->created_at}}">
<meta name="article:author" content="A. H. M. Azimul Haque">
<meta name="article:tag" content="{{ $article->category }}">
<meta name="article:modified_time" content="{{ $article->updated_at}}">
@endsection

@section('content')
    {{-- facebook comment plugin --}}
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.2&appId=163879201229487&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    {{-- facebook comment plugin --}}

    <!-- content section -->
    <section class="wow fadeIn xs-margin-top-two margin-top-two">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="blog-details-headline text-black">{{ $article->title }}</h2>
                    <div class="blog-date no-padding-top">By <b>{{ $article->author }}</b> | {{ date('F d, Y', strtotime($article->created_at)) }}</div>
                    <!-- end date and categories   -->
                    <!-- post image -->
                    @if($article->featured_image != null)
                        <div class="blog-image margin-three"><img src="{{ asset('images/easyperiod/articles/'.$article->featured_image) }}" alt="" style="width: 100%;"></div>
                    @endif

                    <!-- end post image -->
                    <!-- post details text -->
                    <div class="blog-details-text">
                        <p>
                            {!! $article->body !!}
                            {{-- solved the strong, em and p problem --}}
                            @if(substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "<strong>") == substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "</strong>"))
                            @else
                              </strong>
                            @endif
                            @if(substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "<b>") == substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "</b>"))
                            @else
                              </b>
                            @endif
                            @if(substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "<b>") == substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "</b>"))

                            @else
                              </b>
                            @endif
                            @if(substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "<em>") == substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "</em>"))

                            @else
                              </em>
                            @endif
                            @if(substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "<p>") == substr_count(substr($article->body, 0, stripos($article->body, " ", stripos(strip_tags($article->body), " ")+0)), "</p>"))
                            @else
                              </p>
                            @endif
                            {{-- solved the strong, em and p problem --}}
                        </p>

                        <div class="separator-line bg-black no-margin-lr margin-four"></div>
                        <div>
                            <a href="#fb-comments" class="comment"><i class="fa fa-comment-o"></i>
                            <span id="comment_count"></span> comment(s)</a>

                            <a href="#" class="blog-share" data-toggle="modal" data-target="#shareModal"><i class="fa fa-share-alt"></i>Share</a>
                        </div>
                        <!-- end post tags -->
                    </div>
                    <!-- end post details text -->
                    
                    <!-- blog comment -->

                    <div class="blog-comment-main xs-no-padding-top">
                        <h5 class="widget-title">Article Comments</h5>
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                    </div>
                    <div class="fb-comments" id="fb-comments" data-href="{{ Request::url() }}" data-width="100%" data-numposts="5"></div>
                    <!-- end blog comment -->
                </div>
                <!-- end content  -->
            </div>
        </div>
    </section>
    <!-- end content section -->

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-share-alt" aria-hidden="true"></i> Share this Blog</h4>
            </div>
            <div class="modal-body">
              <p>
              <!-- social icon -->
              <div class="text-center margin-ten padding-four no-margin-top">
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-facebook"></i></a>
                  <a href="https://twitter.com/intent/tweet?url={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-twitter"></i></a>
                  <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url()}}&title=EasyPeriod%20App%20Article&summary={{ $article->title }}&source=EasyPeriod" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-linkedin"></i></a>
              </div>
              <!-- end social icon -->
              </p>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> --}}
          </div>
          
        </div>
    </div>
@endsection

@section('js')
    
@endsection