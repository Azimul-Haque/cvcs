@extends('adminlte::page')

@section('title', 'CVCS | Gallery | Create Album')

@section('css')

@stop

@section('content_header')
    <h1>
      <i class="fa fa-fw fa-plus" aria-hidden="true"></i> Gallery | Create Album
      {{-- <div class="pull-right">
        <a class="btn btn-success" href="{{ route('dashboard.creategallery') }}"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Album</a>
      </div> --}}
    </h1>
@stop

@section('content')
    <div class="row">
      {!! Form::open(['route' => 'dashboard.storegallery', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
      <div class="col-md-3">
        <div class="box box-primary">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-picture-o"></i>
            <h3 class="box-title">Album Information</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
              <div class="form-group">
                {!! Form::text('name', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Album Name')) !!}
              </div>
              <div class="form-group">
                <textarea class="form-control text-blue" name="description" style="resize: none; height: 100px;" placeholder="Album Description"></textarea>
              </div>
              <div class="form-group">
                  <label>Thumbnail (8:5 &amp; 500Kb Max)</label>
                  <div class="input-group">
                      <span class="input-group-btn">
                          <span class="btn btn-default btn-file">
                              Browse <input type="file" id="image" name="thumbnail" required="">
                          </span>
                      </span>
                      <input type="text" class="form-control text-blue" readonly>
                  </div>
                  <center>
                    <img src="{{ asset('images/800x500.png')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                  </center>
              </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-9">
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-picture-o"></i>
            <h3 class="box-title">Photo (s)</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Photo 1 (8:5 &amp; 500Kb Max):</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse <input type="file" id="image1" name="image1">
                                </span>
                            </span>
                            <input type="text" class="form-control text-green" readonly>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Photo 1 Caption:</label>
                      {!! Form::text('caption1', null, array('class' => 'form-control text-green', 'placeholder' => 'Photo 1 Caption')) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <center>
                  <img src="{{ asset('images/800x500.png')}}" id='img-upload1' style="height: 100px; width: auto; padding: 5px;" />
                </center>
              </div>
            </div>
            <div class="row">
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Photo 2 (8:5 &amp; 500Kb Max):</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse <input type="file" id="image2" name="image2">
                                </span>
                            </span>
                            <input type="text" class="form-control text-green" readonly>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Photo 2 Caption:</label>
                      {!! Form::text('caption2', null, array('class' => 'form-control text-green', 'placeholder' => 'Photo 2 Caption')) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <center>
                  <img src="{{ asset('images/800x500.png')}}" id='img-upload2' style="height: 100px; width: auto; padding: 5px;" />
                </center>
              </div>
            </div>
            <div class="row">
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Photo 3 (8:5 &amp; 500Kb Max):</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse <input type="file" id="image3" name="image3">
                                </span>
                            </span>
                            <input type="text" class="form-control text-green" readonly>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Photo 3 Caption:</label>
                      {!! Form::text('caption3', null, array('class' => 'form-control text-green', 'placeholder' => 'Photo 3 Caption')) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <center>
                  <img src="{{ asset('images/800x500.png')}}" id='img-upload3' style="height: 100px; width: auto; padding: 5px;" />
                </center>
              </div>
            </div>
            <p class="text-green"><small><i class="fa fa-info-circle"></i> You can upload more photos from edit after creating this Album</small></p>
            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Upload</button>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      {!! Form::close() !!}
    </div>

@stop

@section('js')
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
          if(filesize > 500) {
            $("#image").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
      function readURL1(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload1').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image1").change(function(){
          readURL1(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 500) {
            $("#image1").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload1").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
      function readURL2(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload2').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image2").change(function(){
          readURL2(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 500) {
            $("#image2").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload2").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
      function readURL3(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload3').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image3").change(function(){
          readURL3(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 500) {
            $("#image3").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload3").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
    });
  </script>
@stop