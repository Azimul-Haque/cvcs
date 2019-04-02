@extends('adminlte::page')

@section('title', 'CVCS | সদস্য তথ্য')

@section('css')

@stop

@section('content_header')
    <h1>
      সদস্য তথ্য
      <div class="pull-right">
        <button class="btn btn-warning" data-toggle="modal" data-target="#sendMessageModal" data-backdrop="static" title="বার্তা পাঠান"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i></button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteMemberModal" data-backdrop="static" title="সদস্য মুছে ফেলুন" disabled=""><i class="fa fa-fw fa-trash" aria-hidden="true"></i></button>
      </div>
    </h1>

    <!-- Send Message Modal -->
    <!-- Send Message Modal -->
    <div class="modal fade" id="sendMessageModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-warning">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-envelope"></i> জনাব {{ $member->name_bangla }}-কে বার্তা পাঠান</h4>
          </div>
          {!! Form::open(['route' => 'dashboard.sendsmsapplicant', 'method' => 'POST', 'class' => 'form-default']) !!}
          <div class="modal-body">
            {!! Form::hidden('unique_key', $member->unique_key) !!}
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

    <!-- Delete Member Modal -->
    <!-- Delete Member Modal -->
          {{-- <div class="modal fade" id="deleteMemberModal" role="dialog">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header modal-header-danger">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-trash"></i> জনাব {{ $member->name_bangla }}-এর সদস্যপদ মুছে ফেলুন</h4>
                </div>
                <div class="modal-body">
                  আপনি কি নিশ্চিতভাবে সদস্যপদ মুছে ফেলতে চান?
                </div>
                <div class="modal-footer">
                  {!! Form::model($member, ['route' => ['dashboard.deleteapplication', $member->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                      {!! Form::submit('মুছে ফেলুন', array('class' => 'btn btn-danger')) !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div> --}}
    <!-- Delete Member Modal -->
    <!-- Delete Member Modal -->
@stop

@section('content')
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#personal_info_tab" data-toggle="tab" aria-expanded="false">ব্যক্তিগত তথ্য</a></li>
      <li class=""><a href="#mominee_tab" data-toggle="tab" aria-expanded="false">নমিনি সংক্রান্ত</a></li>
      <li class=""><a href="#payment_tab" data-toggle="tab" aria-expanded="true">পরিশোধ সংক্রান্ত</a></li>
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
                <tr>
                  <th width="40%">সদস্যপদ নং</th>
                  <td>{{ $member->member_id }}</td>
                </tr>
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
                  <th>দপতের নাম</th>
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
      <div class="tab-pane" id="payment_tab">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>পরিশোধকারী</th>
                <th>জমাদানকারী</th>
                <th>পেমেন্ট আইডি</th>
                <th>পেমেন্ট স্ট্যাটাস</th>
                <th>পেমেন্ট টাইপ</th>
                <th>পরিমাণ</th>
                <th>ব্যাংক</th>
                <th>ব্রাঞ্চ</th>
                <th>সময়কাল</th>
                <th width="10%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($member->payments as $payment)
              <tr>
                <td>
                <a href="{{ route('dashboard.singlemember', $payment->user->unique_key) }}">{{ $payment->user->name_bangla }}</a>
                </td>
                <td>
                  <a href="{{ route('dashboard.singlemember', $payment->payee->unique_key) }}">{{ $payment->payee->name_bangla }}</a>
                </td>
                <td>{{ $payment->payment_key }}</td>
                <td>
                  @if($payment->payment_status == 0)
                    <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> প্রক্রিয়াধীন</span>
                  @else
                    <span class="badge badge-success"><i class="fa fa-check"></i>অনুমোদিত</span>
                  @endif
                </td>
                <td>
                  @if($payment->payment_type == 1)
                    <b>SINGLE</b>
                  @elseif($payment->payment_type == 2)
                    <b>BULK</b>
                  @endif
                </td>
                <td align="right">{{ $payment->amount }} ৳</td>
                <td>{{ $payment->bank }}</td>
                <td>{{ $payment->branch }}</td>
                <td>{{ date('F d, Y H:i A', strtotime($payment->created_at)) }}</td>
                <td>
                  <button class="btn btn-sm btn-primary btn-with-count" data-toggle="modal" data-target="#seeReceiptModal" data-backdrop="static" title="রিসিট সংযুক্তি দেখুন"><i class="fa fa-eye"></i> <span class="badge">{{ count($payment->paymentreceipts) }}</span></button>
                  <!-- See Receipts Modal -->
                  <!-- See Receipts Modal -->
                  <div class="modal fade" id="seeReceiptModal" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header modal-header-success">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title"><i class="fa fa-paperclip"></i> পরিশোধ সংযুক্তি</h4>
                        </div>
                        <div class="modal-body">
                          @if(count($payment->paymentreceipts) > 0)
                            @foreach($payment->paymentreceipts as $paymentreceipt)
                              <img src="{{ asset('images/receipts/'. $paymentreceipt->image) }}" alt="Album Image" class="img-responsive" style="max-height: 200px; width: auto;"><br/>
                            @endforeach
                          @endif
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- See Receipts Modal -->
                  <!-- See Receipts Modal -->
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="membership_payment_tab">
        @if($member->application_payment_receipt != null)
            <img src="{{ asset('images/receipts/'.$member->application_payment_receipt)}}" alt="Receipt of membership payment {{ $member->name }}" class="img-responsive shadow" style="width: 100%; height: auto;" />
        @else
            ফাইল পাওয়া যায়নি!
        @endif
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
@stop

@section('js')

@stop