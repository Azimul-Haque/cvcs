@extends('adminlte::page')

@section('title', 'CVCS | আবেদিত পরিশোধ')

@section('css')

@stop

@section('content_header')
    <h1>
      আবেদিত পরিশোধসমূহ
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
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
        @foreach($payments as $payment)
        <tr>
          <td>
            পরিশোধকারীঃ
            @if(($payment->payment_type == 2) && ($payment->payment_status == 0))
              একাধিক
            @else
              <a href="{{ route('dashboard.singlemember', $payment->user->unique_key) }}">{{ $payment->user->name_bangla }}</a>
              <small>ID: {{ $payment->user->member_id }}, ☎ {{ $payment->user->mobile }}</small>
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
              <span class="badge badge-danger"><i class="fa fa-hourglass-start"></i> প্রক্রিয়াধীন</span>
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
            @if($payment->payment_type == 2)
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
            <button class="btn btn-sm btn-primary btn-with-count" data-toggle="modal" data-target="#seeReceiptModal{{ $payment->id }}" data-backdrop="static" title="রিসিট সংযুক্তি দেখুন"><i class="fa fa-paperclip"></i> <span class="badge">{{ count($payment->paymentreceipts) }}</span></button>
            <!-- See Receipts Modal -->
            <!-- See Receipts Modal -->
            <div class="modal fade" id="seeReceiptModal{{ $payment->id }}" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-paperclip"></i> পরিশোধ সংযুক্তি</h4>
                  </div>
                  <div class="modal-body">
                    পে-স্লিপ নম্বরঃ {{ $payment->pay_slip }}
                    @if(count($payment->paymentreceipts) > 0)
                      @foreach($payment->paymentreceipts as $paymentreceipt)
                        <img src="{{ asset('images/receipts/'. $paymentreceipt->image) }}" alt="Receipt Image" class="img-responsive" style=""><br/>
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
            @if(Auth::user()->email != 'dataentry@cvcsbd.com')
              <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#approvePaymentModal{{ $payment->id }}" data-backdrop="static" title="অনুমোদন করুন"><i class="fa fa-check"></i></button>
              <!-- Approve Payment Modal -->
              <!-- Approve Payment Modal -->
              <div class="modal fade" id="approvePaymentModal{{ $payment->id }}" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header modal-header-success">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-check"></i> পরিশোধ অনুমোদন</h4>
                    </div>
                    <div class="modal-body">
                      <big>আপনি কী নিশ্চিতভাবে এই পরিশোধটি অনুমোদন করতে চান?</big><br/>
                      <strong>জমাদানকারীঃ</strong> {{ $payment->user->name_bangla }}<br/>
                      <strong>পরিমাণঃ</strong> ৳ {{ $payment->amount }}<br/>
                      <strong>ব্যাংকঃ</strong> {{ $payment->bank }}<br/>
                      <strong>ব্রাঞ্চঃ</strong> {{ $payment->branch }}<br/>
                      <strong>পে স্লিপ</strong> {{ $payment->pay_slip }}<br/>
                      <strong>সময়কালঃ</strong> {{ date('F d, Y h:i A', strtotime($payment->created_at)) }}<br/><br/>
                      @if($payment->payment_type == 2)
                        <big>সদস্য অনুযায়ী পরিশোধের হিসাবঃ</big>
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
                      @endif
                    </div>
                    <div class="modal-footer">
                      @if($payment->payment_type == 1)
                        {!! Form::model($payment, ['route' => ['dashboard.approvesinglepayment', $payment->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                      @else
                        {!! Form::model($payment, ['route' => ['dashboard.approvebulkpayment', $payment->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                      @endif
                          {{-- {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!} --}}
                          <input class="btn btn-success" id="submitbtn{{ $payment->id }}" onclick="hideButtonImmedietely({{ $payment->id }})"  type="submit" value="দাখিল করুন"> 
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
              <!-- Approve Payment Modal -->
              <!-- Approve Payment Modal -->
            @endif
            
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#disputePaymentModal{{ $payment->id }}" data-backdrop="static" title="অনিষ্পন্ন করুন"><i class="fa fa-exclamation-triangle"></i></button>
            <!-- Dispute Payment Modal -->
            <!-- Dispute Payment Modal -->
            <div class="modal fade" id="disputePaymentModal{{ $payment->id }}" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> পরিশোধ অনিষ্পন্ন</h4>
                  </div>
                  <div class="modal-body">
                    <big>আপনি কী নিশ্চিতভাবে এই পরিশোধটি অনিষ্পন্ন করতে চান?</big><br/>
                    <strong>জমাদানকারীঃ</strong> {{ $payment->user->name_bangla }}<br/>
                    <strong>পরিমাণঃ</strong> ৳ {{ $payment->amount }}<br/>
                    <strong>ব্যাংকঃ</strong> {{ $payment->bank }}<br/>
                    <strong>ব্রাঞ্চঃ</strong> {{ $payment->branch }}<br/>
                    <strong>পে স্লিপ</strong> {{ $payment->pay_slip }}<br/>
                    <strong>সময়কালঃ</strong> {{ date('F d, Y h:i A', strtotime($payment->created_at)) }}<br/><br/>
                    @if($payment->payment_type == 2)
                      <big>সদস্য অনুযায়ী পরিশোধের হিসাবঃ</big>
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
                    @endif
                  </div>
                  <div class="modal-footer">
                        {!! Form::model($payment, ['route' => ['dashboard.disputepayment', $payment->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                        {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Dispute Payment Modal -->
            <!-- Dispute Payment Modal -->
            {{-- <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $payment->id }}" data-backdrop="static"><i class="fa fa-trash-o"></i></button> --}}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $payments->links() }}
@stop

@section('js')
    <script type="text/javascript">
      function hideButtonImmedietely(paymentID) {
        $('#submitbtn' + paymentID).hide();
      }
    </script>
@stop