@extends('adminlte::page')

@section('title', 'CVCS | ড্যাশবোর্ড')

@section('content_header')
    <h1><i class="fa fa-pic"></i> ড্যাশবোর্ড</h1>
@stop

@section('content')
    <div class="row">
    	<div class="col-md-6">
    		<div class="row">
    			<div class="col-md-6">
    				<div class="info-box">
		                <span class="info-box-icon bg-green"><span class="glyphicon glyphicon-hourglass"></span></span>

		                <div class="info-box-content">
		                  <span class="info-box-text">প্রক্রিয়াধীন পরিশোধ</span>
		                  <span class="info-box-number">
		                    ৳ 
		                    @if(empty($thismonthpending->totalamount))
		                    0.00
		                    @else
		                    {{ $thismonthpending->totalamount }}
		                    @endif
		                  </span>
		                  <span class="info-box-text">{{ date('F, Y') }}</span>
		                </div>
		                <!-- /.info-box-content -->
		            </div>
    			</div>
    			<div class="col-md-6">
    				<div class="info-box">
		                <span class="info-box-icon bg-red"><span class="glyphicon glyphicon-saved"></span></span>

		                <div class="info-box-content">
		                  <span class="info-box-text">অনুমোদিত পরিশোধ</span>
		                  <span class="info-box-number">
		                    ৳ 
		                    @if(empty($thismonthapproved->totalamount))
		                    0.00
		                    @else
		                    {{ $thismonthapproved->totalamount }}
		                    @endif
		                  </span>
		                  <span class="info-box-text">{{ date('F, Y') }}</span>
		                </div>
		                <!-- /.info-box-content -->
		            </div>
    			</div>
    		</div>
    	</div>
    	<div class="col-md-6"></div>
    </div>
@stop