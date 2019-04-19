@extends('adminlte::page')

@section('title', 'CVCS | Slider')

@section('css')
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      <i class="fa fa-fw fa-plus" aria-hidden="true"></i> স্লাইডার
      <div class="pull-right">
        <a class="btn btn-info" href="#!" title="হোমপেইজে লোড প্রেশার কম রাখবার জন্য, স্লাইডারে ৩ থেকে ৫টি ছবির মাঝে সীমাবদ্ধ থাকা সমীচীন" data-placement="bottom"><i class="fa fa-info-circle"></i></a>
      </div>
    </h1>
@stop

@section('content')
    <div class="row">
      {!! Form::open(['route' => 'dashboard.storeslider', 'method' => 'POST', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data']) !!}
      <div class="col-md-4">
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-upload"></i>
            <h3 class="box-title">ছবি আপলোড করুন</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
                <div class="form-group">
                    <label>ছবি (দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:৩ হওয়া বাঞ্ছনীয়):</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                ব্রাউজ করুন <input type="file" id="image" name="image" required="" data-parsley-required-message = "ছবি সিলেক্ট করুন">
                            </span>
                        </span>
                        <input type="text" class="form-control text-green" readonly>
                    </div>
                </div>
                <div class="form-group">
                  <label>টাইটেল</label>
                  {!! Form::text('title', null, array('class' => 'form-control text-green', 'placeholder' => 'টাইটেল', 'required' => '', 'data-parsley-required-message' => 'টাইটেল আবশ্যক')) !!}
                </div>

                <center>
                  <img src="{{ asset('images/300x100.png')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                </center>

                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> আপলোড করুন</button>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        {!! Form::close() !!}
        <div class="col-md-8">
          <div class="box box-warning">
            <div class="box-header with-border text-orange">
              <i class="fa fa-fw fa-trash"></i>
              <h3 class="box-title">ছবি অপসারণ করুন</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                @foreach($sliders as $slider)
                <div class="col-md-4">
                  <div class="delete-img-box">
                      <img src="{{ asset('images/slider/'. $slider->image) }}" alt="Album Image" class="img-responsive">
                      <a href="#" class="btn btn-sm btn-danger" title="ছবি মুছে ফেলুন" data-toggle="modal" data-target="#deleteSliderPhoto{{ $slider->id }}" data-backdrop="static"><i class="fa fa-trash"></i></a>
                      <!-- Delete Photo Modal -->
                      <!-- Delete Photo Modal -->
                      <div class="modal fade" id="deleteSliderPhoto{{ $slider->id }}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header modal-header-danger">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">ছবি মুছে ফেলুন</h4>
                            </div>
                            <div class="modal-body">
                              আপনি কি নিশ্চিতভাবে এই ছবিটি ডিলেট করতে চান?<br/><br/><br/>
                              <center>
                                <img src="{{ asset('images/slider/'. $slider->image) }}" alt="Album Image" class="img-responsive" style="max-height: 200px; width: auto;">
                                <small class="text-red"><b><i class="fa fa-info-circle"></i> এই ছবিটি মুছে দেওয়া হবে</b></small>
                              </center>
                            </div>
                            <div class="modal-footer">
                              {!! Form::model($slider, ['route' => ['dashboard.deleteslider', $slider->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                                  {!! Form::submit('মুছে ফেলুন', array('class' => 'btn btn-danger')) !!}
                                  <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Delete Photo Modal -->
                      <!-- Delete Photo Modal -->
                  </div>
                  <small>{{ $slider->title }}</small><br/><br/>
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
  {!!Html::script('js/parsley.min.js')!!}
  <script type="text/javascript">
    var _URL = window.URL || window.webkitURL;
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
          var file, img;

          if ((file = this.files[0])) {
            img = new Image();
            img.onload = function() {
              var imagewidth = this.width;
              var imageheight = this.height;
              filesize = parseInt((file.size / 1024));
              if(filesize > 1000) {
                $("#image").val('');
                toastr.warning('ফাইলের আকৃতি '+filesize+' কিলোবাইট. ১ মেগাবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
                setTimeout(function() {
                  $("#img-upload").attr('src', '{{ asset('images/300x100.png') }}');
                }, 1000);
              }
              if(((imagewidth/imageheight) < 2.9375) || ((imagewidth/imageheight) > 3.07142)) {
                $("#image").val('');
                toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:৩ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
                setTimeout(function() {
                  $("#img-upload").attr('src', '{{ asset('images/300x100.png') }}');
                }, 1000);
              }
            };
            img.onerror = function() {
              $("#image").val('');
              toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/300x100.png') }}');
              }, 1000);
            };
            img.src = _URL.createObjectURL(file);
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