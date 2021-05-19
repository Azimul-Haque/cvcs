@extends('adminlte::page')

@section('title', 'EasyPeriod | Create Article')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/summernote/summernote-bs3.css') }}">
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      EasyPeriod | Create Article
      <div class="pull-right">

      </div>
    </h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-8">
        <div class="box box-primary" id="beforedivheightcommodity">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">Create Article</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <form action="{{ route('easyperiod.article.store') }}" method="post" enctype='multipart/form-data'>
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="title" class="text-uppercase">Title</label>
                      <input class="form-control" type="text" name="title" id="title" placeholder="Write Title" required="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="publishing_date" class="text-uppercase">Author</label>
                      <input class="form-control" type="text" name="author" id="author" placeholder="Author Name" required="">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="publishing_date" class="text-uppercase">Category</label>
                      <input class="form-control" type="text" name="category" id="category" placeholder="Write Category" required="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="slug" class="text-uppercase">Slug</label>
                      <input class="form-control" type="text" name="slug" id="slug" value="easyperiod-app-article-{{ time()}}" placeholder="Write a Slug (e.g. this-is-a-post)" required="">
                  </div>
                </div>
              </div>

              <div class="form-group no-margin-bottom">
                  <label for="body" class="text-uppercase">Body</label>
                  <textarea type="text" name="body" id="body" class="summernote" required=""></textarea>
              </div>
              <div class="row margin-three">
                <div class="col-md-8">
                    <div class="form-group no-margin-bottom">
                        <label><strong>Featured Image (600w X 315h &amp; 300Kb Max): (Optional)</strong></label>
                        <input type="file" id="image" name="featured_image" accept="image/*">
                    </div>
                </div>
                <div class="col-md-4">
                  <img src="{{ asset('images/600x315.png')}}" id='img-upload' style="height: 200px; width: auto; padding: 5px;" class="img-responsive" />
                </div>
              </div>
              <button class="btn btn-success" type="submit">Post Article</button>
          </form>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>
    
    <script>
        $(document).ready(function(){
            $('.summernote').summernote({
                placeholder: 'Write Article Post',
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