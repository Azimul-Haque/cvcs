@extends('layouts.index')
@section('title')
    IIT Alumni | Member Application
@endsection

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/DateTimePicker.css') }}">
@stop

@section('content')
    <section class="wow fadeIn bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-10 col-xs-11 center-col login-box">
                    <h1 style="text-align: center">Registration</h1>
                    <form action="{{ route('index.storeapplication') }}" method="post" enctype='multipart/form-data'>
                        {!! csrf_field() !!}
                        <div class="form-group no-margin-bottom">
                            <label for="name" class="text-uppercase">Name</label>
                            <input type="text" name="name" id="name" required="">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="email" class="text-uppercase">Email</label>
                            <input type="text" name="email" id="email" required="">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="phone" class="text-uppercase">Phone</label>
                            <input type="text" name="phone" id="phone" required="">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="dob" class="text-uppercase">Date of Birth</label>
                            <input type="text" name="dob" id="dob" data-field="date" readonly autocomplete="off"  required="">
                            <div id="dtBox"></div>
                        </div>
                        <div class="form-group">
                            <label class="text-uppercase">Degree</label>
                            <select name="degree" required="">
                                <option value="" selected="" disabled="">Select one</option>
                                <option value="BSSE">BSSE</option>
                                <option value="MIT">MIT</option>
                                <option value="PGDIT">PGDIT</option>
                            </select>
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="batch" class="text-uppercase">Batch</label>
                            <input type="text" name="batch" id="batch"  required="">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="passing_year" class="text-uppercase">Passing Year</label>
                            <select name="passing_year" required="">
                                <option value="" selected="" disabled="">Select one</option>
                                @for($yr = date('Y'); $yr >= 1985; $yr--)
                                <option value="{{ $yr }}">{{ $yr }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="current_job" class="text-uppercase">Current Job</label>
                            <input type="text" name="current_job" id="current_job">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="designation" class="text-uppercase">Job Designation</label>
                            <input type="text" name="designation" id="designation">
                        </div>
                        <div class="form-group">
                            <label for="address" class="text-uppercase">Address</label>
                            <input type="text" id="address" name="address" required="">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="fb" class="text-uppercase">Facebook Url</label>
                            <input type="text" name="fb" id="fb">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="twitter" class="text-uppercase">Twitter Url</label>
                            <input type="text" name="twitter" id="twitter">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="gplus" class="text-uppercase">Google plus Url</label>
                            <input type="text" name="gplus" id="gplus">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="linkedin" class="text-uppercase">Linkedin Url</label>
                            <input type="text" name="linkedin" id="linkedin">
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                              <div class="form-group no-margin-bottom">
                                  <label><strong>Photo (300 X 300 &amp; 200Kb Max):</strong></label>
                                  <input type="file" id="image" name="image" required="">
                              </div>
                          </div>
                          <div class="col-md-4">
                            <img src="{{ asset('images/user.png')}}" id='img-upload' style="height: 120px; width: auto; padding: 5px;" />
                          </div>
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="password" class="text-uppercase">Password</label>
                            <input type="password" name="password" id="password" required="">
                        </div>
                        <div class="form-group no-margin-bottom">
                            <label for="password_confirmation" class="text-uppercase">Retype Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required="">
                        </div>
                        
                        <button class="btn highlight-button-dark btn-bg btn-round margin-five no-margin-right" type="submit">Next</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/DateTimePicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#dtBox").DateTimePicker({
                dateTimeFormat: "dd-MM-yyyy hh:mm:ss"
            }); 
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
              if(filesize > 200) {
                $("#image").val('');
                toastr.warning('File size is: '+filesize+' Kb. try uploading less than 200Kb', 'WARNING').css('width', '400px;');
                  setTimeout(function() {
                    $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
                  }, 1000);
              }
          });

        });
    </script>
@endsection