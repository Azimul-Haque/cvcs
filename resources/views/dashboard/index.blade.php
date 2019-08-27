@extends('adminlte::page')

@section('title', 'CVCS | ড্যাশবোর্ড')

@section('content_header')
    <h1><i class="fa fa-pic"></i> ড্যাশবোর্ড</h1>
@stop

@section('content')
	{{-- 1st line --}}
    <div class="row">
    	<div class="col-md-3">
    		<div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-load-a"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">প্রক্রিয়াধীন সদস্যপদবাবদ পরিশোধ</span>
                  <span class="info-box-number">
                    ৳ 
                    @if(empty($totalapplicationpending->totalamount))
                    0.00
                    @else
                    {{ $totalapplicationpending->totalamount }}
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
	            <span class="info-box-icon bg-blue"><span class="ion ion-load-d"></span></span>

	            <div class="info-box-content">
	              <span class="info-box-text">প্রক্রিয়াধীন পরিশোধ সংখ্যা</span>
	              <span class="info-box-number"> 
	                @if(empty($pendingpayments))
	                0
	                @else
	                {{ $pendingpayments }}
	                @endif
	                টি
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

    {{-- 2nd line --}}
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
	            <span class="info-box-icon bg-red"><span class="ion ion-ios-people-outline"></span></span>

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
	            <span class="info-box-icon bg-blue"><span class="ion ion-trophy"></span></span>

	            <div class="info-box-content">
	              <span class="info-box-text">সর্বমোট ডোনেশন</span>
	              <span class="info-box-number"> 
	                ৳
	                @if(empty($totaldonation->totalamount))
	                0.00
	                @else
	                {{ $totaldonation->totalamount }}
	                @endif
	              </span>
	              <span class="info-box-text">ডোনার সংখ্যাঃ {{ $totaldonors }}</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
		</div>
		<div class="col-md-3">
			<div class="info-box">
	            <span class="info-box-icon bg-yellow"><i class="ion ion-usb"></i></span>

	            <div class="info-box-content">
	              <span class="info-box-text">সর্বমোট বিল অব এন্ট্রি</span>
	              <span class="info-box-number"> 
	                ৳
	                @if(empty($totalbranchpayment->totalamount))
	                0.00
	                @else
	                {{ $totalbranchpayment->totalamount }}
	                @endif
	              </span>
	              <span class="info-box-text">ব্রাঞ্চ সংখ্যাঃ {{ $totalbranches }}</span>
	            </div>
	            <!-- /.info-box-content -->
	        </div>
		</div>
    </div>

    <div class="row">
		<div class="col-md-6">
		    <div class="box box-success" style="position: relative; left: 0px; top: 0px;">
		        <div class="box-header ui-sortable-handle" style="">
		          <i class="fa fa-calculator"></i>

		          <h3 class="box-title">মাসভিত্তিক মোট পরিশোধ (অনুমোদিত)</h3>
		          <div class="box-tools pull-right text-muted">
		            সর্বশেষ বারো মাস {{-- {{ date('F Y') }} --}}
		          </div>
		        </div>
		        <!-- /.box-header -->
		        <div class="box-body">
		          <canvas id="myChartC"></canvas>
		        </div>
		        <!-- /.box-body -->
		    </div>
        </div>
    	<div class="col-md-3">
	        <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">সর্বশেষ নিবন্ধিত</h3>

                  <div class="box-tools pull-right">
                    {{-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button> --}}
                  </div>
                </div>
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
                </div>
                <div class="box-footer text-center">
                  <a href="{{ route('dashboard.members') }}" class="uppercase">সকল সদস্য দেখুন</a>
                </div>
            </div>
    	</div>
    	<div class="col-md-3">
	        <div class="box box-warning">
	            <div class="box-header with-border">
	              <h3 class="box-title">এসএমএস ব্যালেন্স</h3>

	              <div class="box-tools pull-right">
	                {{-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
	                </button> --}}
	              </div>
	            </div>
	            <div class="box-body">
	              <center>
	              	<h4><i class="fa fa-money"></i> 
	              		সর্বমোট এসএমএস ব্যালেন্সঃ 
	              		@if($notifsmsbalance > 0)
	              			৳ {{ $notifsmsbalance }}
	              		@endif
	              	</h4>
	              	<h4><i class="fa fa-envelope"></i> 
	              		সর্বমোট এসএমএসঃ 
	              		@if($notifsmsbalance > 0)
	              			{{ (int) ($notifsmsbalance/0.30) }} টি
	              		@endif
	              	</h4>
	              </center>
	            </div>
	            
	            <div class="box-footer text-center">
	              ভার্চুয়াল নাম্বারঃ 01708403978
	            </div>
	        </div>
    	</div>
    </div>
@stop

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	<script type="text/javascript">
      var ctx = document.getElementById('myChartC').getContext('2d');
      var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'line',
          // The data for our dataset
          data: {
              labels: {!! $monthsforchartc !!},
              datasets: [{
                  label: '',
                  borderColor: "#3e95cd",
                  fill: true,
                  data: {!! $totalsforchartc !!},
                  borderWidth: 2,
                  borderColor: "rgba(0,165,91,1)",
                  borderCapStyle: 'butt',
                  pointBorderColor: "rgba(0,165,91,1)",
                  pointBackgroundColor: "#fff",
                  pointBorderWidth: 1,
                  pointHoverRadius: 5,
                  pointHoverBackgroundColor: "rgba(0,165,91,1)",
                  pointHoverBorderColor: "rgba(0,165,91,1)",
                  pointHoverBorderWidth: 2,
                  pointRadius: 5,
                  pointHitRadius: 10,
              }]
          },
          // Configuration options go here
          options: {
            legend: {
                    display: false
            },
            elements: {
                line: {
                    tension: 0
                }
            }
          }
      });
  </script>
@stop