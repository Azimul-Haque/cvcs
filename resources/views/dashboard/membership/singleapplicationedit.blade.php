@extends('adminlte::page')

@section('title', 'CVCS | তথ্য হালনাগাদ')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/DateTimePicker.css') }}">
    {!!Html::style('css/parsley.css')!!}
    <style type="text/css">
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-bdata-parsleyutton {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@stop

@section('content_header')
    <h1>
        <b>{{ $application->name_bangla }}</b>-এর @if($application->activation_status == 0) আবেদন @else তথ্য @endif
        সম্পাদনা
    </h1>
@stop

@section('content')
    {!! Form::model($application, ['route' => ['dashboard.singleapplicationupdate', $application->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '', 'id' => 'application_form']) !!}
    <div class="row">
        <div class="col-md-10 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="agency-title margin-two">@if($application->activation_status == 0) আবেদনকারীর @else
                            সদস্যের @endif ব্যক্তিগত তথ্যঃ</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="name_bangla" class="">@if($application->activation_status == 0)
                                        আবেদনকারীর @else সদস্যের @endif নাম (বাংলায়) *</label>
                                <input value="{{ $application->name_bangla }}" type="text" name="name_bangla"
                                       id="name_bangla" class="text_bangla form-control" required=""
                                       data-parsley-required-message="@if($application->activation_status == 0) আবেদনকারীর @else সদস্যের @endif নাম বাংলায় লিখুন"
                                       data-parsley-pattern="[^a-zA-Z0-9]+"
                                       data-parsley-pattern-message="*বাংলা বর্ণমালা* প্রদান করুন"
                                       placeholder="বাংলা বর্ণমালায় নাম লিখুন">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="name" class="">@if($application->activation_status == 0) আবেদনকারীর @else
                                        সদস্যের @endif নাম (ইংরেজিতে) *</label>
                                <input value="{{ $application->name }}" class="form-control" type="text" name="name"
                                       id="name" required="" placeholder="ইংরেজি বর্ণমালায় নাম লিখুন">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="nid" class="">জাতীয় পরিচয়পত্র নম্বর *</label>
                                <input value="{{ $application->nid }}" class="form-control" type="number"
                                       {{-- pattern="/^-?\d+\.?\d*$/" --}} onKeyPress="if(this.value.length==17) return false;"
                                       name="nid" id="nid" required=""
                                       placeholder="ইংরেজি অংকে পরিচয়পত্র নম্বরটি লিখুন">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="dob" class="">জন্মতারিখ *</label>
                                <input value="{{ date('d-m-Y', strtotime($application->dob)) }}" class="form-control"
                                       type="text" name="dob" id="dob" data-field="date" autocomplete="off" required=""
                                       placeholder="জন্মতারিখ নির্ধারণ করুন">

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="blood_group" class="">রক্তের গ্রুপ</label>
                                <select name="blood_group" id="blood_group" class="form-control">
                                    <option value="" selected="" disabled="">রক্তের গ্রুপ নির্ধারণ করুন</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $blood_group)
                                        <option value="{{ $blood_group }}"
                                                @if($application->$blood_group == $blood_group) selected="" @endif>{{ $blood_group }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="district_id" class="">জেলার নাম</label>
                                <select name="upazilla_id" id="upazilla_id" class="form-control">
                                    <option value="" selected="" disabled="">জেলার নাম নির্ধারণ করুন</option>
                                    @foreach($upazillas as $upazilla)
                                        <option value="{{ $upazilla->id }}"
                                                @if($application->upazilla_id == $upazilla->id) selected="" @endif>{{ $upazilla->district_bangla }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender" class="">লিঙ্গ</label>
                                <select name="gender" id="gender" class="text_bangla form-control" required="">
                                    <option value="" selected="" disabled="">লিঙ্গ নির্ধারণ করুন</option>
                                    <option value="নারী" @if($application->gender == 'নারী') selected="" @endif>নারী
                                    </option>
                                    <option value="পুরুষ" @if($application->gender == 'পুরুষ') selected="" @endif>
                                        পুরুষ
                                    </option>
                                    <option value="অন্যান্য" @if($application->gender == 'অন্যান্য') selected="" @endif>
                                        অন্যান্য
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="spouse" class="">স্বামী/স্ত্রীর নাম</label>
                                <input value="{{ $application->spouse }}" type="text" name="spouse" id="spouse"
                                       class="text_bangla form-control" placeholder="স্বামী/স্ত্রীর নাম বাংলায় লিখুন">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="spouse_profession" class="">স্বামী/স্ত্রীর পেশা</label>
                                <input value="{{ $application->spouse_profession }}" type="text"
                                       name="spouse_profession" id="spouse_profession" class="text_bangla form-control"
                                       placeholder="স্বামী/স্ত্রীর পেশা বাংলায় লিখুন">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="father" class="">পিতার নাম *</label>
                                <input value="{{ $application->father }}" type="text" name="father" id="father"
                                       required="" class="text_bangla form-control"
                                       placeholder="পিতার নাম বাংলায় লিখুন">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="mother" class="">মাতার নাম *</label>
                                <input value="{{ $application->mother }}" type="text" name="mother" id="mother"
                                       required="" class="text_bangla form-control"
                                       placeholder="মাতার নাম বাংলায় লিখুন">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="profession" class="">@if($application->activation_status == 0)
                                        আবেদনকারীর @else সদস্যের @endif পেশা *</label>
                                <input value="{{ $application->profession }}" type="text" name="profession"
                                       id="profession" required="" class="text_bangla form-control"
                                       placeholder="পেশা বাংলায় লিখুন">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="branch_id" class="">@if($application->activation_status == 0)
                                        আবেদনকারীর @else সদস্যের @endif দপ্তরের নাম *</label>

                                <div class="">
                                    <select name="branch_id" id="branch_id" class="form-control" required="">
                                        <option value="" selected="" disabled="">দপ্তরের নাম নির্ধারণ করুন</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                    @if($branch->id == $application->branch_id) selected="" @endif>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="position_id" class="">@if($application->activation_status == 0)
                                        আবেদনকারীর @else সদস্যের @endif পদবি *</label>

                                <div class="">
                                    <select name="position_id" id="position_id" class="form-control" required="">
                                        <option value="" selected="" disabled="">পদবি নির্ধারণ করুন</option>
                                        <option value="34" @if($application->position_id == 34) selected="" @endif>
                                            সদস্য
                                        </option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}"
                                                    @if($position->id == $application->position_id) selected="" @endif>{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($application->activation_status == 1)
                        <div class="form-group invisible" id="start_date_input">
                            {!! Form::label('start_date', 'নতুন পদবি/দপ্তর এ যোগদানের তারিখ *') !!}
                            <input type="text" class="form-control" name="start_date" id="start_date" data-field="date"
                                   autocomplete="off"
                                   placeholder="নতুন পদবি/দপ্তর এ যোগদানের তারিখ">
                            {{--                            {!! Form::text('start_date', null, array('class' => 'form-control', 'placeholder' => 'নতুন পদবি/দপ্তর এ যোগদানের তারিখ লিখুন', 'required')) !!}--}}
                        </div>
                    @endif

                    <div class="form-group ">
                        <label for="joining_date" class="">চাকুরীতে যোগদানের তারিখ (তথ্য না থাকলে ফাঁকা রাখুন)</label>
                        @if($application->joining_date != null)
                            <input value="{{ date('d-m-Y', strtotime($application->joining_date)) }}" data-field="date"
                                   autocomplete="off" type="text" name="joining_date" id="joining_date"
                                   class="form-control" placeholder="চাকুরীতে যোগদানের তারিখ">
                        @else
                            <input value="" data-field="date" autocomplete="off" type="text" name="joining_date"
                                   id="joining_date" class="form-control" placeholder="চাকুরীতে যোগদানের তারিখ">
                        @endif
                    </div>
                    <div class="form-group ">
                        <label for="prl_date" class="">চাকুরি থেকে অবসর গ্রহণের তারিখ <b>(তথ্য না থাকলে ফাঁকা
                                রাখুন)</b></label>


                        <input @if($application->prl_date != null)  value="{{ date('d-m-Y', strtotime($application->prl_date)) }}"
                               @else value="" @endif
                               data-field="date"
                               autocomplete="off" type="text" name="prl_date" id="prl_date"
                               class="form-control" placeholder="চাকুরি থেকে অবসর গ্রহণের তারিখ">

                    </div>


                    <div class="form-group ">
                        <label for="present_address" class="">বর্তমান ঠিকানা</label>
                        <input value="{{ $application->present_address }}" type="text" name="present_address"
                               id="present_address" required="" class="text_bangla form-control"
                               placeholder="বাংলায় লিখুন">
                    </div>
                    <div class="form-group ">
                        <label for="permanent_address" class="">স্থায়ী ঠিকানা</label>
                        <input value="{{ $application->permanent_address }}" type="text" name="permanent_address"
                               id="permanent_address" class="text_bangla form-control" required=""
                               placeholder="বাংলায় লিখুন">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="office_telephone" class="">অফিসের টেলিফোন (ঐচ্ছিক)</label>
                                <input value="{{ $application->office_telephone }}" class="form-control" type="number"
                                       name="office_telephone" id="office_telephone"
                                       placeholder="অফিসের টেলিফোন নম্বর ইংরেজি লিখুন">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="mobile" class="">মোবাইল নম্বর (সক্রিয় নম্বর দিন, এই নম্বরে SMS যাবে)
                                    *</label>
                                <input value="{{ $application->mobile }}" class="form-control" type="number"
                                       {{-- pattern="/^-?\d+\.?\d*$/" --}} onKeyPress="if(this.value.length==11) return false;"
                                       name="mobile" id="mobile" required="" placeholder="ইংরেজি অংকে লিখুন (১১ ডিজিট)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="home_telephone" class="">বাসার টেলিফোন (ঐচ্ছিক)</label>
                                <input value="{{ $application->home_telephone }}" class="form-control" type="number"
                                       name="home_telephone" id="home_telephone"
                                       placeholder="বাসার টেলিফোন নম্বর ইংরেজিতে লিখুন">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="email" class="">ইমেইল এড্রেস <small>(ইমেইল না থাকলে ফাঁকা
                                        রাখুন)</small></label>
                                <input value="{{ $application->email }}" class="form-control" type="email" name="email"
                                       id="email" autocomplete="off" placeholder="একটি ভ্যালিড ইমেইল এড্রেস লিখুন">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group ">
                                <label><strong>@if($application->activation_status == 0) আবেদনকারীর @else সদস্যের @endif
                                        রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০ কিলোবাইট)</strong></label>
                                <input value="" class="form-control" type="file" id="image" name="image">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img src="{{ asset('images/users/'. $application->image)}}" id='img-upload'
                                 style="height: 120px; width: auto; padding: 5px;"/>
                        </div>
                    </div>

                    <h3 class="agency-title margin-two">নমিনীর বিস্তারিত তথ্যঃ (নমিনি ০১) <small>(নমিনির তথ্য নমিনি ০১
                            এর ক্ষেত্রে বাধ্যতামূলক)</small></h3>

                    <div class="form-group ">
                        <label for="nominee_one_name" class="">নাম (বাংলায়) *</label>
                        <input value="{{ $application->nominee_one_name }}" type="text" name="nominee_one_name"
                               id="nominee_one_name" required="" class="text_bangla form-control"
                               placeholder="বাংলা বর্ণমালায় লিখুন">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_identity_type" class="">দলিলের ধরণ</label>
                                <select class="form-control" name="nominee_one_identity_type"
                                        id="nominee_one_identity_type" required="">
                                    <option value="" selected="" disabled="">দলিলের ধরণ নির্ধারণ করুন</option>
                                    <option value="0"
                                            @if($application->nominee_one_identity_type == 0) selected="" @endif>জাতীয়
                                        পরিচয়পত্র
                                    </option>
                                    <option value="1"
                                            @if($application->nominee_one_identity_type == 1) selected="" @endif>জন্ম
                                        নিবন্ধন
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_identity_text" class="">জাতীয় পরিচয়পত্র/ জন্ম নিবন্ধন নম্বর
                                    <label for="nominee_one_identity_text" class="">জাতীয় পরিচয়পত্র/ জন্ম নিবন্ধন নম্বর
                                        *</label>
                                    <input value="{{ $application->nominee_one_identity_text }}" class="form-control"
                                           type="number"
                                           {{-- pattern="/^-?\d+\.?\d*$/" --}} onKeyPress="if(this.value.length==17) return false;"
                                           name="nominee_one_identity_text" id="nominee_one_identity_text" required=""
                                           placeholder="ইংরেজি অংকে লিখুন">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_relation" class="">সম্পর্ক *</label>
                                <input value="{{ $application->nominee_one_relation }}" type="text"
                                       name="nominee_one_relation" id="nominee_one_relation"
                                       class="text_bangla form-control" required="" placeholder="সম্পর্ক লিখুন">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nominee_one_percentage" class="">শতকরা হার (%) *</label>
                                <input value="{{ $application->nominee_one_percentage }}" class="form-control"
                                       type="number" min="1" max="100" minlength="1" maxlength="3"
                                       name="nominee_one_percentage" id="nominee_one_percentage" required=""
                                       placeholder="ইংরেজি অংকে লিখুন">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><strong>নমিনির রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০ কিলোবাইট) *</strong></label>
                                <input value="" class="form-control" type="file" id="nominee_one_image"
                                       name="nominee_one_image">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img src="{{ asset('images/users/'. $application->nominee_one_image)}}"
                                 id='nominee_one_image-upload' style="height: 120px; width: auto; padding: 5px;"/>
                        </div>
                    </div>

                    <br/><br/>
                    <div class="panel-group toggles-style1 no-border">
                        <div class="panel panel-primary" id="collapse-nominee2">
                            <div role="tablist" id="headingnominee2" class="panel-heading">
                                <a data-toggle="collapse" data-parent="#collapse-nominee2"
                                   href="#collapse-nominee2-link1">
                                    <h4 class="text-white">@if($application->nominee_two_name != '') নমিনি ০২ @else  আরও
                                        একজন নমিনি যোগ করতে, এখানে ক্লিক করুন @endif
                                        <span class="pull-right">
                                  <i class="fa @if($application->nominee_two_name != '') fa-minus @else  fa-plus @endif"></i>
                              </span>
                                    </h4>
                                </a>
                            </div>
                            <div id="collapse-nominee2-link1"
                                 class="panel-collapse collapse @if($application->nominee_two_name != '') in @endif">
                                <div class="panel-body">
                                    <h3 class="agency-title margin-two">নমিনীর বিস্তারিত তথ্যঃ (নমিনি ০২) <small>(নমিনির
                                            তথ্য নমিনি ০২ এর ক্ষেত্রে ঐচ্ছিক)</small></h3>

                                    <div class="form-group">
                                        <label for="nominee_two_name" class="">নাম (বাংলায়)</label>
                                        <input value="{{ $application->nominee_two_name }}" type="text"
                                               name="nominee_two_name" id="nominee_two_name"
                                               class="text_bangla form-control" placeholder="বাংলা বর্ণমালায় লিখুন">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nominee_two_identity_type" class="">দলিলের ধরণ</label>
                                                <select class="form-control" name="nominee_two_identity_type"
                                                        id="nominee_two_identity_type">
                                                    <option value="" selected="" disabled="">দলিলের ধরণ নির্ধারণ করুন
                                                    </option>
                                                    <option value="0"
                                                            @if($application->nominee_two_identity_type == 0) selected="" @endif>
                                                        জাতীয় পরিচয়পত্র
                                                    </option>
                                                    <option value="1"
                                                            @if($application->nominee_two_identity_type == 1) selected="" @endif>
                                                        জন্ম নিবন্ধন
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nominee_two_identity_text" class="">জাতীয় পরিচয়পত্র/ জন্ম
                                                    নিবন্ধন নম্বর</label>
                                                <input value="{{ $application->nominee_two_identity_text }}"
                                                       class="form-control" type="number"
                                                       {{-- pattern="/^-?\d+\.?\d*$/" --}} onKeyPress="if(this.value.length==17) return false;"
                                                       name="nominee_two_identity_text" id="nominee_two_identity_text"
                                                       placeholder="ইংরেজি অংকে লিখুন">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nominee_two_relation" class="">সম্পর্ক</label>
                                                <input value="{{ $application->nominee_two_relation }}" type="text"
                                                       name="nominee_two_relation" id="nominee_two_relation"
                                                       class="text_bangla form-control form-control"
                                                       placeholder="সম্পর্ক লিখুন">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nominee_two_percentage" class="">শতকরা হার (%)</label>
                                                <input value="{{ $application->nominee_two_percentage }}"
                                                       class="form-control" type="number" min="1" max="100"
                                                       minlength="1" maxlength="3" name="nominee_two_percentage"
                                                       id="nominee_two_percentage" placeholder="ইংরেজি অংকে লিখুন">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label><strong>নমিনির রঙিন ছবি (৩০০x৩০০ এবং সর্বোচ্চ ২৫০
                                                        কিলোবাইট)</strong></label>
                                                <input value="" class="form-control" type="file" id="nominee_two_image"
                                                       name="nominee_two_image">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="@if($application->nominee_two_image != '') {{ asset('images/users/' .$application->nominee_two_image)}} @else {{ asset('images/user.png')}} @endif"
                                                 id='nominee_two_image-upload'
                                                 style="height: 120px; width: auto; padding: 5px;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>


                    @if($application->activation_status == 0)
                        <h3 class="agency-title margin-two">পরিশোধ সংক্রান্ত</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('application_payment_amount', 'পরিমাণ *') !!}
                                    {!! Form::text('application_payment_amount', $application->application_payment_amount, array('class' => 'form-control', 'id' => 'application_payment_amount', 'placeholder' => 'পরিমাণ লিখুন (৫০০ এর গুণিতকে)', 'required' => '')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('application_payment_pay_slip', 'পে-স্লিপ নম্বর *') !!}
                                    {!! Form::text('application_payment_pay_slip', $application->application_payment_pay_slip, array('class' => 'form-control', 'id' => 'application_payment_pay_slip', 'placeholder' => 'পে-স্লিপ নম্বর লিখুন', 'required' => '')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('application_payment_bank', 'ব্যাংকের নাম *') !!}
                                    {!! Form::text('application_payment_bank', $application->application_payment_bank, array('class' => 'text_bangla form-control', 'id' => 'application_payment_bank', 'placeholder' => 'ব্যাংকের নাম লিখুন', 'required' => '', 'data-parsley-required-message' => 'ব্যাংকের নামটি বাংলায় লিখুন')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('application_payment_branch', 'ব্রাঞ্চের নাম *') !!}
                                    {!! Form::text('application_payment_branch', $application->application_payment_branch, array('class' => 'text_bangla form-control', 'id' => 'application_payment_branch', 'placeholder' => 'ব্রাঞ্চের নাম বাংলায় লিখুন', 'required' => '')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group ">
                                    <label><strong>টাকা পরিশোধের রিসিট (সর্বোচ্চ ২ মেগাবাইট) *</strong></label>
                                    <input value="" class="form-control" type="file" id="application_payment_receipt"
                                           name="application_payment_receipt">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img src="{{ asset('images/receipts/'. $application->application_payment_receipt)}}"
                                     id='application_payment_receipt-upload'
                                     style="max-width: 250px; height: auto; padding: 5px;" class="img-responsive"/>
                            </div>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group ">
                                <label><strong>সদস্য আবেদন ফর্মের হার্ড কপি (সর্বোচ্চ ২ মেগাবাইট)</strong></label>
                                <input type="file" id="application_hard_copy"
                                       name="application_hard_copy">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img src="@if($application->application_hard_copy != null) {{ asset('images/users/' .$application->application_hard_copy)}} @else {{ asset('images/800x500.png')}} @endif"
                                 id='application_hard_copy-upload'
                                 style="width: 250px; height: auto; padding: 5px;"/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group ">
                                <label><strong>@if($application->activation_status == 0)
                                            আবেদনকারীর @else সদস্যের @endif স্বাক্ষর (সর্বোচ্চ ২৫০
                                        কিলোবাইট) </strong></label>
                                <input type="file" id="digital_signature" name="digital_signature">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img src="@if($application->digital_signature != null) {{ asset('images/users/' .$application->digital_signature)}} @else {{ asset('images/800x500.png')}} @endif"
                                 id='digital_signature-upload' style="width: 250px; height: auto; padding: 5px;"/>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#submitApplicationModal"
                            data-backdrop="static">@if($application->activation_status == 0) আবেদন @else তথ্য @endif
                        হালনাগাদ করুন
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="dtBox"></div>
    <!-- Before Submit Modal -->
    <!-- Before Submit Modal -->
    <div class="modal fade" id="submitApplicationModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@if($application->activation_status == 0) সদস্যপদ আবেদন @else তথ্য @endif
                        দাখিল</h4>
                </div>
                <div class="modal-body">
                    <big>আপনি কি নিশ্চিতভাবে তথ্যসমূহ দাখিল করতে চান?</big><br/><br/>
                    <span><b>দাখিল করার পূর্বে...</b></span><br/>
                    <ul>
                        <li><i class="fa fa-check-square-o"></i> প্রতিটি বাধ্যতামূলক (* দেওয়া) ঘর পূরন করেছেন কি না
                            যাচাই করুন
                        </li>
                        <li><i class="fa fa-check-square-o"></i> ছবি ও অন্যান্য ফাইলগুলো ঠিকমতো দিয়েছেন কি না লক্ষ্য
                            করুন
                        </li>
                        <li><i class="fa fa-check-square-o"></i> নম্বর সংক্রান্ত তথ্যগুলো (যেমনঃ মোবাইল নম্বর, পরিচয়পত্র
                            নম্বর, শতকরা হার ইত্যাদি <b>ইংরেজি অংকে (0,1,3,4...)</b> দিয়েছেন কি না যাচাই করুন)
                        </li>
                        <li><i class="fa fa-check-square-o"></i> নমিনি একজন হলে শতকরা হার ঘরের মান 100 রাখুন</li>
                        <li><i class="fa fa-check-square-o"></i> নমিনি দুইজন হলে দুই নমিনির শতকরা হারের যোগফল যেন 100 হয়
                            সেদিকে খেয়াল রাখুন
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" type="submit"
                            id="submit_btn">@if($application->activation_status == 0) আবেদন @else সদস্য তথ্য @endif
                        হালনাগাদ করুন
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Before Submit Modal -->
    <!-- Before Submit Modal -->
    {{ Form::close() }}
@endsection

@section('js')
    {!!Html::script('js/parsley.min.js')!!}
    {{-- <script type="text/javascript" src="{{ asset('js/jquery-3.1.0.min.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/DateTimePicker.min.js') }}"></script>
    <script type="text/javascript">
        function setDefaultVal(value) {
            if (value.length == 0) {
                return 0;
            } else {
                return value;
            }
        }

        $('#name').keyup(function () {
            this.value = this.value.toUpperCase();
        });
        $(document).ready(function () {
            $("#dtBox").DateTimePicker({
                mode: "date",
                dateFormat: "dd-MM-yyyy",
                titleContentDate: 'তারিখ নির্ধারণ করুন'
            });

            $('#nominee_one_percentage').blur(function () {
                var percentagesum1 = parseInt(setDefaultVal($('#nominee_one_percentage').val())) + parseInt(setDefaultVal($('#nominee_two_percentage').val()));
                if (percentagesum1 != 100) {
                    toastr.warning('দুইজন নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
                } else {
                    toastr.success('দুইজন নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
                }
            })

            $('#nominee_two_percentage').blur(function () {
                var percentagesum2 = parseInt(setDefaultVal($('#nominee_one_percentage').val())) + parseInt(setDefaultVal($('#nominee_two_percentage').val()));
                if (percentagesum2 != 100) {
                    toastr.warning('দুইজন নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
                } else {
                    toastr.success('দুইজন নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
                }
            })

            $('#password_confirmation').keyup(function () {
                if ($('#password_confirmation').val() != $('#password').val()) {
                    $('#password_confirmation_error').html('পাসওয়ার্ডটি আবার দিন <span style="color: #DC143C;"><b>✕ মিলছে না</b></span>');
                } else {
                    $('#password_confirmation_error').html('পাসওয়ার্ডটি আবার দিন <span style="color: #008000;"><b>✓ মিলেছে</b></span>');
                }
            })
        });

        // disabling the number scrolling...
        $(function () {
            $(':input[type=number]').on('mousewheel', function (e) {
                $(this).blur();
            });
        });

        // if empty on blur
        $(":input[required]").blur(function () {
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
        $(".text_bangla").blur(function () {
            var regexp = /[অআইঈউঊঋএঐওঔকখগঘঙচছজঝঞটঠডঢণতথদধনপফবভমযরলশষসহড়ঢ়য়ৎংঃঁ১২৩৪৫৬৭৮৯০][^ABC]\D\W/g;
            if (!$(this).val().match(regexp)) {
                $(this).addClass('input_empty');
            }
        });
        $("#name").blur(function () {
            var regexp = /^[A-Za-z0-9 _.-]+$/;
            if (!$(this).val().match(regexp)) {
                $(this).addClass('input_empty');
            }
        });
        $("#dob").blur(function () {
            var regexp = /^[A-Za-z0-9 _.-]+$/;
            if (!$(this).val().match(regexp)) {
                $(this).addClass('input_empty');
            }
        });
        $(":input[type=number]").blur(function () {
            var regexp = /^-?\d*$/;
            if (!$(this).val().match(regexp)) {
                $(this).addClass('input_empty');
            }
        });

        // on submisiion check percentage total
        $("#application_form").submit(function (event) {
            var $form = $(this);

            if ($form.find('input[required]').filter(function () {
                // console.log(this);
                // console.log(this.value);
                // console.log('\n\n');

                return this.value === ''
            }).length > 0) {
                toastr.warning('* চিহ্নিত ঘরগুলো পূরন করুন').css('width', '400px;');
                event.preventDefault();
                $('#submitApplicationModal').modal('hide');
                $('html,body').animate({scrollTop: $("#application_form").offset().top}, 'slow');
            }

            var percentagesum = parseInt(setDefaultVal($('#nominee_one_percentage').val())) + parseInt(setDefaultVal($('#nominee_two_percentage').val()));
            if (percentagesum != 100) {
                toastr.warning('নমিনির শতকরা অংশের যোগফল ১০০ হওয়া বাঞ্ছনীয়!').css('width', '400px;');
                event.preventDefault();
                $('#submitApplicationModal').modal('hide');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 170
                }, 500);
            }

            @if($application->activation_status == 0)
            if ($('#application_payment_amount').val() % 500 == 0) {

            } else {
                toastr.warning('পরিমাণ ৫০০ এর গুণিতকে দিন', 'WARNING').css('width', '400px');
                event.preventDefault();
                $('#submitApplicationModal').modal('hide');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 170
                }, 500);
            }

            if ($('#application_payment_amount').val() < 5000) {
                toastr.warning('পরিমাণ কমপক্ষে ৫০০০ হতে হবে', 'WARNING').css('width', '400px');
                event.preventDefault();
                $('#submitApplicationModal').modal('hide');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 170
                }, 500);
            }
            @endif
            deferred.success(function () {
                $("#submit_btn").prop("disabled", true);
            });
        })

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            @if($application->activation_status == 0)
            $('#application_payment_amount').blur(function () {
                var value = $('#application_payment_amount').val();
                if (value % 500 == 0) {

                } else {
                    toastr.warning('পরিমাণ ৫০০ এর গুণিতকে দিন', 'WARNING').css('width', '400px');
                }

                if (value < 5000) {
                    toastr.warning('পরিমাণ কমপক্ষে ৫০০০ হতে হবে', 'WARNING').css('width', '400px');
                }
            })
            @endif

        });
    </script>
    <script type="text/javascript">
        var _URL = window.URL || window.webkitURL;
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {
                var input = $(this).parents('.input-group').find(':text'),
                    log = label;
                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
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

            $("#image").change(function () {
                readURL(this);
                var file, img;

                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function () {
                        var imagewidth = this.width;
                        var imageheight = this.height;
                        filesize = parseInt((file.size / 1024));
                        if (filesize > 250) {
                            $("#image").val('');
                            toastr.warning('ফাইলের আকৃতি ' + filesize + ' কিলোবাইট. ২৫০ কিলোবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
                            setTimeout(function () {
                                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
                            }, 1000);
                        }
                        console.log(imagewidth / imageheight);
                        if (((imagewidth / imageheight) < 0.9375) || ((imagewidth / imageheight) > 1.07142)) {
                            $("#image").val('');
                            toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:১ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
                            setTimeout(function () {
                                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
                            }, 1000);
                        }
                    };
                    img.onerror = function () {
                        $("#image").val('');
                        toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
                        setTimeout(function () {
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

            $("#nominee_one_image").change(function () {
                readURLNominee1(this);
                var file, img;

                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function () {
                        var nominee_one_image_width = this.width;
                        var nominee_one_image_height = this.height;
                        filesize = parseInt((file.size / 1024));
                        if (filesize > 250) {
                            $("#nominee_one_image").val('');
                            toastr.warning('ফাইলের আকৃতি ' + filesize + ' কিলোবাইট. ২৫০ কিলোবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
                            setTimeout(function () {
                                $("#nominee_one_image-upload").attr('src', '{{ asset('images/user.png') }}');
                            }, 1000);
                        }
                        console.log(nominee_one_image_width / nominee_one_image_height);
                        if (((nominee_one_image_width / nominee_one_image_height) < 0.9375) || ((nominee_one_image_width / nominee_one_image_height) > 1.07142)) {
                            $("#nominee_one_image").val('');
                            toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:১ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
                            setTimeout(function () {
                                $("#nominee_one_image-upload").attr('src', '{{ asset('images/user.png') }}');
                            }, 1000);
                        }
                    };
                    img.onerror = function () {
                        $("#nominee_one_image").val('');
                        toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
                        setTimeout(function () {
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

            $("#nominee_two_image").change(function () {
                readURLNominee2(this);
                var file, img;

                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function () {
                        var nominee_two_image_width = this.width;
                        var nominee_two_image_height = this.height;
                        filesize = parseInt((file.size / 1024));
                        if (filesize > 250) {
                            $("#nominee_two_image").val('');
                            toastr.warning('ফাইলের আকৃতি ' + filesize + ' কিলোবাইট. ২৫০ কিলোবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
                            setTimeout(function () {
                                $("#nominee_two_image-upload").attr('src', '{{ asset('images/user.png') }}');
                            }, 1000);
                        }
                        console.log(nominee_two_image_width / nominee_two_image_height);
                        if (((nominee_two_image_width / nominee_two_image_height) < 0.9375) || ((nominee_two_image_width / nominee_two_image_height) > 1.07142)) {
                            $("#nominee_two_image").val('');
                            toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:১ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
                            setTimeout(function () {
                                $("#nominee_two_image-upload").attr('src', '{{ asset('images/user.png') }}');
                            }, 1000);
                        }
                    };
                    img.onerror = function () {
                        $("#nominee_two_image").val('');
                        toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
                        setTimeout(function () {
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

            $("#application_payment_receipt").change(function () {
                readURLApplicationPaymentReceipt(this);
                var filesize = parseInt((this.files[0].size) / 1024);
                if (filesize > 2048) {
                    $("#application_payment_receipt").val('');
                    toastr.warning('ফাইলের আকৃতি ' + filesize + ' কিলোবাইট. ২ মেগাবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
                    setTimeout(function () {
                        $("#application_payment_receipt-upload").attr('src', '{{ asset('images/800x500.png') }}');
                    }, 1000);
                }
            });


            function readURLApplicationHardCopy(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#application_hard_copy-upload').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#application_hard_copy").change(function () {
                readURLApplicationHardCopy(this);
                var filesize = parseInt((this.files[0].size) / 1024);
                if (filesize > 2048) {
                    $("#application_hard_copy").val('');
                    toastr.warning('ফাইলের আকৃতি ' + filesize + ' কিলোবাইট. ২ মেগাবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
                    setTimeout(function () {
                        $("#application_hard_copy-upload").attr('src', '{{ asset('images/800x500.png') }}');
                    }, 1000);
                }
            });


            function readURLDigitalSignature(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#digital_signature-upload').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#digital_signature").change(function () {
                readURLDigitalSignature(this);
                var file, img;

                if ((file = this.files[0])) {
                    img = new Image();
                    img.onload = function () {
                        var nominee_two_image_width = this.width;
                        var nominee_two_image_height = this.height;
                        filesize = parseInt((file.size / 1024));
                        if (filesize > 250) {
                            $("#digital_signature").val('');
                            toastr.warning('ফাইলের আকৃতি ' + filesize + ' কিলোবাইট. ২৫০ কিলোবাইটের মধ্যে আপলোড করার চেস্টা করুন', 'WARNING').css('width', '400px;');
                            setTimeout(function () {
                                $("#digital_signature-upload").attr('src', '{{ asset('images/800x500.png') }}');
                            }, 1000);
                        }
                        console.log(nominee_two_image_width / nominee_two_image_height);
                        if (((nominee_two_image_width / nominee_two_image_height) < 0.9375) || ((nominee_two_image_width / nominee_two_image_height) > 1.07142)) {
                            $("#digital_signature").val('');
                            toastr.warning('দৈর্ঘ্য এবং প্রস্থের অনুপাত ১:১ হওয়া বাঞ্ছনীয়!', 'WARNING').css('width', '400px;');
                            setTimeout(function () {
                                $("#digital_signature-upload").attr('src', '{{ asset('images/800x500.png') }}');
                            }, 1000);
                        }
                    };
                    img.onerror = function () {
                        $("#digital_signature").val('');
                        toastr.warning('অনুগ্রহ করে ছবি সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
                        setTimeout(function () {
                            $("#digital_signature-upload").attr('src', '{{ asset('images/user.png') }}');
                        }, 1000);
                    };
                    img.src = _URL.createObjectURL(file);
                }
            });
        });

        $('.panel-heading > a').click(function () {
            $(this).parents('.panel-primary').find('i').toggleClass('fa-plus fa-minus');
            $(this).parents('.panel-primary').siblings('.panel-primary').find('i').removeClass('fa-minus').addClass('fa-plus')

        });


        $('#position_id').change(function (e) {
            e.preventDefault();
            $('#start_date_input').removeClass('invisible');
            $('#start_date_input').addClass('visible');
        });

        $('#branch_id').change(function (e) {
            e.preventDefault();
            $('#start_date_input').removeClass('invisible');
            $('#start_date_input').addClass('visible');
        });
    </script>
@endsection
