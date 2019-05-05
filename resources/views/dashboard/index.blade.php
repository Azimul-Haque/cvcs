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

    <div class="row">
    	<div class="col-md-3"></div>
    	<div class="col-md-3"></div>
    	<div class="col-md-3">
	        <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">সর্বশেষ নিবন্ধিত</h3>

                  <div class="box-tools pull-right">
                    {{-- <span class="label label-primary">৬ জন সদস্য</span> --}}
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  	@foreach($lastsixmembers as $lastsixmember)
                  	<li>
                  	  <img src="{{ asset('images/users/'. $lastsixmember->image) }}" alt="User Image">
                  	  <a class="users-list-name" href="{{ route('dashboard.singlemember', $lastsixmember->unique_key) }}">{{ $lastsixmember->name_bangla }}</a>
                  	  <span class="users-list-date">{{ date('F d, Y', strtotime($lastsixmember->created_at)) }}</span>
                  	</li>
                  	@endforeach
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="{{ route('dashboard.members') }}" class="uppercase">সকল সদস্য দেখুন</a>
                </div>
                <!-- /.box-footer -->
            </div>
    	</div>
    	<div class="col-md-3"></div>
    </div>
@stop