@extends('adminlte::page')

@section('title', 'CVCS | অনিষ্পন্ন পরিশোধ')

@section('css')

@stop

@section('content_header')
    <h1>
      অনিষ্পন্ন পরিশোধসমূহ
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
            <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i>অনিষ্পন্ন</span>
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

@stop