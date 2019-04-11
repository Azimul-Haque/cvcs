@extends('adminlte::page')

@section('title', 'CVCS | সদস্য তথ্য')

@section('css')

@stop

@section('content_header')
    <h1>
      সদস্য তথ্য
      <div class="pull-right">
        @if(Auth::user()->activation_status == 0)

        @else
          <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal" data-backdrop="static" title="প্রোফাইল সম্পাদনা করুন"><i class="fa fa-fw fa-edit" aria-hidden="true"></i></button>
          {{-- <button class="btn btn-danger" data-toggle="modal" data-target="#deleteMemberModal" data-backdrop="static" title="সদস্য মুছে ফেলুন" disabled=""><i class="fa fa-fw fa-trash" aria-hidden="true"></i></button> --}}
        @endif
      </div>
    </h1>

    <!-- Edit Info Modal -->
    <!-- Edit Info Modal -->
    <div class="modal fade" id="editProfileModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-primary">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-envelope"></i> তথ্য সম্পাদনা করুন</h4>
          </div>
          {!! Form::open(['route' => 'dashboard.sendsmsapplicant', 'method' => 'POST', 'class' => 'form-default']) !!}
          <div class="modal-body">
            {!! Form::hidden('unique_key', $member->unique_key) !!}
            {{-- {!! Form::textarea('message', null, array('class' => 'form-control textarea', 'placeholder' => 'বার্তা লিখুন', 'required' => '')) !!} --}}
          </div>
          <div class="modal-footer">
                {{-- {!! Form::submit('বার্তা পাঠান', array('class' => 'btn btn-primary')) !!} --}}
                <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
            {!! Form::close() !!}
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Edit Info Modal -->
    <!-- Edit Info Modal -->
@stop

@section('content')
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#personal_info_tab" data-toggle="tab" aria-expanded="false">ব্যক্তিগত তথ্য</a></li>
      <li class=""><a href="#mominee_tab" data-toggle="tab" aria-expanded="false">নমিনি সংক্রান্ত</a></li>
      <li class=""><a href="#membership_payment_tab" data-toggle="tab" aria-expanded="true">সদস্যপদ পরিশোধ তথ্য</a></li>
      <li class="pull-right dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><i class="fa fa-gear"></i>
        </a>
        <ul class="dropdown-menu">
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
          <li role="presentation" class="divider"></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
        </ul>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="personal_info_tab">
        <div class="row">
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>পরিচিতি</center>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <center>
                      @if($member->image != null)
                          <img src="{{ asset('images/users/'.$member->image)}}" alt="image of {{ $member->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $member->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                @if(Auth::user()->activation_status == 1)
                <tr>
                  <th width="40%">সদস্যপদ নং</th>
                  <td>{{ $member->member_id }}</td>
                </tr>
                @endif
                <tr>
                  <th width="40%">আবেদনকারীর নাম (বাংলায়)</th>
                  <td>{{ $member->name_bangla }}</td>
                </tr>
                <tr>
                  <th>আবেদনকারীর নাম (ইংরেজিতে)</th>
                  <td>{{ $member->name}}</td>
                </tr>
                <tr>
                  <th>জাতীয় পরিচয়পত্র নং</th>
                  <td>{{ $member->nid}}</td>
                </tr>
                <tr>
                  <th>জন্ম তারিখ</th>
                  <td>{{ date('F d, Y', strtotime($member->dob)) }}</td>
                </tr>
                <tr>
                  <th>লিঙ্গ</th>
                  <td>{{ $member->gender }}</td>
                </tr>
                <tr>
                  <th>স্বামী/স্ত্রীর নাম</th>
                  <td>{{ $member->spouse }}</td>
                </tr>
                <tr>
                  <th>স্বামী/স্ত্রীর পেশা</th>
                  <td>{{ $member->spouse_profession }}</td>
                </tr>
                <tr>
                  <th>পিতার নাম</th>
                  <td>{{ $member->father }}</td>
                </tr>
                <tr>
                  <th>পিতার নাম</th>
                  <td>{{ $member->mother }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>কর্ম সংক্রান্ত</center>
                  </th>
                </tr>
                <tr>
                  <th width="40%">আবেদনকারীর পেশা</th>
                  <td>{{ $member->profession }}</td>
                </tr>
                <tr>
                  <th>আবেদনকারীর পদবি</th>
                  <td>{{ $member->designation }}</td>
                </tr>
                <tr>
                  <th>দপ্তরের নাম</th>
                  <td>{{ $member->office }}</td>
                </tr>

                <tr>
                  <th colspan="2">
                    <center>যোগাযোগ</center>
                  </th>
                </tr>
                <tr>
                  <th>বর্তমান ঠিকানা</th>
                  <td>{{ $member->present_address }}</td>
                </tr>
                <tr>
                  <th>স্থায়ী ঠিকানা</th>
                  <td>{{ $member->permanent_address }}</td>
                </tr>
                <tr>
                  <th>অফিসের টেলিফোন</th>
                  <td>{{ $member->office_telephone }}</td>
                </tr>
                <tr>
                  <th>বাসার টেলিফোন</th>
                  <td>{{ $member->home_telephone }}</td>
                </tr>
                <tr>
                  <th>মোবাইল</th>
                  <td>{{ $member->mobile }}</td>
                </tr>
                <tr>
                  <th>ইমেইল এড্রেস</th>
                  <td>{{ $member->email }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="mominee_tab">
        <div class="row">
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>নমিনি ০১</center>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <center>
                      @if($member->nominee_one_image != null)
                          <img src="{{ asset('images/users/'.$member->nominee_one_image)}}" alt="image of {{ $member->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $member->nominee_one_name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                <tr>
                  <th width="40%">নমিনীর নাম (বাংলায়)</th>
                  <td>{{ $member->nominee_one_name }}</td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>
                    {{ $member->nominee_one_identity_text }}
                    @if($member->nominee_one_identity_type == 0)
                      (জাতীয় পরিচয়পত্র)
                    @else
                      (জন্ম নিবন্ধন)
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>{{ $member->nominee_one_relation }}</td>
                </tr>
                <tr>
                  <th>শতকরা হার</th>
                  <td>{{ $member->nominee_one_percentage }}%</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>নমিনি ০২</center>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <center>
                      @if($member->nominee_two_image != null)
                          <img src="{{ asset('images/users/'.$member->nominee_two_image)}}" alt="image of {{ $member->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $member->nominee_two_name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                <tr>
                  <th width="40%">নমিনীর নাম (বাংলায়)</th>
                  <td>{{ $member->nominee_two_name }}</td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>
                    {{ $member->nominee_two_identity_text }}
                    @if($member->nominee_two_identity_type == 0)
                      (জাতীয় পরিচয়পত্র)
                    @else
                      (জন্ম নিবন্ধন)
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>{{ $member->nominee_two_relation }}</td>
                </tr>
                <tr>
                  <th>শতকরা হার</th>
                  <td>{{ $member->nominee_two_percentage }}%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="membership_payment_tab">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ব্যাংক</th>
                <th>ব্রাঞ্চ/ শাখা</th>
                <th>পে-স্লিপ নম্বর</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $member->application_payment_bank }}</td>
                <td>{{ $member->application_payment_branch }}</td>
                <td>{{ $member->application_payment_pay_slip }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <br/><br/>
        <span>ব্যাংক পে-স্লিপের ছবিঃ</span>
        @if($member->application_payment_receipt != null)
            <img src="{{ asset('images/receipts/'.$member->application_payment_receipt)}}" alt="Receipt of membership payment {{ $member->name }}" class="img-responsive shadow" style="width: 100%; height: auto;" />
        @else
            ফাইল পাওয়া যায়নি!
        @endif
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
@stop

@section('js')

@stop