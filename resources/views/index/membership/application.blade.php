@extends('layouts.index')
@section('title')
    CVCS | Member Application
@endsection

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/DateTimePicker.css') }}">
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content')
    <section class="wow fadeIn bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-sm-10 col-xs-11 center-col login-box xs-margin-top-twelve margin-bottom" id="presubmission_div">
                  <h2 class="agency-title margin-two">
                    আবেদন করার আগে...
                  </h2>
                  <ul>
                    <li><i class="fa fa-check-square-o"></i> আপনার নিজের অত্যাবশ্যক তথ্যগুলো একত্র করুন</li>
                    <li><i class="fa fa-check-square-o"></i> আপনার নিজের এক কপি ৩০০x৩০০ সাইজের রঙিন ছবির সফট/ স্ক্যান কপি প্রস্তুত রাখুন</li>
                    <li><i class="fa fa-check-square-o"></i> দুজন নমিনির ৩০০x৩০০ সাইজের রঙিন ছবির সফট/ স্ক্যান কপি প্রস্তুত রাখুন</li>
                    <li><i class="fa fa-check-square-o"></i> মেম্বারশিপ ফি বাবদ ৫০০০ টাকার ব্যাংক ডিপোজিট রিসিটটির সফট/ স্ক্যান কপি প্রস্তুত রাখুন</li>
                    <li><i class="fa fa-check-square-o"></i> <b>মোবাইল নম্বর</b> ঘরে ১১ ডিজিটের সক্রিয় একটি নম্বর দিন; এ নম্বরেই যাবতীয় তথ্য SMS আকারে পাঠানো হবে</li>
                  </ul>
                  <button class="btn highlight-button-royal-blue btn-bg no-margin-right" id="presubmission_info">ঠিক আছে</button>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-11 center-col login-box xs-margin-top-twelve">
                    <h3 class="text-center">
                      কাস্টমস এন্ড ভ্যাট কো-অপারেটিভ সোসাইটি<br/><br/>
                      <big>সিভিসিএস</big>
                    </h3>
                    <h4 class="text-center">গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের সমবায় মন্ত্রণালয় কর্তৃক অনুমোদিত</h4>
                    <h5 class="text-center">নিবন্ধন নং - ০০০৩১</h5>
                    <h2 class="text-center">মেম্বারশিপ ফরম</h2>
                    <div class="separator-line bg-yellow margin-four"></div>
                    <form action="{{ route('index.storeapplication') }}" method="post" enctype='multipart/form-data' data-parsley-validate="">
                        {!! csrf_field() !!}
                        <h3 class="agency-title margin-two">আবেদনকারীর ব্যক্তিগত তথ্যঃ</h3>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="name_bangla" class="">আবেদনকারীর নাম (বাংলায়) *</label>
                                <input type="text" name="name_bangla" id="name_bangla" required="" data-parsley-required-message="আবেদনকারীর নাম বাংলায় লিখুন" data-parsley-pattern="[^a-zA-Z0-9]+" data-parsley-pattern-message="*বাংলা বর্ণমালা* প্রদান করুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="name" class="">আবেদনকারীর নাম (ইংরেজিতে) *</label>
                                <input type="text" name="name" id="name" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nid" class="">জাতীয় পরিচয়পত্র নম্বর *</label>
                                <input type="text" name="nid" id="nid" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="dob" class="">জন্মতারিখ *</label>
                                <input type="text" name="dob" id="dob" data-field="date"  autocomplete="off"  required="">
                                
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender" class="">লিঙ্গ</label>
                                <select name="gender" id="gender" required="">
                                    <option value="" selected="" disabled="">লিঙ্গ নির্ধারণ করুন</option>
                                    <option value="নারী">নারী</option>
                                    <option value="পুরুষ">পুরুষ</option>
                                    <option value="অন্যান্য">অন্যান্য</option>
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="spouse" class="">স্বামী/স্ত্রীর নাম *</label>
                                <input type="text" name="spouse" id="spouse" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="spouse_profession" class="">স্বামী/স্ত্রীর পেশা *</label>
                                <input type="text" name="spouse_profession" id="spouse_profession" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="father" class="">পিতার নাম *</label>
                                <input type="text" name="father" id="father" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="mother" class="">মাতার নাম *</label>
                                <input type="text" name="mother" id="mother" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="office" class="">আবেদনকারীর দপ্তরের নাম *</label>
                                <input type="text" name="office" id="office" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="profession" class="">আবেদনকারীর পেশা *</label>
                                <input type="text" name="profession" id="profession" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="designation" class="">আবেদনকারীর পদবি *</label>
                                <input type="text" name="designation" id="designation" required="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group ">
                            <label for="present_address" class="">বর্তমান ঠিকানা</label>
                            <input type="text" name="present_address" id="present_address" required="">
                        </div>
                        <div class="form-group ">
                            <label for="permanent_address" class="">স্থায়ী ঠিকানা</label>
                            <input type="text" name="permanent_address" id="permanent_address" required="">
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="office_telephone" class="">অফিসের টেলিফোন *</label>
                                <input type="text" name="office_telephone" id="office_telephone" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="mobile" class="">মোবাইল নম্বর (সক্রিয় নম্বর দিন, এই নম্বরে SMS যাবে) *</label>
                                <input type="text" name="mobile" id="mobile" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="home_telephone" class="">বাসার টেলিফোন *</label>
                                <input type="text" name="home_telephone" id="home_telephone" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="email" class="">ইমেইল এড্রেস *</label>
                                <input type="text" name="email" id="email" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                              <div class="form-group ">
                                  <label><strong>আবেদনকারীর রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০ কিলোবাইট)</strong></label>
                                  <input type="file" id="image" name="image" required="">
                              </div>
                          </div>
                          <div class="col-md-4">
                            <img src="{{ asset('images/user.png')}}" id='img-upload' style="height: 120px; width: auto; padding: 5px;" />
                          </div>
                        </div>

                        <h3 class="agency-title margin-two">নমিনীর বিস্তারিত তথ্যঃ (নমিনি ০১)</h3>
                        
                        <div class="form-group ">
                            <label for="nominee_one_name" class="">নাম (বাংলায়) *</label>
                            <input type="text" name="nominee_one_name" id="nominee_one_name" required="">
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_identity_type" class="">দলিলের ধরণ</label>
                                <select name="nominee_one_identity_type" id="nominee_one_identity_type" required="">
                                    <option value="" selected="" disabled="">দলিলের ধরণ নির্ধারণ করুন</option>
                                    <option value="0">জাতীয় পরিচয়পত্র</option>
                                    <option value="1">জন্ম নিবন্ধন</option>
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nominee_one_identity_text" class="">জাতীয় পরিচয়পত্র/ জন্ম নিবন্ধন নম্বর *</label>
                                <input type="text" name="nominee_one_identity_text" id="nominee_one_identity_text" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nominee_one_relation" class="">সম্পর্ক *</label>
                                <input type="text" name="nominee_one_relation" id="nominee_one_relation" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nominee_one_percentage" class="">শতকরা হার *</label>
                                <input type="text" name="nominee_one_percentage" id="nominee_one_percentage" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                              <div class="form-group ">
                                  <label><strong>নমিনির রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০ কিলোবাইট)</strong></label>
                                  <input type="file" id="nominee_one_image" name="nominee_one_image" required="">
                              </div>
                          </div>
                          <div class="col-md-4">
                            <img src="{{ asset('images/user.png')}}" id='nominee_one_image-upload' style="height: 120px; width: auto; padding: 5px;" />
                          </div>
                        </div>

                        <h3 class="agency-title margin-two">নমিনীর বিস্তারিত তথ্যঃ (নমিনি ০২)</h3>
                        
                        <div class="form-group ">
                            <label for="nominee_two_name" class="">নাম (বাংলায়) *</label>
                            <input type="text" name="nominee_two_name" id="nominee_two_name" required="">
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_two_identity_type" class="">দলিলের ধরণ</label>
                                <select name="nominee_two_identity_type" id="nominee_two_identity_type" required="">
                                    <option value="" selected="" disabled="">দলিলের ধরণ নির্ধারণ করুন</option>
                                    <option value="0">জাতীয় পরিচয়পত্র</option>
                                    <option value="1">জন্ম নিবন্ধন</option>
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nominee_two_identity_text" class="">জাতীয় পরিচয়পত্র/ জন্ম নিবন্ধন নম্বর *</label>
                                <input type="text" name="nominee_two_identity_text" id="nominee_two_identity_text" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nominee_two_relation" class="">সম্পর্ক *</label>
                                <input type="text" name="nominee_two_relation" id="nominee_two_relation" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nominee_two_percentage" class="">শতকরা হার *</label>
                                <input type="text" name="nominee_two_percentage" id="nominee_two_percentage" required="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                              <div class="form-group ">
                                  <label><strong>নমিনির রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০ কিলোবাইট)</strong></label>
                                  <input type="file" id="nominee_two_image" name="nominee_two_image" required="">
                              </div>
                          </div>
                          <div class="col-md-4">
                            <img src="{{ asset('images/user.png')}}" id='nominee_two_image-upload' style="height: 120px; width: auto; padding: 5px;" />
                          </div>
                        </div>

                        <h3 class="agency-title margin-two">অনলাইন একাউন্ট সংক্রান্ত</h3>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="password" class="">একাউন্টের পাসওয়ার্ড</label>
                                <input type="password" name="password" id="password" required="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="password_confirmation" class="">পাসওয়ার্ডটি আবার দিন</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required="">
                            </div>
                          </div>
                        </div>
                        
                        <button class="btn highlight-button-royal-blue btn-bg margin-five no-margin-right" type="submit">আবেদন জমা দিন</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <div id="dtBox"></div>
@endsection

@section('js')
  {!!Html::script('js/parsley.min.js')!!}
  {{-- <script type="text/javascript" src="{{ asset('js/jquery-3.1.0.min.js') }}"></script> --}}
  <script type="text/javascript" src="{{ asset('js/DateTimePicker.min.js') }}"></script>
  <script type="text/javascript">
      $(document).ready(function() {
          $("#dtBox").DateTimePicker({
              mode:"date",
              dateFormat: "dd-MM-yyyy",
              titleContentDate: 'জন্মতারিখ নির্ধারণ করুন'
          });
          $("#presubmission_info").click(function() {
              $("#presubmission_div").hide(2000);
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
            if(filesize > 250) {
              $("#image").val('');
              toastr.warning('File size is: '+filesize+' Kb. try uploading less than 250Kb', 'WARNING').css('width', '400px;');
                setTimeout(function() {
                  $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
                }, 1000);
            }
        });
        function readURLNominee1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#nominee_one_image-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#nominee_one_image").change(function(){
            readURLNominee1(this);
            var filesize = parseInt((this.files[0].size)/1024);
            if(filesize > 250) {
              $("#nominee_one_image").val('');
              toastr.warning('File size is: '+filesize+' Kb. try uploading less than 250Kb', 'WARNING').css('width', '400px;');
                setTimeout(function() {
                  $("#nominee_one_image-upload").attr('src', '{{ asset('images/user.png') }}');
                }, 1000);
            }
        });
        function readURLNominee2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#nominee_two_image-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#nominee_two_image").change(function(){
            readURLNominee2(this);
            var filesize = parseInt((this.files[0].size)/1024);
            if(filesize > 250) {
              $("#nominee_two_image").val('');
              toastr.warning('File size is: '+filesize+' Kb. try uploading less than 250Kb', 'WARNING').css('width', '400px;');
                setTimeout(function() {
                  $("#nominee_two_image-upload").attr('src', '{{ asset('images/user.png') }}');
                }, 1000);
            }
        });

      });
  </script>
@endsection