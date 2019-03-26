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
      {!! Form::model($album, ['route' => ['dashboard.updategallery', $album->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
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
                <textarea class="form-control text-blue" name="description" style="resize: none; height: 100px;" placeholder="Album Description" required="">{{ $album->description }}</textarea>
              </div>
              <div class="form-group">
                  {{-- <label>Thumbnail (8:5 &amp; 500Kb Max):</label>
                  <div class="input-group">
                      <span class="input-group-btn">
                          <span class="btn btn-default btn-file">
                              Browse <input type="file" id="image" name="thumbnail" required="">
                          </span>
                      </span>
                      <input type="text" class="form-control text-blue" readonly>
                  </div> --}}
                  <center>
                    <img src="{{ asset('images/gallery/'.$album->thumbnail)}}" id='' style="height: 100px; width: auto; padding: 5px;" />
                  </center>
              </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-3">
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-upload"></i>
            <h3 class="box-title">Upload Photo</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
                <div class="form-group">
                    <label>Photo (8:5 &amp; 500Kb Max):</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="image" name="image">
                            </span>
                        </span>
                        <input type="text" class="form-control text-green" readonly>
                    </div>
                </div>
                <div class="form-group">
                  <label>Caption:</label>
                  {!! Form::text('caption', null, array('class' => 'form-control text-green', 'placeholder' => 'Caption')) !!}
                </div>

                <center>
                  <img src="{{ asset('images/800x500.png')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                </center>

                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Upload</button>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        {!! Form::close() !!}
        <div class="col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border text-orange">
              <i class="fa fa-fw fa-trash"></i>
              <h3 class="box-title">Delete Photo</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                @foreach($album->albumphotoes as $albumphoto)
                <div class="col-md-4">
                  <div class="delete-img-box">
                      <img src="{{ asset('images/gallery/'. $albumphoto->image) }}" alt="Album Image" class="img-responsive">
                      <a href="#" class="btn btn-sm btn-danger" title="Delete Photo" data-toggle="modal" data-target="#deleteAlbumPhoto{{ $albumphoto->id }}" data-backdrop="static"><i class="fa fa-trash"></i></a>
                      <!-- Delete Photo Modal -->
                      <!-- Delete Photo Modal -->
                      <div class="modal fade" id="deleteAlbumPhoto{{ $albumphoto->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header modal-header-danger">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Delete Photo</h4>
                            </div>
                            <div class="modal-body">
                              Confirm Delete the photo<br/><br/><br/>
                              <center>
                                <img src="{{ asset('images/gallery/'. $albumphoto->image) }}" alt="Album Image" class="img-responsive" style="max-height: 200px; width: auto;">
                                <small class="text-red"><b><i class="fa fa-info-circle"></i> The image will be lost.</b></small>
                              </center>
                            </div>
                            <div class="modal-footer">
                              {!! Form::model($albumphoto, ['route' => ['dashboard.deletesinglephoto', $albumphoto->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                                  {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Delete Photo Modal -->
                      <!-- Delete Photo Modal -->
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
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
    });
  </script>
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
     $('button[title]').tooltip();
    });
  </script>
@stop