@extends('adminlte::page')

@section('title', 'CVCS | আবেদন')

@section('css')

@stop

@section('content_header')
    <h1>
      @if($application->activation_status == 202)
        অসম্পূর্ণ
      @endif আবেদন
      <div class="pull-right">
        @if($application->activation_status == 0)
          @if(Auth::user()->email != 'dataentry@cvcsbd.com')
            <button class="btn btn-success" data-toggle="modal" data-target="#activateMemberModal" data-backdrop="static" title="অনুমোদন করুন"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
          @endif
          <a class="btn btn-danger" data-toggle="modal" data-target="#sendToDefectiveListModal" data-backdrop="static" title="অসম্পূর্ণ আবেদনের তালিকায় পাঠান"><i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i></a>
        @elseif($application->activation_status == 202)
          <a class="btn btn-info" data-toggle="modal" data-target="#sendToApplicationsFromDefectiveModal" data-backdrop="static" title="আবেদনের তালিকায় পাঠান"><i class="fa fa-fw fa-hourglass-o" aria-hidden="true"></i></a>
        @endif
        <a class="btn btn-warning" data-toggle="modal" data-target="#sendMessageModal" data-backdrop="static" title="বার্তা পাঠান"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i></a>
        <a class="btn btn-primary" href="{{ route('dashboard.singleapplicationedit', $application->unique_key) }}" title="আবেদনটি সম্পাদনা করুণ"><i class="fa fa-edit"></i></a>
        <a class="btn btn-danger" data-toggle="modal" data-target="#deleteApplicationModal" data-backdrop="static" title="আবেদন মুছে ফেলুন"><i class="fa fa-fw fa-trash" aria-hidden="true"></i></a>
      </div>
    </h1>
    <!-- Activate User Modal -->
    <!-- Activate User Modal -->
    <div class="modal fade" id="activateMemberModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-check"></i> সদস্য অনুমোদন</h4>
          </div>
          <div class="modal-body">
            আপনি কি নিশ্চিতভাবে এই আবেদনটি অনুমোদন করতে চান?
          </div>
          <div class="modal-footer">
            {!! Form::model($application, ['route' => ['dashboard.activatemember', $application->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- Activate User Modal -->
    <!-- Activate User Modal -->

    <!-- Send To Defective List Modal -->
    <!-- Send To Defective List Modal -->
    <div class="modal fade" id="sendToDefectiveListModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> অসম্পূর্ণ আবেদন তালিকায় প্রেরণ</h4>
          </div>
          <div class="modal-body">
            আপনি কি এই আবেদনটি <b>অসম্পূর্ণ আবেদন তালিকায়</b> পাঠাতে চান?
          </div>
          <div class="modal-footer">
            {!! Form::model($application, ['route' => ['dashboard.makedefective', $application->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-danger')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- Send To Defective List Modal -->
    <!-- Send To Defective List Modal -->

    <!-- Send To Applications From Defective List Modal -->
    <!-- Send To Applications From Defective List Modal -->
    <div class="modal fade" id="sendToApplicationsFromDefectiveModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-hourglass-o"></i> আবেদন তালিকায় প্রেরণ</h4>
          </div>
          <div class="modal-body">
            আপনি কি এই আবেদনটি <b>আবেদন তালিকায়</b> পাঠাতে চান?
          </div>
          <div class="modal-footer">
            {!! Form::model($application, ['route' => ['dashboard.makedefectivetopending', $application->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-info')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- Send To Applications From Defective List Modal -->
    <!-- Send To Applications From Defective List Modal -->

    <!-- Send Message Modal -->
    <!-- Send Message Modal -->
    <div class="modal fade" id="sendMessageModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-warning">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-envelope"></i> আবেদনকারীকে বার্তা পাঠান</h4>
          </div>
          {!! Form::open(['route' => 'dashboard.sendsmsapplicant', 'method' => 'POST', 'class' => 'form-default']) !!}
            <div class="modal-body">
              {!! Form::hidden('unique_key', $application->unique_key) !!}
              {!! Form::textarea('message', null, array('class' => 'form-control textarea', 'placeholder' => 'বার্তা লিখুন', 'required' => '')) !!}
            </div>
            <div class="modal-footer">
                  {!! Form::submit('বার্তা পাঠান', array('class' => 'btn btn-warning')) !!}
                  <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
              {!! Form::close() !!}
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Send Message Modal -->
    <!-- Send Message Modal -->

    <!-- Delete Application Modal -->
    <!-- Delete Application Modal -->
    <div class="modal fade" id="deleteApplicationModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-danger">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-trash"></i> আবেদনটি মুছে ফেলুন</h4>
          </div>
          <div class="modal-body">
            আপনি কি নিশ্চিতভাবে আবেদনটি মুছে ফেলতে চান?
          </div>
          <div class="modal-footer">
            {!! Form::model($application, ['route' => ['dashboard.deleteapplication', $application->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                {!! Form::submit('মুছে ফেলুন', array('class' => 'btn btn-danger')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- Delete Application Modal -->
    <!-- Delete Application Modal -->
@stop

@section('content')
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#personal_info_tab" data-toggle="tab" aria-expanded="false">ব্যক্তিগত তথ্য</a></li>
      <li class=""><a href="#mominee_tab" data-toggle="tab" aria-expanded="false">নমিনি সংক্রান্ত</a></li>
      <li class=""><a href="#membership_payment_tab" data-toggle="tab" aria-expanded="false">সদস্যপদ পরিশোধ তথ্য</a></li>
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
                      @if($application->image != null)
                          <img src="{{ asset('images/users/'.$application->image)}}" alt="image of {{ $application->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $application->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                <tr>
                  <th width="40%">আবেদনকারীর নাম (বাংলায়)</th>
                  <td>{{ $application->name_bangla }}</td>
                </tr>
                <tr>
                  <th>আবেদনকারীর নাম (ইংরেজিতে)</th>
                  <td>{{ $application->name}}</td>
                </tr>
                <tr>
                  <th>জাতীয় পরিচয়পত্র নং</th>
                  <td>{{ $application->nid}}</td>
                </tr>
                <tr>
                  <th>জেলা</th>
                  <td>{{ ($application->upazilla_id != 0)? $application->upazilla->district_bangla: ""}}</td>
                </tr>
                <tr>
                  <th>জন্ম তারিখ</th>
                  <td>{{ date('F d, Y', strtotime($application->dob)) }}</td>
                </tr>
                <tr>
                  <th>রক্তের গ্রুপ</th>
                  <td>{{ ($application->blood_group != null)? $application->blood_group: "" }}</td>
                </tr>
                <tr>
                  <th>লিঙ্গ</th>
                  <td>{{ $application->gender }}</td>
                </tr>
                <tr>
                  <th>স্বামী/স্ত্রীর নাম</th>
                  <td>{{ $application->spouse }}</td>
                </tr>
                <tr>
                  <th>স্বামী/স্ত্রীর পেশা</th>
                  <td>{{ $application->spouse_profession }}</td>
                </tr>
                <tr>
                  <th>পিতার নাম</th>
                  <td>{{ $application->father }}</td>
                </tr>
                <tr>
                  <th>মাতার নাম</th>
                  <td>{{ $application->mother }}</td>
                </tr>
                <tr>
                  <th>আবেদন ফর্মের হার্ড কপি</th>
                  <td>
                    <center>
                      @if($application->application_hard_copy != null)
                        <img src="{{ asset('images/users/'.$application->application_hard_copy)}}"
                             alt="application hard copy of {{ $application->name }}"
                             class="img-responsive shadow"
                             style="max-width: 200px; height: auto;"/>
                      @endif
                    </center>
                  </td>
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
                  <td>{{ $application->profession }}</td>
                </tr>
                <tr>
                  <th>আবেদনকারীর পদবি</th>
                  <td>{{ $application->position->name }}</td>
                </tr>
                <tr>
                  <th>দপ্তরের নাম</th>
                  <td>{{ $application->branch->name }}</td>
                </tr>
                <tr>
                  <th>চাকুরীতে যোগদানের তারিখ</th>
                  <td>
                    @if($application->joining_date != null)
                      {{ date('F d, Y', strtotime($application->joining_date)) }}
                    @else
                      N/A
                    @endif

                  </td>
                </tr>
                <tr>
                  <th>চাকুরি থেকে অবসরের তারিখ</th>
                  <td>
                    {{($application->prl_date != null)? date('F d, Y', strtotime($application->prl_date)): ""}}
                  </td>
                </tr>
                <tr>
                  <th colspan="2">
                    <center>যোগাযোগ</center>
                  </th>
                </tr>
                <tr>
                  <th>বর্তমান ঠিকানা</th>
                  <td>{{ $application->present_address }}</td>
                </tr>
                <tr>
                  <th>স্থায়ী ঠিকানা</th>
                  <td>{{ $application->permanent_address }}</td>
                </tr>
                <tr>
                  <th>অফিসের টেলিফোন</th>
                  <td>{{ $application->office_telephone }}</td>
                </tr>
                <tr>
                  <th>বাসার টেলিফোন</th>
                  <td>{{ $application->home_telephone }}</td>
                </tr>
                <tr>
                  <th>মোবাইল</th>
                  <td>{{ $application->mobile }}</td>
                </tr>
                <tr>
                  <th>ইমেইল এড্রেস</th>
                  <td>{{ $application->email }}</td>
                </tr>
                <tr>
                  <th>স্বাক্ষর</th>
                  <td>
                    <center>
                      @if($application->digital_signature != null)
                        <img src="{{ asset('images/users/'.$application->digital_signature)}}"
                             alt="digital signature of {{ $application->name }}"
                             class="img-responsive shadow"
                             style="max-width: 200px; height: auto;"/>
                      @endif
                    </center>
                  </td>
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
                      @if($application->nominee_one_image != null)
                          <img src="{{ asset('images/users/'.$application->nominee_one_image)}}" alt="image of {{ $application->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $application->nominee_one_name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                <tr>
                  <th width="40%">নমিনীর নাম (বাংলায়)</th>
                  <td>{{ $application->nominee_one_name }}</td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>
                    {{ $application->nominee_one_identity_text }}
                    @if($application->nominee_one_identity_type == 0)
                      (জাতীয় পরিচয়পত্র)
                    @else
                      (জন্ম নিবন্ধন)
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>
                    সম্পর্ক
                  </th>
                  <td>{{ $application->nominee_one_relation }}</td>
                </tr>
                <tr>
                  <th>শতকরা হার</th>
                  <td>{{ $application->nominee_one_percentage }}%</td>
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
                      @if($application->nominee_two_image != null)
                          <img src="{{ asset('images/users/'.$application->nominee_two_image)}}" alt="image of {{ $application->name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @else
                          <img src="{{ asset('images/user.png')}}" alt="image of {{ $application->nominee_two_name }}" class="img-responsive shadow" style="max-width: 200px; height: auto;" />
                      @endif
                    </center>
                  </td>
                </tr>
                <tr>
                  <th width="40%">নমিনীর নাম (বাংলায়)</th>
                  <td>{{ $application->nominee_two_name }}</td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>
                    {{ $application->nominee_two_identity_text }}
                    @if($application->nominee_two_identity_type == 0)
                      (জাতীয় পরিচয়পত্র)
                    @else
                      (জন্ম নিবন্ধন)
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>পরিচয় সংক্রান্ত দলিল</th>
                  <td>{{ $application->nominee_two_relation }}</td>
                </tr>
                <tr>
                  <th>শতকরা হার</th>
                  <td>{{ $application->nominee_two_percentage }}%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="tab-pane" id="membership_payment_tab">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>পরিমাণ</th>
                <th>ব্যাংক</th>
                <th>ব্রাঞ্চ/ শাখা</th>
                <th>পে-স্লিপ নম্বর</th>
                <th>
                  Action
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>৳ {{ $application->application_payment_amount }}</td>
                <td>{{ $application->application_payment_bank }}</td>
                <td>{{ $application->application_payment_branch }}</td>
                <td>{{ $application->application_payment_pay_slip }}</td>
                <td>
                  <button class="" data-toggle="modal" data-target="#membershipReceiptModal{{ $application->id }}" data-backdrop="static" title="দেখতে ক্লিক করুন">
                    @if($application->application_payment_receipt != null)
                        <img src="{{ asset('images/receipts/'.$application->application_payment_receipt)}}" alt="Receipt of membership payment {{ $application->name }}" class="img-responsive shadow" style="width: 100px; height: auto;" />
                    @else
                        ফাইল পাওয়া যায়নি!
                    @endif
                  </button>
                  <!-- Receipt Modal -->
                  <!-- Receipt Modal -->
                  <div class="modal fade" id="membershipReceiptModal{{ $application->id }}" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">ব্যাংক পে-স্লিপের ছবি</h4>
                        </div>
                        <div class="modal-body">
                          <span>ব্যাংক পে-স্লিপের ছবিঃ</span>
                          @if($application->application_payment_receipt != null)
                              <img src="{{ asset('images/receipts/'.$application->application_payment_receipt)}}" alt="Receipt of membership payment {{ $application->name }}" class="img-responsive shadow" style="width: 100%; height: auto;" />
                          @else
                              ফাইল পাওয়া যায়নি!
                          @endif
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Receipt Modal -->
                  <!-- Receipt Modal -->
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
@stop

@section('js')

@stop
