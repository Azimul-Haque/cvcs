@extends('adminlte::page')

@section('title', 'CVCS | লেনদেন বিবরণ')

@section('content_header')
    <h1><i class="fa fa-pic"></i> লেনদেন বিবরণ</h1>
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
		                    @if(empty($membertotalpending->totalamount))
		                    0.00
		                    @else
		                    {{ $membertotalpending->totalamount }}
		                    @endif
		                  </span>
		                  <span class="info-box-text">জানুয়ারি ২০১৯ থেকে{{-- {{ date('F, Y') }} --}}</span>
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
		                    @if(empty($membertotalapproved->totalamount))
		                    0.00
		                    @else
		                    {{ $membertotalapproved->totalamount }}
		                    @endif
		                  </span>
		                  <span class="info-box-text">জানুয়ারি ২০১৯ থেকে{{-- {{ date('F, Y') }} --}}</span>
		                </div>
		                <!-- /.info-box-content -->
		            </div>
    			</div>
    		</div>
    	</div>
    	<div class="col-md-6"></div>
    </div>

    <div class="row">
    	<div class="col-md-6">
    		<h4>মাসিক পরিশোধের হিসাব</h4>
    		<div class="table-responsive">
    			<table class="table">
    				<thead>
    					<tr>
    						<th>মাস</th>
    						<th>পরিশোধ</th>
    						<th>পরিমাণ</th>
    					</tr>
    				</thead>
    				<tbody>
    					
    				
    		@php
    			$startyear = 2019;
    			$today = date("Y-m-d H:i:s");
    			$approvedcash = $membertotalapproved->totalamount - 5000; // without the membership money;
    		@endphp

    		@for($i=$startyear; $i <= date('Y'); $i++)
    			@for($j=1; $j <= 12; $j++) {{--  strtotime("11-12-10") --}}
    				@php
    					$thismonth = '01-'.$j.'-'.$i;
    				@endphp

    				{{-- main calculation happens here --}}
    				{{-- @if(date('Y-m-d H:i:s', strtotime($thismonth)) < $today) --}}
    					<tr>
    						<td>{{ date('F Y', strtotime($thismonth)) }}</td>
    						<td>
    							@if($approvedcash/500 > 0)
    								<span class="badge badge-success"><i class="fa fa-check"></i>পরিশোধিত</span>
    							@elseif(date('Y-m-d H:i:s', strtotime($thismonth)) < $today)
    								<span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> পরিশোধনীয়</span>
    							@endif
    						</td>
    						<td>
    							@if($approvedcash/500 > 0)
    								৳ 500
    							@endif
    						</td>
    					</tr>
    					@php
    						$approvedcash = $approvedcash - 500;
    					@endphp
    				{{-- @endif --}}

    			@endfor
    		@endfor
    				</tbody>
    			</table>
    		</div>
    	</div>
    	<div class="col-md-6"></div>
    </div>
@stop