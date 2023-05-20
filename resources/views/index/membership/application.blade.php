@extends('layouts.index')
@section('title')
    CVCS | Member Application
@endsection

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/DateTimePicker.css') }}">
  {!!Html::style('css/parsley.css')!!}
  <style type="text/css">
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
  </style>
@stop

@section('content')
  <form action="{{ route('index.storeapplication') }}" id="application_form" method="post" enctype='multipart/form-data' data-parsley-validate="">
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
                    <li><i class="fa fa-check-square-o"></i> মেম্বারশিপ ফি বাবদ ২০০০ টাকার ব্যাংক ডিপোজিট রিসিটটির সফট/ স্ক্যান কপি প্রস্তুত রাখুন</li>
                    <li><i class="fa fa-check-square-o"></i> <b>মোবাইল নম্বর</b> ঘরে ১১ ডিজিটের সক্রিয় একটি নম্বর দিন; এ নম্বরেই যাবতীয় তথ্য SMS আকারে পাঠানো হবে</li>
                    <li><i class="fa fa-check-square-o"></i> নমিনি একজন হলে শতকরা হার ঘরের মান 100 রাখুন</li>
                    <li><i class="fa fa-check-square-o"></i> নমিনি দুইজন হলে দুই নমিনির শতকরা হারের যোগফল যেন 100 হয় সেদিকে খেয়াল রাখুন</li>
                  </ul>
                  <button type="button" class="btn highlight-button-royal-blue btn-bg no-margin-right" id="presubmission_info">ঠিক আছে</button>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-11 center-col login-box xs-margin-top-twelve">
                    <h3 class="text-center">
                      কাস্টমস এন্ড ভ্যাট কো অপারেটিভ সোসাইটি (সিভিসিএস) লিমিটেড<br/><br/>
                      <big>সিভিসিএস</big>
                    </h3>
                    <h4 class="text-center">গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের সমবায় মন্ত্রণালয় কর্তৃক অনুমোদিত</h4>
                    <h5 class="text-center">নিবন্ধন নং - ০০০৩১</h5>
                    <h2 class="text-center">মেম্বারশিপ ফরম</h2>
                    <div class="separator-line bg-yellow margin-four"></div>
                   
                        {!! csrf_field() !!}
                        <h3 class="agency-title margin-two">আবেদনকারীর ব্যক্তিগত তথ্যঃ</h3>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="name_bangla" class="">আবেদনকারীর নাম (বাংলায়) *</label>
                                <input type="text" name="name_bangla" id="name_bangla" class="text_bangla" required="" data-parsley-required-message="আবেদনকারীর নাম বাংলায় লিখুন" data-parsley-pattern="[^a-zA-Z0-9]+" data-parsley-pattern-message="*বাংলা বর্ণমালা* প্রদান করুন" placeholder="বাংলা বর্ণমালায় নাম লিখুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="name" class="">আবেদনকারীর নাম (ইংরেজিতে) *</label>
                                <input type="text" name="name" id="name" required="" placeholder="ইংরেজি বর্ণমালায় নাম লিখুন">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nid" class="">জাতীয় পরিচয়পত্র নম্বর *</label>
                                <input type="number" onKeyPress="if(this.value.length==17) return false;" name="nid" id="nid" required="" placeholder="ইংরেজি অংকে পরিচয়পত্র নম্বরটি লিখুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="dob" class="">জন্মতারিখ *</label>
                                <input type="text" name="dob" id="dob" data-field="date" autocomplete="off" required="" placeholder="জন্মতারিখ নির্ধারণ করুন">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender" class="">লিঙ্গ</label>
                                <select name="gender" id="gender" class="form-control" required="">
                                    <option value="" selected="" disabled="">লিঙ্গ নির্ধারণ করুন</option>
                                    <option value="নারী">নারী</option>
                                    <option value="পুরুষ">পুরুষ</option>
                                    <option value="অন্যান্য">অন্যান্য</option>
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="spouse" class="">স্বামী/স্ত্রীর নাম</label>
                                <input type="text" name="spouse" id="spouse" class="text_bangla" placeholder="স্বামী/স্ত্রীর নাম বাংলায় লিখুন">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="spouse_profession" class="">স্বামী/স্ত্রীর পেশা</label>
                                <input type="text" name="spouse_profession" id="spouse_profession" class="text_bangla" placeholder="স্বামী/স্ত্রীর পেশা বাংলায় লিখুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="father" class="">পিতার নাম *</label>
                                <input type="text" name="father" id="father" required="" class="text_bangla" placeholder="পিতার নাম বাংলায় লিখুন">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="mother" class="">মাতার নাম *</label>
                                <input type="text" name="mother" id="mother" required="" class="text_bangla" placeholder="মাতার নাম বাংলায় লিখুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="branch_id" class="">আবেদনকারীর দপ্তরের নাম *</label>
                                <select name="branch_id" id="branch_id" class="form-control" required="">
                                    <option value="" selected="" disabled="">দপ্তরের নাম নির্ধারণ করুন</option>
                                    @foreach($branches as $branch)
                                      <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="profession" class="">আবেদনকারীর পেশা *</label>
                                <input type="text" name="profession" id="profession" required="" class="text_bangla" placeholder="পেশা বাংলায় লিখুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="position_id" class="">আবেদনকারীর পদবি *</label>
                                <select name="position_id" id="position_id" class="form-control" required="">
                                    <option value="" selected="" disabled="">পদবি নির্ধারণ করুন</option>
                                    <option value="34">সদস্য</option>
                                    @foreach($positions as $position)
                                      <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group ">
                            <label for="joining_date" class="">চাকুরীতে যোগদানের তারিখ <b>(তথ্য না থাকলে ফাঁকা রাখুন)</b></label>
                            <input type="text" name="joining_date" id="joining_date" data-field="date" autocomplete="off" placeholder="চাকুরীতে যোগদানের তারিখ">
                        </div>
                        <div class="form-group ">
                            <label for="present_address" class="">বর্তমান ঠিকানা</label>
                            <input type="text" name="present_address" id="present_address" required="" class="text_bangla" placeholder="বাংলায় লিখুন">
                        </div>
                        <div class="form-group ">
                            <label for="permanent_address" class="">স্থায়ী ঠিকানা</label>
                            <input type="text" name="permanent_address" id="permanent_address" class="text_bangla" required="" placeholder="বাংলায় লিখুন">
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="office_telephone" class="">অফিসের টেলিফোন (ঐচ্ছিক)</label>
                                <input type="number" name="office_telephone" id="office_telephone" placeholder="অফিসের টেলিফোন নম্বর ইংরেজি লিখুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="mobile" class="">মোবাইল নম্বর (সক্রিয় নম্বর দিন, এই নম্বরে SMS যাবে) *</label>
                                <input type="number" onKeyPress="if(this.value.length==11) return false;" name="mobile" id="mobile" required="" placeholder="ইংরেজি অংকে লিখুন (১১ ডিজিট)">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="home_telephone" class="">বাসার টেলিফোন (ঐচ্ছিক)</label>
                                <input type="number" name="home_telephone" id="home_telephone" placeholder="বাসার টেলিফোন নম্বর ইংরেজিতে লিখুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="email" class="">ইমেইল এড্রেস <small>(ইমেইল না থাকলে ফাঁকা রাখুন)</small></label>
                                <input type="email" name="email" id="email" autocomplete="off" placeholder="একটি ভ্যালিড ইমেইল এড্রেস লিখুন">
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

                        <h3 class="agency-title margin-two">নমিনীর বিস্তারিত তথ্যঃ (নমিনি ০১) <small>(নমিনির তথ্য নমিনি ০১ এর ক্ষেত্রে বাধ্যতামূলক)</small></h3>
                        
                        <div class="form-group ">
                            <label for="nominee_one_name" class="">নাম (বাংলায়) *</label>
                            <input type="text" name="nominee_one_name" id="nominee_one_name" required="" class="text_bangla" placeholder="বাংলা বর্ণমালায় লিখুন">
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_identity_type" class="">দলিলের ধরণ</label>
                                <select name="nominee_one_identity_type" id="nominee_one_identity_type" class="form-control" required="">
                                    <option value="" selected="" disabled="">দলিলের ধরণ নির্ধারণ করুন</option>
                                    <option value="0">জাতীয় পরিচয়পত্র</option>
                                    <option value="1">জন্ম নিবন্ধন</option>
                                </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_identity_text" class="">জাতীয় পরিচয়পত্র/ জন্ম নিবন্ধন নম্বর *</label>
                                <input type="number" onKeyPress="if(this.value.length==17) return false;" name="nominee_one_identity_text" id="nominee_one_identity_text" required="" placeholder="ইংরেজি অংকে লিখুন">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_relation" class="">সম্পর্ক *</label>
                                <input type="text" name="nominee_one_relation" id="nominee_one_relation" class="text_bangla" required="" placeholder="সম্পর্ক লিখুন">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_percentage" class="">শতকরা হার (%) *</label>
                                <input type="number" min="1" max="100" minlength="1" maxlength="3" name="nominee_one_percentage" id="nominee_one_percentage" required="" placeholder="ইংরেজি অংকে লিখুন">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                              <div class="form-group">
                                  <label><strong>নমিনির রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০ কিলোবাইট) *</strong></label>
                                  <input type="file" id="nominee_one_image" name="nominee_one_image" required="">
                              </div>
                          </div>
                          <div class="col-md-4">
                            <img src="{{ asset('images/user.png')}}" id='nominee_one_image-upload' style="height: 120px; width: auto; padding: 5px;" />
                          </div>
                        </div>

                        <br/><br/>
                        <div class="panel-group toggles-style1 no-border">
                            <div class="panel panel-default" id="collapse-nominee2">
                              <div role="tablist" id="headingnominee2" class="panel-heading">
                                  <a data-toggle="collapse" data-parent="#collapse-nominee2" href="#collapse-nominee2-link1">
                                      <h4 class="panel-title">আরও একজন নমিনি যোগ করতে, এখানে ক্লিক করুন 
                                          <span class="pull-right">
                                              <i class="fa fa-plus"></i>
                                          </span>
                                      </h4>
                                  </a>
                              </div>
                              <div id="collapse-nominee2-link1" class="panel-collapse collapse">
                                  <div class="panel-body">
                                    <h3 class="agency-title margin-two">নমিনীর বিস্তারিত তথ্যঃ (নমিনি ০২) <small>(নমিনির তথ্য নমিনি ০২ এর ক্ষেত্রে ঐচ্ছিক)</small></h3>
                                                            
                                    <div class="form-group">
                                        <label for="nominee_two_name" class="">নাম (বাংলায়)</label>
                                        <input type="text" name="nominee_two_name" id="nominee_two_name" class="text_bangla" placeholder="বাংলা বর্ণমালায় লিখুন">
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nominee_two_identity_type" class="">দলিলের ধরণ</label>
                                            <select name="nominee_two_identity_type" class="form-control" id="nominee_two_identity_type">
                                                <option value="" selected="" disabled="">দলিলের ধরণ নির্ধারণ করুন</option>
                                                <option value="0">জাতীয় পরিচয়পত্র</option>
                                                <option value="1">জন্ম নিবন্ধন</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nominee_two_identity_text" class="">জাতীয় পরিচয়পত্র/ জন্ম নিবন্ধন নম্বর</label>
                                            <input type="number" onKeyPress="if(this.value.length==17) return false;" name="nominee_two_identity_text" id="nominee_two_identity_text" placeholder="ইংরেজি অংকে লিখুন">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nominee_two_relation" class="">সম্পর্ক</label>
                                            <input type="text" name="nominee_two_relation" id="nominee_two_relation" class="text_bangla" placeholder="সম্পর্ক লিখুন">
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nominee_two_percentage" class="">শতকরা হার (%)</label>
                                            <input type="number" min="1" max="100" minlength="1" maxlength="3" name="nominee_two_percentage" id="nominee_two_percentage" placeholder="ইংরেজি অংকে লিখুন">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-8">
                                          <div class="form-group">
                                              <label><strong>নমিনির রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০ কিলোবাইট)</strong></label>
                                              <input type="file" id="nominee_two_image" name="nominee_two_image">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                        <img src="{{ asset('images/user.png')}}" id='nominee_two_image-upload' style="height: 120px; width: auto; padding: 5px;" />
                                      </div>
                                    </div> 
                                  </div>
                              </div>
                          </div>
                        </div><br/>

                        

                        <h3 class="agency-title margin-two">পরিশোধ সংক্রান্ত</h3>

                        <div class="panel-group toggles-style1 no-border">
                            <div class="panel panel-default" id="collapse-paymanual">
                              <div role="tablist" id="headingnominee2" class="panel-heading">
                                  <a data-toggle="" data-parent="#collapse-paymanual" href="#!">
                                      <h4 class="panel-title">ম্যানুয়ালি পরিশোধ করুন
                                          <span class="pull-right">
                                              <i class="fa fa-plus"></i>
                                          </span>
                                      </h4>
                                  </a>
                              </div>
                              <div id="collapse-paymanual-link1" class="panel-collapse collapse">
                                  <div class="panel-body">
                                    <h3 class="agency-title margin-two">ম্যানুয়াল পরিশোধ ফর্ম</h3>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          {!! Form::label('amountoffline', 'পরিমাণ * (ইংরেজিতে শুধু সংখ্যায় লিখুন)') !!}
                                          {!! Form::text('amountoffline', null, array('class' => '', 'id' => 'amountoffline', 'placeholder' => 'পরিমাণ লিখুন (২০০০/- এর বেশি) [ইংরেজিতে লিখুন]')) !!}
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          {!! Form::label('application_payment_pay_slip', 'পে-স্লিপ নম্বর *') !!}
                                          {!! Form::text('application_payment_pay_slip', null, array('class' => '', 'id' => 'application_payment_pay_slip', 'placeholder' => 'পে-স্লিপ নম্বর লিখুন')) !!}
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          {!! Form::label('application_payment_bank', 'ব্যাংকের নাম *') !!}
                                          {!! Form::text('application_payment_bank', 'ডাচ বাংলা ব্যাংক', array('class' => 'text_bangla', 'id' => 'application_payment_bank', 'placeholder' => 'ব্যাংকের নাম লিখুন', 'data-parsley-required-message' => 'ব্যাংকের নামটি বাংলায় লিখুন')) !!}
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          {!! Form::label('application_payment_branch', 'ব্রাঞ্চের নাম *') !!}
                                          {!! Form::text('application_payment_branch', null, array('class' => 'text_bangla', 'id' => 'application_payment_branch', 'placeholder' => 'ব্রাঞ্চের নাম বাংলায় লিখুন')) !!}
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-8">
                                          <div class="form-group ">
                                              <label><strong>টাকা পরিশোধের রিসিট (সর্বোচ্চ ২ মেগাবাইট) *</strong></label>
                                              <input type="file" id="application_payment_receipt" name="application_payment_receipt">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                        <img src="{{ asset('images/800x500.png')}}" id='application_payment_receipt-upload' style="width: 250px; height: auto; padding: 5px;" />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div><br/>

                        <div class="panel-group toggles-style1 no-border">
                            <div class="panel panel-default" id="collapse-payonline">
                              <div role="tablist" id="headingnominee2" class="panel-heading">
                                  <a data-toggle="" data-parent="#collapse-payonline" href="#!">
                                      <h4 class="panel-title">অনলাইনে পরিশোধ করুন
                                          <span class="pull-right">
                                              <i class="fa fa-plus"></i>
                                          </span>
                                      </h4>
                                  </a>
                              </div>
                              <div id="collapse-payonline-link1" class="panel-collapse collapse">
                                  <div class="panel-body">
                                    <h3 class="agency-title margin-two">অনলাইন পরিশোধ ফর্ম</h3>
                                    <div class="form-group">
                                      {!! Form::label('amountonline', 'পরিমাণ [ইংরেজি সংখ্যা লিখুন] * ') !!}
                                      {!! Form::number('amountonline', null, array('class' => '', 'id' => 'amountonline', 'placeholder' => 'পরিমাণ লিখুন (২০০০/- এর বেশি, ইংরেজি সংখ্যা লিখুন)')) !!}
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div><br/>

                        

                        {{-- <h3 class="agency-title margin-two">অনলাইন একাউন্ট সংক্রান্ত</h3>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="password" class="">একাউন্টের পাসওয়ার্ড</label>
                                <input type="password" name="password" id="password" autocomplete="off" required="" placeholder="একাউন্টের পাসওয়ার্ড দিন (কমপক্ষে ৮ দৈর্ঘ্যের)">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group ">
                                <label for="password_confirmation" class="" id="password_confirmation_error">পাসওয়ার্ডটি আবার দিন</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="off" required="" placeholder="পাসওয়ার্ডটি আবার দিন">
                            </div>
                          </div>
                        </div> --}}

                        <input type="hidden" name="payment_method" id="payment_method">

                        <button type="button" class="btn highlight-button-royal-blue btn-bg margin-five no-margin-right" data-toggle="modal" data-target="#submitApplicationModal" data-backdrop="static">আবেদন জমা দিন</button>
                </div>

            </div>
        </div>
    </section>

    <div id="dtBox"></div>
    <!-- Before Submit Modal -->
    <!-- Before Submit Modal -->
    <div class="modal fade" id="submitApplicationModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">সদস্যপদ আবেদন দাখিল</h4>
          </div>
          <div class="modal-body">
            <big>আপনি কি নিশ্চিতভাবে আবেদনটি দাখিল করতে চান?</big><br/><br/>
            <span><b>দাখিল করার পূর্বে...</b></span><br/>
            <ul>
              <li><i class="fa fa-check-square-o"></i> প্রতিটি বাধ্যতামূলক (* দেওয়া) ঘর পূরন করেছেন কি না যাচাই করুন</li>
              <li><i class="fa fa-check-square-o"></i> ছবি ও অন্যান্য ফাইলগুলো ঠিকমতো দিয়েছেন কি না লক্ষ্য করুন</li>
              <li><i class="fa fa-check-square-o"></i> নম্বর সংক্রান্ত তথ্যগুলো (যেমনঃ মোবাইল নম্বর, পরিচয়পত্র নম্বর, শতকরা হার ইত্যাদি <b>ইংরেজি অংকে (0,1,3,4...)</b> দিয়েছেন কি না যাচাই করুন)</li>
              <li><i class="fa fa-check-square-o"></i> নমিনি একজন হলে শতকরা হার ঘরের মান 100 রাখুন</li>
              <li><i class="fa fa-check-square-o"></i> নমিনি দুইজন হলে দুই নমিনির শতকরা হারের যোগফল যেন 100 হয় সেদিকে খেয়াল রাখুন</li>
            </ul>
          </div>
          <div class="modal-footer">
                <button type="submit" class="btn highlight-button-royal-blue btn-bg margin-five no-margin-right" type="submit" id="submit_btn">আবেদন জমা দিন</button>
                <button type="button" class="btn highlight-button btn-bg margin-five no-margin-right" data-dismiss="modal">ফিরে যান</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Before Submit Modal -->
    <!-- Before Submit Modal -->


  </form>
@endsection

@section('js')
  {!!Html::script('js/parsley.min.js')!!}
  {{-- <script type="text/javascript" src="{{ asset('js/jquery-3.1.0.min.js') }}"></script> --}}
  <script type="text/javascript" src="{{ asset('js/DateTimePicker.min.js') }}"></script>
  <script type="text/javascript">
    function setDefaultVal(value){
      if(value.length == 0) {
        return 0;
      } else {
        return value;
      }
    }
    $('#name').keyup(function(){
        this.value = this.value.toUpperCase();
    });
    $(document).ready(function() {
        $("#dtBox").DateTimePicker({
            mode:"date",
            dateFormat: "dd-MM-yyyy",
            titleContentDate: 'তারিখ নির্ধারণ করুন'
        });
        $("#presubmission_info").click(function() {
            $("#presubmission_div").hide(2000);
        });

        
        $('#nominee_one_percentage').blur(function() {
          var percentagesum1 = parseInt(setDefaultVal($('#nominee_one_percentage').val())) + parseInt(setDefaultVal($('#nominee_two_percentage').val()));
          if(percentagesum1 != 100) {
            toastr.warning('দুইজন নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
          } else {
            toastr.success('দুইজন নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
          }
        })

        $('#nominee_two_percentage').blur(function() {
          var percentagesum2 =  parseInt(setDefaultVal($('#nominee_one_percentage').val())) + parseInt(setDefaultVal($('#nominee_two_percentage').val()));
          if(percentagesum2 != 100) {
            toastr.warning('দুইজন নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
          } else {
            toastr.success('দুইজন নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
          }
        })

        // $('#password_confirmation').keyup(function() {
        //   if($('#password_confirmation').val() != $('#password').val()) {
        //     $('#password_confirmation_error').html('পাসওয়ার্ডটি আবার দিন <span style="color: #DC143C;"><b>✕ মিলছে না</b></span>');
        //   } else {
        //     $('#password_confirmation_error').html('পাসওয়ার্ডটি আবার দিন <span style="color: #008000;"><b>✓ মিলেছে</b></span>');
        //   }
        // })
    });

    // disabling the number scrolling...
    $(function(){
      $(':input[type=number]').on('mousewheel',function(e){ $(this).blur(); });
    });

    // if empty on blur
    $(":input[required]").blur(function(){
      $(this).toggleClass('input_empty', this.value.length === 0);
    });
    // if not empty
    // $(":input[required]").keyup(function(){
    //   var regexp = /^[A-Za-z0-9 _.-]+$/;
    //   if($(this).val().match(regexp)){
    //     $(this).toggleClass('input_empty', this.value.length === 0);
    //   }
    // });
    // character validation
    $(".text_bangla").blur(function(){
      var regexp = /[অআইঈউঊঋএঐওঔকখগঘঙচছজঝঞটঠডঢণতথদধনপফবভমযরলশষসহড়ঢ়য়ৎংঃঁ১২৩৪৫৬৭৮৯০][^ABC]\D\W/g;
      if(!$(this).val().match(regexp)){
        $(this).addClass('input_empty');
      }
    });
    $("#name").blur(function(){
      var regexp = /^[A-Za-z0-9 _.-]+$/;
      if(!$(this).val().match(regexp)){
        $(this).addClass('input_empty');
      }
    });
    $("#dob").blur(function(){
      var regexp = /^[A-Za-z0-9 _.-]+$/;
      if(!$(this).val().match(regexp)){
        $(this).addClass('input_empty');
      }
    });
    $(":input[type=number]").blur(function(){
      var regexp = /^-?\d*$/;
      if(!$(this).val().match(regexp)){
        $(this).addClass('input_empty');
      }
    });

    // on submisiion check percentage total
    $("#application_form").submit(function(event) {
      var $form = $(this);

      if ($form.find('input[required]').filter(function(){ return this.value === '' }).length > 0) {
        toastr.warning('* চিহ্নিত ঘরগুলো পূরন করুন').css('width', '400px;');
        event.preventDefault();
        $('#submitApplicationModal').modal('hide');
        $('html,body').animate({ scrollTop: $("#application_form").offset().top}, 'slow');
      }

      var percentagesum = parseInt(setDefaultVal($('#nominee_one_percentage').val())) + parseInt(setDefaultVal($('#nominee_two_percentage').val()));
      if(percentagesum != 100) {
        toastr.warning('নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
        event.preventDefault();
        $('#submitApplicationModal').modal('hide');
        $('html, body').animate({
            scrollTop: $('#name').offset().top - 170
        }, 500);
      }

      if($('#amountoffline').val() < 5 && $('#amountonline').val() < 5) {
        toastr.warning('পরিমাণ কমপক্ষে ২০০০ হতে হবে', 'WARNING').css('width', '400px');
        event.preventDefault();
        $('#submitApplicationModal').modal('hide');
        $('html, body').animate({
            scrollTop: $('#name').offset().top - 170
        }, 500);
      }

      if($('#amountoffline').val() == null && $('#amountonline').val() == null) {
        toastr.warning('পরিমাণ কমপক্ষে ২০০০ হতে হবে', 'WARNING').css('width', '400px');
        event.preventDefault();
        $('#submitApplicationModal').modal('hide');
        $('html, body').animate({
            scrollTop: $('#name').offset().top - 170
        }, 500);
      }

      deferred.success(function () {
          $("#submit_btn").prop("disabled",true);
      });
    })
      
  </script>
  <script type="text/javascript">
    $(document).ready( function() {
      $('#amountoffline').blur(function() {
        var value = $('#amountoffline').val();

        if(value < 5) {
          toastr.warning('পরিমাণ কমপক্ষে ২০০০ হতে হবে', 'WARNING').css('width', '400px');
        }
      });

      $('#amountonline').blur(function() {
        var value = $('#amountonline').val();

        if(value < 5) {
          toastr.warning('পরিমাণ কমপক্ষে ২০০০ হতে হবে', 'WARNING').css('width', '400px');
        }
      });
    });
  </script>
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
            if(filesize > 250) {
              $("#image").val('');
              toastr.warning('ফাইলের আকৃতি '+filesize+' কিলোবাইট. ২৫০ কিলোবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
            console.log(imagewidth/imageheight);
            if(((imagewidth/imageheight) < 0.9375) || ((imagewidth/imageheight) > 1.07142)) {
              $("#image").val('');
              toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:১ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
          };
          img.onerror = function() {
            $("#image").val('');
            toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
            setTimeout(function() {
              $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
            }, 1000);
          };
          img.src = _URL.createObjectURL(file);
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
        var file, img;

        if ((file = this.files[0])) {
          img = new Image();
          img.onload = function() {
            var nominee_one_image_width = this.width;
            var nominee_one_image_height = this.height;
            filesize = parseInt((file.size / 1024));
            if(filesize > 250) {
              $("#nominee_one_image").val('');
              toastr.warning('ফাইলের আকৃতি '+filesize+' কিলোবাইট. ২৫০ কিলোবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#nominee_one_image-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
            console.log(nominee_one_image_width/nominee_one_image_height);
            if(((nominee_one_image_width/nominee_one_image_height) < 0.9375) || ((nominee_one_image_width/nominee_one_image_height) > 1.07142)) {
              $("#nominee_one_image").val('');
              toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:১ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#nominee_one_image-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
          };
          img.onerror = function() {
            $("#nominee_one_image").val('');
            toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
            setTimeout(function() {
              $("#nominee_one_image-upload").attr('src', '{{ asset('images/user.png') }}');
            }, 1000);
          };
          img.src = _URL.createObjectURL(file);
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
        var file, img;

        if ((file = this.files[0])) {
          img = new Image();
          img.onload = function() {
            var nominee_two_image_width = this.width;
            var nominee_two_image_height = this.height;
            filesize = parseInt((file.size / 1024));
            if(filesize > 250) {
              $("#nominee_two_image").val('');
              toastr.warning('ফাইলের আকৃতি '+filesize+' কিলোবাইট. ২৫০ কিলোবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#nominee_two_image-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
            console.log(nominee_two_image_width/nominee_two_image_height);
            if(((nominee_two_image_width/nominee_two_image_height) < 0.9375) || ((nominee_two_image_width/nominee_two_image_height) > 1.07142)) {
              $("#nominee_two_image").val('');
              toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:১ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#nominee_two_image-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
            }
          };
          img.onerror = function() {
            $("#nominee_two_image").val('');
            toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
            setTimeout(function() {
              $("#nominee_two_image-upload").attr('src', '{{ asset('images/user.png') }}');
            }, 1000);
          };
          img.src = _URL.createObjectURL(file);
        }
      });


      function readURLApplicationPaymentReceipt(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#application_payment_receipt-upload').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#application_payment_receipt").change(function(){
          readURLApplicationPaymentReceipt(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 2048) {
            $("#application_payment_receipt").val('');
            toastr.warning('ফাইলের আকৃতি '+filesize+' কিলোবাইট. ২ মেগাবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#application_payment_receipt-upload").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });

    });

    $('#collapse-paymanual-link1').hide();
    $('#collapse-payonline-link1').hide();

    $('#collapse-paymanual').click(function() {
      $('#collapse-payonline-link1').hide();
      $('#collapse-paymanual-link1').show();

      $('#amountoffline').attr('required', 'true');
      $('#application_payment_bank').attr('required', 'true');
      $('#application_payment_branch').attr('required', 'true');
      $('#application_payment_pay_slip').attr('required', 'true');
      $('#application_payment_receipt').attr('required', 'true');

      $('#amountonline').removeAttr('required');

      $('#payment_method').val('offline');
    });


    $('#collapse-payonline').click(function() {
      $('#collapse-paymanual-link1').hide();
      $('#collapse-payonline-link1').show();

      $('#amountonline').attr('required', 'true');
      $('#application_payment_bank').removeAttr('required');
      $('#application_payment_branch').removeAttr('required');
      $('#application_payment_pay_slip').removeAttr('required');
      $('#application_payment_receipt').removeAttr('required');

      $('#amountoffline').removeAttr('required');

      $('#payment_method').val('online');
    });


  </script>
@endsection