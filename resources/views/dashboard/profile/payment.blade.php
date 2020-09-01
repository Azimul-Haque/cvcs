@extends('adminlte::page')

@section('title', 'CVCS | পরিশোধ')

@section('css')
  <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
@stop

@section('content_header')
    <h1>
      পরিশোধ
      <div class="pull-right">
        @if(Auth::user()->activation_status == 0)
          
        @else
          @if(Auth::user()->role_type != 'admin')
          <a class="btn btn-primary" href="{{ route('dashboard.memberpaymentself') }}" title="টাকা পরিশোধ করুন"><i class="fa fa-fw fa-user" aria-hidden="true"></i> পরিশোধ করুন</a>
          @endif
        @endif
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->activation_status == 0)
    <p class="text-danger">আপনার একাউন্টটি এখনও প্রক্রিয়াধীন রয়েছে। অনুমোদিত হলে আপনাকে SMS-এ জানানো হবে। একাউন্টটি সচল হলে এই পাতার সকল তথ্য ব্যবহার করতে পারবেন।</p>
  @else
    @if(Auth::user()->role_type != 'admin')
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
              @elseif($payment->payment_status == 1)
                <span class="badge badge-success"><i class="fa fa-check"></i>অনুমোদিত</span>
              @elseif($payment->payment_status == 2)
                <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i>অনিষ্পন্ন</span>
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
            <td>{{ date('F d, Y H:i A', strtotime($payment->created_at)) }}</td>
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
              <button class="btn btn-sm btn-primary btn-with-count" data-toggle="modal" data-target="#seeReceiptModal{{ $payment->id }}" data-backdrop="static" title="রিসিট সংযুক্তি দেখুন"><i class="fa fa-paperclip"></i> <span class="badge">{{ $payment->paymentreceipts->count() }}</span></button>
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
          @endforeach
        </tbody>
      </table>
    </div>
    {{ $payments->links() }}
    @endif
  @endif
@stop

@section('js')

@stop