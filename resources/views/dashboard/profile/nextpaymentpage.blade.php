@extends('adminlte::page')

@section('title', 'CVCS | সদস্য অনলাইন পরিশোধ')

@section('css')
  {!!Html::style('css/parsley.css')!!}
  <style type="text/css">
    .blinking_trx_id_text {
      animation: blinker 1s step-start infinite;
    }

    @keyframes blinker {
      50% {
        opacity: 0;
      }
    }
  </style>
@stop

@section('content_header')
    <h1>
      অনলাইন পরিশোধ (শুধু নিজের)
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role_type != 'admin')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-file-text-o"></i>
          <h3 class="box-title">পরিশোধ ফরম</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <center>
              {{-- @php
                $trxid = 'CVCS' . strtotime('now') . random_string(5);
              @endphp --}}
              <h3 class="margin-two">অনুগ্রহ করে <b><u>৳{{ $amount }}</u></b> পেমেন্ট গেটওয়ের মাধ্যমে পরিশোধ করুন</h3>
              <h4>CVCS Trx_ID: <span style="color: #008D4C;"><b>{{ $trxid }}</b></span> <span class="blinking_trx_id_text">(পেমেন্টজনিত জটিলতা এড়াতে নম্বরটি সংরক্ষণ করুন)</span></h4>
              <h4>কারিগরি সমস্যার কারণে সাময়িক সময়ের জন্য বিকাশ পেমেন্ট করতে গ্রাহককে নিরুৎসাহিত করা হচ্ছে</h4>
              <div style="border: 2px solid #ddd; padding: 0px; width: 100%; padding: 10px;">
                  <img src="{{ asset('images/aamarpay.png') }}" class="img-responsive margin-two">
                  {!! 
                  aamarpay_post_button([
                      'tran_id'  => $trxid,
                      'cus_name'  => $member->name,
                      'cus_email' => $member->email,
                      'cus_phone' => $member->mobile,
                      'desc' => 'Monthly Fee',
                      'opt_a' => $member->member_id,
                      'opt_b' => $amount
                  ], $amount, '<i class="fa fa-money"></i> Pay Through AamarPay', 'btn btn-success') !!}
              </div>
          </center>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
  @endif
@stop

@section('js')
  {{-- {!!Html::script('js/parsley.min.js')!!}
  <script type="text/javascript">
    $(document).ready( function() {

      $('form').submit(function() {
        $('#submitBtn').attr('disabled', true);
      });

      $('#amount').blur(function() {
        var value = $('#amount').val();
        if(value == '') {
          if($(window).width() > 768) {
            toastr.info('পরিমাণ ৩০০ বা এর থেকে বেশি দিন', 'INFO').css('width', '400px');
          } else {
            toastr.info('পরিমাণ ৩০০ বা এর থেকে বেশি দিন', 'INFO').css('width', ($(window).width()-25)+'px');
          }
          $('#submitBtn').attr('disabled', false);
        } else {
          $('#submitBtn').attr('disabled', true);
        }
        if(value < 300) {
          if($(window).width() > 768) {
            toastr.info('পরিমাণ ৩০০ বা এর থেকে বেশি দিন', 'INFO').css('width', '400px');
          } else {
            toastr.info('পরিমাণ ৩০০ বা এর থেকে বেশি দিন', 'INFO').css('width', ($(window).width()-25)+'px');
          }
          $('#submitBtn').attr('disabled', true);
        } else {
          $('#submitBtn').attr('disabled', false);
        }
      })
    });
  </script> --}}
@stop