@extends('adminlte::page')

@section('title', 'CVCS | অনুমোদিত পরিশোধ')

@section('css')

@stop

@section('content_header')
    <h1>
      অনুমোদিত পরিশোধসমূহ
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>পরিশোধকারী</th>
          <th>জমাদানকারী</th>
          <th>পে স্লিপ</th>
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
        @foreach($payments as $payment)
        <tr>
          <td>
            <a href="{{ route('dashboard.singlemember', $payment->user->unique_key) }}">{{ $payment->user->name_bangla }}</a>
          </td>
          <td>
            <a href="{{ route('dashboard.singlemember', $payment->payee->unique_key) }}">{{ $payment->payee->name_bangla }}</a>
          </td>
          <td>{{ $payment->pay_slip }}</td>
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
            <button class="btn btn-sm btn-primary btn-with-count" data-toggle="modal" data-target="#seeReceiptModal{{ $payment->id }}" data-backdrop="static" title="রিসিট সংযুক্তি দেখুন"><i class="fa fa-eye"></i> <span class="badge">{{ count($payment->paymentreceipts) }}</span></button>
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
                    পরিশোধ আইডিঃ {{ $payment->payment_key }}
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