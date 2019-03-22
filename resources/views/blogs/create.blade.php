@extends('layouts.index')
@section('title')
    IIT Alumni | Create New Blog
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote-bs3.css') }}">
@endsection

@section('content')
    <section class="wow fadeIn bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-sm-10 col-xs-11 center-col login-box">
                    <h1 style="text-align: center">Create New Blog</h1>
                    <form action="{{ route('blogs.store') }}" method="post" enctype='multipart/form-data'>
                        {!! csrf_field() !!}
                        <div class="form-group no-margin-bottom margin-two">
                            <input type="text" name="title" id="title" placeholder="Title of the Post" required="">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <select name="category_id" required="">
                                <option value="" selected="" disabled="">Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="body" class="text-uppercase">Body</label>
                            <textarea type="text" name="body" id="body" class="summernote" required=""></textarea>
                        </div>
                        <div class="row margin-three">
                          <div class="col-md-8">
                              <div class="form-group no-margin-bottom">
                                  <label><strong>Featured Image (750 X 430 &amp; 300Kb Max): (Optional)</strong></label>
                                  <input type="file" id="image" name="featured_image">
                              </div>
                          </div>
                          <div class="col-md-4">
                            <img src="{{ asset('images/600x315.png')}}" id='img-upload' style="height: 200px; width: auto; padding: 5px;" class="img-responsive" />
                          </div>
                        </div>
                        <button class="btn highlight-button-dark btn-bg btn-round margin-two no-margin-right" type="submit">Post Blog</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
    
    <script>
        $(document).ready(function(){
            $('.summernote').summernote({
                placeholder: 'Write Blog Post',
                tabsize: 2,
                height: 200,
                dialogsInBody: true
            });
            $('div.note-group-select-from-files').remove();
        });
    </script>

    <script type="text/javascript">
        $(document).ready( function() {
          $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
          });

          $('.btn-file :file').on('fileselect', function(event, label) {
              var input = $(this).parents('.input-group').find(':text'),
                  log = label;
              if( input.length ) {
                  input.val(log);
              } else {
                  if( log ) alert(log);
              }
          });
          function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                      $('#img-upload').attr('src', e.target.result);
                  }
                  reader.readAsDataURL(input.files[0]);
              }
          }
          $("#image").change(function(){
              readURL(this);
              var filesize = parseInt((this.files[0].size)/1024);
              if(filesize > 300) {
                $("#image").val('');
                toastr.warning('File size is: '+filesize+' Kb. try uploading less than 300Kb', 'WARNING').css('width', '400px;');
                  setTimeout(function() {
                    $("#img-upload").attr('src', '{{ asset('images/600x315.png') }}');
                  }, 1000);
              }
          });

        });
    </script>
@endsection