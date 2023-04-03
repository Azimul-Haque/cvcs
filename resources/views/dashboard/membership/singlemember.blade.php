@extends('adminlte::page')

@section('title', 'CVCS | সদস্য তথ্য')

@section('css')
  {!!Html::style('css/parsley.css')!!}
  <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
@stop

@section('content_header')
    <h1>
      সদস্য তথ্য
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#downloadPDFModal" data-backdrop="static" title="সদস্য রিপোর্ট ডাউনলোড করুন" id="downloadPDFButton"><i class="fa fa-download"></i></button>
        <a class="btn btn-primary" href="{{ route('dashboard.singleapplicationedit', $member->unique_key) }}" title="সদস্য তথ্য সম্পাদনা করুণ"><i class="fa fa-edit"></i></a>
        <button class="btn btn-warning" data-toggle="modal" data-target="#sendMessageModal" data-backdrop="static" title="বার্তা পাঠান"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i></button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteMemberModal" data-backdrop="static" title="সদস্য মুছে ফেলুন" disabled=""><i class="fa fa-fw fa-trash" aria-hidden="true"></i></button>
      </div>
    </h1>
    <!-- Download Report PDF Modal -->
    <!-- Download Report PDF Modal -->
    <div class="modal fade" id="downloadPDFModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header modal-header-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-download"></i> সদস্য বিস্তারিত রিপোর্ট ডাউনলোড</h4>
          </div>
          {!! Form::open(['route' => 'dashboard.member.complete.pdf', 'method' => 'POST', 'class' => 'form-default']) !!}
          <div class="modal-body">
            সদস্য বিস্তারিত রিপোর্টটি ডাউনলোড করুন
            {!! Form::hidden('id', $member->id) !!}                      
            {!! Form::hidden('member_id', $member->member_id) !!}
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> ডাউনলোড করুন</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Download Report PDF Modal -->
    <!-- Download Report PDF Modal -->

    <!-- Send Message Modal -->
    <!-- Send Message Modal -->
    <div class="modal fade" id="sendMessageModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-warning">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-envelope"></i> জনাব/ জনাবা {{ $member->name_bangla }}-কে বার্তা পাঠান</h4>
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
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>
            {{-- @if(empty($pendingfordashboard->totalamount))
              0.00
            @else
              {{ $pendingfordashboard->totalamount }}
            @endif --}}
            @if(empty($approvedfordashboard->totalamount))
              0.00
            @else
              {{ $approvedfordashboard->totalamount }}
            @endif
            <sup style="font-size: 20px">৳</sup>
          </h3>

          <p>অনুমোদিত অর্থ</p>
        </div>
        <div class="icon">
          <i class="ion ion-cash"></i>
        </div>
        {{-- <a href="{{ route('dashboard.memberpayment') }}" class="small-box-footer">আরও দেখুন <i class="fa fa-arrow-circle-right"></i></a> --}}
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>
            @if(empty($totalpendingthiuser))
              0.00
            @else
              {{ $totalpendingthiuser }}
            @endif
            <sup style="font-size: 20px">৳</sup>
          </h3>

          <p>বকেয়া অর্থ</p>
        </div>
        <div class="icon">
          <i class="ion ion-loop"></i>
        </div>
        {{-- <a href="{{ route('dashboard.memberpayment') }}" class="small-box-footer">আরও দেখুন <i class="fa fa-arrow-circle-right"></i></a> --}}
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>
            @if(empty($pendingcountdashboard))
              0
            @else
              {{ $pendingcountdashboard }}
            @endif
            <sup style="font-size: 20px">টি</sup>
          </h3>

          <p>প্রক্রিয়াধীন পরিশোধ</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        {{-- <a href="{{ route('dashboard.memberpayment') }}" class="small-box-footer">আরও দেখুন <i class="fa fa-arrow-circle-right"></i></a> --}}
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>
            @if(empty($approvedcountdashboard))
              0
            @else
              {{ $approvedcountdashboard }}
            @endif
            <sup style="font-size: 20px">টি</sup>
          </h3>

          <p>অনুমোদিত পরিশোধ</p>
        </div>
        <div class="icon">
          <i class="ion ion-arrow-graph-up-right"></i>
        </div>
        {{-- <a href="{{ route('dashboard.memberpayment') }}" class="small-box-footer">আরও দেখুন <i class="fa fa-arrow-circle-right"></i></a> --}}
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#personal_info_tab" data-toggle="tab" aria-expanded="false">ব্যক্তিগত তথ্য</a></li>
      <li class=""><a href="#mominee_tab" data-toggle="tab" aria-expanded="false">নমিনি সংক্রান্ত</a></li>
      <li class=""><a href="#payment_tab" data-toggle="tab" aria-expanded="true">পরিশোধ সংক্রান্ত</a></li>
      <li class=""><a href="#monthly_transaction_tab" data-toggle="tab" aria-expanded="true">মাসিক লেনদেন</a></li>
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
                  <th width="40%">নাম (বাংলায়)</th>
                  <td>{{ $member->name_bangla }}</td>
                </tr>
                <tr>
                  <th>নাম (ইংরেজিতে)</th>
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
                  <th>মাতার নাম</th>
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
                  <th width="40%">পেশা</th>
                  <td>{{ $member->profession }}</td>
                </tr>
                <tr>
                  <th>পদবি</th>
                  <td>{{ $member->position->name }}</td>
                </tr>
                <tr>
                  <th>দপ্তরের নাম</th>
                  <td>{{ $member->branch->name }}</td>
                </tr>
                <tr>
                  <th>চাকুরীতে যোগদানের তারিখ</th>
                  <td>
                    @if($member->joining_date != null)
                      {{ date('F d, Y', strtotime($member->joining_date)) }}
                    @else
                      N/A
                    @endif
                    
                  </td>
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
                  <th>সম্পর্ক</th>
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
                <th>নাম</th>
                <th>ধরণ</th>
                <th>পে স্লিপ<br/>পেমেন্ট আইডি</th>
                <th>পেমেন্ট স্ট্যাটাস<br/>পেমেন্ট টাইপ</th>
                <th>পরিমাণ</th>
                <th>ব্যাংক<br/>ব্রাঞ্চ</th>
                <th>সময়কাল</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($member->payments->sortBy('created_at') as $payment)
                @if($payment->is_archieved == 0)
                  <tr>
                    <td>
                      পরিশোধকারীঃ
                      @if(($payment->payment_type == 2) && ($payment->payment_status == 0))
                        একাধিক
                      @else
                        <a href="{{ route('dashboard.singlemember', $payment->user->unique_key) }}">{{ $payment->user->name_bangla }}</a>
                      @endif
                      <br/>
                      জমাদানকারীঃ <a href="{{ route('dashboard.singlemember', $payment->payee->unique_key) }}">{{ $payment->payee->name_bangla }}</a>
                    </td>
                    <td>
                      @if($payment->payment_category == 0)
                        সদস্যপদ বাবদ
                      @else
                        মাসিক পরিশোধ
                      @endif
                    </td>
                    <td>{{ $payment->pay_slip }}<br/>{{ $payment->payment_key }}</td>
                    <td>
                      @if($payment->payment_status == 0)
                        <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> প্রক্রিয়াধীন</span>
                      @else
                        <span class="badge badge-success"><i class="fa fa-check"></i>অনুমোদিত</span>
                      @endif
                      <br/>
                      @if($payment->payment_type == 1)
                        <b>SINGLE</b>
                      @elseif($payment->payment_type == 2)
                        <b>BULK</b>
                      @endif
                    </td>
                    <td align="right">৳ {{ $payment->amount }}</td>
                    <td>{{ $payment->bank }}<br/>{{ $payment->branch }}</td>
                    <td>{{ date('F d, Y h:i A', strtotime($payment->created_at)) }}</td>
                    <td>
                      @if(($payment->payment_type == 2) && ($payment->payment_status == 0))
                        <button class="btn btn-sm btn-info btn-with-count" data-toggle="modal" data-target="#seeMembersWiseModal{{ $payment->id }}" data-backdrop="static" title="সদস্য অনুযায়ী বিস্তারিত দেখুন"><i class="fa fa-eye"></i></button>
                        <!-- See Memberwise Data Modal -->
                        <!-- See Memberwise Data Modal -->
                        <div class="modal fade" id="seeMembersWiseModal{{ $payment->id }}" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header modal-header-info">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><i class="fa fa-paperclip"></i> সদস্য অনুযায়ী পরিশোধ</h4>
                              </div>
                              <div class="modal-body">
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead>
                                      <tr>
                                        <th>সদস্য</th>
                                        <th>সদস্য আইডি</th>
                                        <th>ছবি</th>
                                        <th>পরিমাণ</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach(json_decode($payment->bulk_payment_member_ids) as $member_id => $amount)
                                        <tr>
                                          <td>{{ $members->where('member_id', $member_id)->first()->name_bangla }}</td>
                                          <td><big><b>{{ $member_id }}</b></big></td>
                                          <td><img src="{{ asset('images/users/'.$members->where('member_id', $member_id)->first()->image) }}" class="img-responsive" style="max-height: 70px; width: auto;"></td>
                                          <td>{{ $amount }}/-</td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- See Memberwise Data Modal -->
                        <!-- See Memberwise Data Modal -->
                      @endif
                      @if(($payment->payment_method != 1) & (count($payment->paymentreceipts) > 0))
                      <button class="btn btn-sm btn-primary btn-with-count" data-toggle="modal" data-target="#seeReceiptModal{{ $payment->id }}" data-backdrop="static" title="রিসিট সংযুক্তি দেখুন"><i class="fa fa-paperclip"></i> <span class="badge">{{ count($payment->paymentreceipts) }}</span></button>
                      <!-- See Receipts Modal -->
                      <!-- See Receipts Modal -->
                      <div class="modal fade" id="seeReceiptModal{{ $payment->id }}" role="dialog">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header modal-header-success">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-paperclip"></i> পরিশোধ সংযুক্তি</h4>
                            </div>
                            <div class="modal-body">
                              পে-স্লিপ নম্বরঃ {{ $payment->pay_slip }}
                              @if(count($payment->paymentreceipts) > 0)
                                @foreach($payment->paymentreceipts as $paymentreceipt)
                                  <img src="{{ asset('images/receipts/'. $paymentreceipt->image) }}" alt="Album Image" class="img-responsive" style=""><br/>
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
                      @endif

                      <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#downloadPDF{{ $payment->id }}" data-backdrop="static" title="রিপোর্ট ডাউনলোড করুন" id="downloadPDFButton{{ $payment->id }}"><i class="fa fa-download"></i></button>
                      <!-- Download PDF Modal -->
                      <!-- Download PDF Modal -->
                      <div class="modal fade" id="downloadPDF{{ $payment->id }}" role="dialog">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header modal-header-success">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title"><i class="fa fa-download"></i> পরিশোধ রিপোর্ট ডাউনলোড</h4>
                            </div>
                            {!! Form::open(['route' => 'dashboard.member.payment.pdf', 'method' => 'POST', 'class' => 'form-default']) !!}
                            <div class="modal-body">
                              পরিশোধ রিপোর্টটি ডাউনলোড করুন
                              {!! Form::hidden('id', $payment->id) !!}                      
                              {!! Form::hidden('payment_key', $payment->payment_key) !!}                      
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> ডাউনলোড করুন</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                            </div>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                      <!-- Download PDF Modal -->
                      <!-- Download PDF Modal -->
                      <script type="text/javascript">
                        $('#downloadPDFButton{{ $payment->id }}').click(function() {
                          setTimeout(function () {
                            $('#downloadPDF{{ $payment->id }}').modal('hide');
                          }, 3500);
                        })
                      </script>
                    </td>
                  </tr>
                @endif
              @endforeach
              <tr>
                <td>
                  পরিশোধকারীঃ
                  <a href="{{ route('dashboard.singlemember', $member->unique_key) }}">{{ $member->name_bangla }}</a>
                  <br/>
                  জমাদানকারীঃ <a href="{{ route('dashboard.singlemember', $payment->payee->unique_key) }}">{{ $payment->payee->name_bangla }}</a>
                </td>
                <td>
                  @if($payment->payment_category == 0)
                    সদস্যপদ বাবদ
                  @else
                    মাসিক পরিশোধ
                  @endif
                </td>
                <td>{{ $payment->pay_slip }}<br/>{{ $payment->payment_key }}</td>
                <td>
                  @if($payment->payment_status == 0)
                    <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> প্রক্রিয়াধীন</span>
                  @else
                    <span class="badge badge-success"><i class="fa fa-check"></i>অনুমোদিত</span>
                  @endif
                  <br/>
                  @if($payment->payment_type == 1)
                    <b>SINGLE</b>
                  @elseif($payment->payment_type == 2)
                    <b>BULK</b>
                  @endif
                </td>
                <td align="right">৳ {{ $payment->amount }}</td>
                <td>{{ $payment->bank }}<br/>{{ $payment->branch }}</td>
                <td>{{ date('F d, Y h:i A', strtotime($payment->created_at)) }}</td>
                <td>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="monthly_transaction_tab">
        @if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
          @php
              $startyear = 2019;
              $today = date("Y-m-d H:i:s");
              $approvedcash = $totalmontlypaid->totalamount; // without the membership money;
              $totalyear = $startyear + ceil($approvedcash/(300 * 12)) - 1; // get total year
              if(date('Y') > $totalyear) {
                  $totalyear = date('Y');
              }
          @endphp
          <div class="table-responsive">
            <table class="table" id="montly-transaction-datatable"> {{-- eitaake datatable e convert krote hobe --}}
              <thead>
                <tr>
                  <th>মাস</th>
                  <th>পরিশোধ</th>
                  <th>পরিমাণ</th>
                </tr>
              </thead>
              <tbody>
          @for($i=$startyear; $i <= $totalyear; $i++)
            @for($j=1; $j <= 12; $j++) {{--  strtotime("11-12-10") --}}
              @php
                $thismonth = '01-'.$j.'-'.$i;
              @endphp
                <tr>
                  <td>{{ date('F Y', strtotime($thismonth)) }}</td>
                  <td>
                    @if(floor($approvedcash/300) > 0)
                      <span class="badge badge-success"><i class="fa fa-check"></i>পরিশোধিত</span>
                    @elseif(date('Y-m-d H:i:s', strtotime($thismonth)) < $today)
                      <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> প্রদেয়</span>
                    @endif
                  </td>
                  <td>
                    @if(floor($approvedcash/300) > 0)
                      ৳ 300
                    @endif
                  </td>
                </tr>
                @php
                  $approvedcash = $approvedcash - 300;
                @endphp
            @endfor
          @endfor
              </tbody>
            </table>
          </div>
        @else
          {{-- jodi date Jan 31, 2019 er beshi hoy --}}
          @php
              $startyear = date('Y', strtotime($member->joining_date));
              $startmonth = date('m', strtotime($member->joining_date));
              $today = date("Y-m-d H:i:s");
              $approvedcash = $totalmontlypaid->totalamount; // without the membership money;
              $endyear = $startyear + ceil($approvedcash/(300 * 12)); // get total year
              if(date('Y') > $endyear) {
                  $endyear = date('Y');
              }
              $totalyears = $endyear - $startyear;
              $totalmonths = ($totalyears * 12) + (12 - $startmonth + 1);
          @endphp
          <div class="table-responsive">
            <table class="table" id="montly-transaction-datatable"> {{-- eitaake datatable e convert krote hobe --}}
              <thead>
                <tr>
                  <th>মাস</th>
                  <th>পরিশোধ</th>
                  <th>পরিমাণ</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $thisyear = $startyear;
                  $fractionyearsmonths = $totalmonths % 12;
                  $fractionyearsmonthscount = $fractionyearsmonths;
                  $monthsarray = [];
                @endphp
                @for($i=1; $i <= $fractionyearsmonthscount; $i++)
                  @php
                    $monthsarray[] = '01-'.(12-$fractionyearsmonths + 1).'-'.$thisyear;

                    $fractionyearsmonths--; // this ends with 0;
                  @endphp
                @endfor

                @php
                  $leftmonths = $totalmonths - $fractionyearsmonthscount;
                  if($leftmonths > 0) {
                    $thisyear = $thisyear + 1;
                    for ($j=1; $j <= $leftmonths; $j++) { 
                      $thismonth = $j%12;
                      if($thismonth == 0) {
                        $thismonth = 12;
                      }
                      $monthsarray[] = '01-'.$thismonth.'-'.$thisyear;
                      if($j%12 == 0) {
                        $thisyear++;
                      }
                    }
                  }
                  
                @endphp
                @foreach($monthsarray as $month)
                  <tr>
                    <td>{{ date('F Y', strtotime($month)) }}</td>
                    <td>
                      @if(floor($approvedcash/300) > 0)
                        <span class="badge badge-success"><i class="fa fa-check"></i>পরিশোধিত</span>
                      @elseif(date('Y-m-d H:i:s', strtotime($month)) < $today)
                        <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> প্রদেয়</span>
                      @endif
                    </td>
                    <td>
                      @if(floor($approvedcash/300) > 0)
                        ৳ 300
                      @endif
                    </td>
                  </tr>
                  @php
                    $approvedcash = $approvedcash - 300;
                  @endphp
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>
  <!-- nav-tabs-custom -->
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
    });
  </script>
  <script type="text/javascript">
    @if(session('warning'))
        $('#editProfileModal').modal('show');
    @endif
  </script>
  <script type="text/javascript">
    $(function () {
      //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
      $('#montly-transaction-datatable').DataTable({
        'paging'      : true,
        'pageLength'  : 12,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'order': [[ 0, "desc" ]],
         columnDefs: [
                // { targets: [7], visible: true, searchable: false},
                // { targets: '_all', visible: true, searchable: true },
                { targets: [0], type: 'date'}
         ]
      });
      $('#payment-list-datatable_wrapper').removeClass( 'form-inline' );
    })
  </script>
  <script type="text/javascript">
    $('#downloadPDFButton').click(function() {
      setTimeout(function () {
        $('#downloadPDFModal').modal('hide');
      }, 3500);
    })
  </script>
@stop