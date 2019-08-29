@extends('adminlte::page')

@section('title', 'CVCS | নোটিফিকেশনসমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
      নোটিফিকেশনসমূহ (মোট {{ $notifcount }} টি)
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow">
          <div class="widget-user-image">
            <img class="img-circle" src="{{ asset('images/custom2.png') }}" alt="User Avatar">
          </div>
          <!-- /.widget-user-image -->
          <h3 class="widget-user-username">সিভিসিএস</h3>
          <h5 class="widget-user-desc">কাস্টমস এন্ড ভ্যাট কর্মকর্তা-কর্মচারী সমবায় সমিতি (সিভিসিএস) লিমিটেড</h5>
        </div>
        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            @if($notifpendingapplications > 0)
              <li>
                <a href="{{ route('dashboard.applications') }}">
                  <i class="fa fa-users text-aqua"></i> নিবন্ধন আবেদন
                  <span class="pull-right badge bg-aqua">{{ $notifpendingapplications }} জন</span>
                </a>
              </li>
            @endif

            @if($notifdefectiveapplications > 0)
              <li>
                <a href="{{ route('dashboard.defectiveapplications') }}">
                  <i class="fa fa-exclamation-triangle text-maroon"></i> অসম্পূর্ণ আবেদন
                  <span class="pull-right badge bg-aqua">{{ $notifdefectiveapplications }} টি</span>
                </a>
              </li>
            @endif

            @if($notifpendingpayments > 0)
              <li>
                <a href="{{ route('dashboard.memberspendingpayments') }}">
                  <i class="fa fa-hourglass-start text-yellow"></i> প্রক্রিয়াধীন পরিশোধ
                  <span class="pull-right badge bg-yellow">{{ $notifpendingpayments }} টি</span>
                </a>
              </li>
            @endif

            @if($notiftempmemdatas > 0)
              <li>
                <a href="{{ route('dashboard.membersupdaterequests') }}">
                  <i class="fa fa-pencil-square-o text-green"></i> তথ্য হালনাগাদ অনুরোধ
                  <span class="pull-right badge bg-green">{{ $notiftempmemdatas }} টি</span>
                </a>
              </li>
            @endif 
          </ul>
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')

@stop