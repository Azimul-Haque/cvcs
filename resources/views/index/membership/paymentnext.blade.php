@extends('layouts.index')
@section('title')
    CVCS | Member Application Payment
@endsection

@section('css')
  
@stop

@section('content')
  <section class="wow fadeIn bg-gray">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-sm-10 col-xs-11 center-col login-box xs-margin-top-twelve margin-bottom" id="presubmission_div">
          <h2 class="agency-title margin-two">
            অনলাইনে পরিশোধ করুন
          </h2>
          <center>
            @if($member->payment_status == 'Unpaid')
              <h3 class="margin-two">অনুগ্রহ করে <b><u>৳{{ ($member->application_payment_amount + ($member->application_payment_amount * 0.0170)) }}</u></b> পেমেন্ট গেটওয়ের মাধ্যমে পরিশোধ করুন</h3>
              <h4>
                CVCS Trx_ID: <span style="color: #008D4C;"><b>{{ $member->trxid }}</b></span>
                {{-- <span class="blinking_trx_id_text">(পেমেন্টজনিত জটিলতা এড়াতে নম্বরটি সংরক্ষণ করুন)</span> --}}
              </h4>
              {{-- <h4>কারিগরি সমস্যার কারণে সাময়িক সময়ের জন্য বিকাশ পেমেন্ট করতে গ্রাহককে নিরুৎসাহিত করা হচ্ছে</h4> --}}              
              <div style="border: 2px solid #ddd; padding: 0px; width: 100%; padding: 10px;" >
                  <img src="{{ asset('images/aamarpay.png') }}" class="img-responsive margin-two">
                  {!! 
                  aamarpay_post_button([
                      'tran_id'  => $member->trxid,
                      'cus_name'  => $member->name,
                      'cus_email' => $member->email,
                      'cus_phone' => $member->mobile,

                      'success_url' => route('payment.regsuccess'),
                      'fail_url' => route('index.application.payment', $member->id),
                      'cancel_url' => route('payment.regcancel', $member->id),

                      'desc' => 'Registration Fee',
                      'opt_a' => $member->id,
                      'opt_b' => ($member->application_payment_amount + ($member->application_payment_amount * 0.0170))
                  ], ($member->application_payment_amount + ($member->application_payment_amount * 0.0170)), '<i class="fa fa-money"></i> Pay Through AamarPay', 'btn btn-success') !!}
              </div>
            @else
              <h4>আপনার পেমেন্ট সম্পন্ন হয়েছে!</h4>
            @endif
          </center>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('js')

@endsection