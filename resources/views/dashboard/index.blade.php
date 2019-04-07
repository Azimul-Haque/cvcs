@extends('adminlte::page')

@section('title', 'CVCS | ড্যাশবোর্ড')

@section('content_header')
    <h1><i class="fa fa-pic"></i> ড্যাশবোর্ড</h1>
@stop

@section('content')
    <div class="row">
    	<div class="col-md-3">
			<div class="info-box">
	            <span class="info-box-icon bg-green"><i class="ion ion-clock"></i></span>

	            <div class="info-box-content">
	              <span class="info-box-text">প্রক্রিয়াধীন পরিশোধ</span>
	              <span class="info-box-number">
	                ৳ 
	                @if(empty($totalpending->totalamount))
	                0.00
	                @else
	                {{ $totalpending->totalamount }}
	                @endif
	              </span>
	              <span class="info-box-text">জানুয়ারি ২০১৯ থেকে{{-- {{ date('F, Y') }} --}}</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
		</div>
		<div class="col-md-3">
			<div class="info-box">
	            <span class="info-box-icon bg-red"><span class="ion ion-android-checkbox-outline"></span></span>

	            <div class="info-box-content">
	              <span class="info-box-text">অনুমোদিত পরিশোধ</span>
	              <span class="info-box-number">
	                ৳ 
	                @if(empty($totalapproved->totalamount))
	                0.00
	                @else
	                {{ $totalapproved->totalamount }}
	                @endif
	              </span>
	              <span class="info-box-text">জানুয়ারি ২০১৯ থেকে{{-- {{ date('F, Y') }} --}}</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
		</div>
		<div class="col-md-3">
			<div class="info-box">
	            <span class="info-box-icon bg-blue"><span class="ion ion-ios-people-outline"></span></span>

	            <div class="info-box-content">
	              <span class="info-box-text">নিবন্ধিত সদস্য</span>
	              <span class="info-box-number"> 
	                @if(empty($registeredmember))
	                0
	                @else
	                {{ $registeredmember }}
	                @endif
	                জন
	              </span>
	              <span class="info-box-text">জানুয়ারি ২০১৯ থেকে{{-- {{ date('F, Y') }} --}}</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
		</div>
		<div class="col-md-3">
			<div class="info-box">
	            <span class="info-box-icon bg-yellow"><i class="ion ion-stats-bars"></i></span>

	            <div class="info-box-content">
	              <span class="info-box-text">সফল পরিশোধ</span>
	              <span class="info-box-number"> 
	                @if(empty($successfullpayments))
	                0
	                @else
	                {{ $successfullpayments }}
	                @endif
	                টি
	              </span>
	              <span class="info-box-text">জানুয়ারি ২০১৯ থেকে{{-- {{ date('F, Y') }} --}}</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
		</div>
    </div>
@stop