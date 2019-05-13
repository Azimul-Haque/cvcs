@extends('adminlte::page')

@section('title', 'CVCS | লেনদেন বিবরণ')

@section('content_header')
    <h1><i class="fa fa-bar-chart"></i> লেনদেন বিবরণ</h1>
@stop

@section('content')
    @if(Auth::user()->role_type != 'admin')
    <div class="row">
    	<div class="col-md-6">
    		<div class="row">
    			<div class="col-md-6">
    				<div class="info-box">
		                <span class="info-box-icon bg-green"><span class="ion ion-clock"></span></span>

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
		                <span class="info-box-icon bg-red"><span class="ion ion-android-checkbox-outline"></span></span>

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
            @php
                $startyear = 2019;
                $today = date("Y-m-d H:i:s");
                $approvedcash = $membertotalapproved->totalamount - 5000; // without the membership money;
                $totalyear = $startyear + ceil($approvedcash/(500 * 12)) - 1; // get total year
                if(date('Y') > $totalyear) {
                    $totalyear = date('Y');
                }
            @endphp
    		<div class="table-responsive">
    			<table class="table" id="montly-transaction-datatable"> {{-- eitaake datatable e convert krote hobe --}}
    				<thead>
    					<tr>
    						<th>মাস</th>
    						<th>পরিশোধ</th>
    						<th>পরিমাণ</th>
    					</tr>
    				</thead>
    				<tbody>
    		@for($i=$startyear; $i <= $totalyear; $i++)
    			@for($j=1; $j <= 12; $j++) {{--  strtotime("11-12-10") --}}
    				@php
    					$thismonth = '01-'.$j.'-'.$i;
    				@endphp
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
    			@endfor
    		@endfor
    				</tbody>
    			</table>
    		</div>
    	</div>
    	<div class="col-md-6"></div>
    </div>
    @endif
@stop

@section('js')
    <script type="text/javascript">
      $(function () {
        //$.fn.dataTable.moment('DD MMMM, YYYY hh:mm:ss tt');
        $('#montly-transaction-datatable').DataTable({
          'paging'      : true,
          'pageLength'  : 12,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : true,
          'order': [[ 0, "desc" ]],
           columnDefs: [
                  // { targets: [7], visible: true, searchable: false},
                  // { targets: '_all', visible: true, searchable: true },
                  { targets: [0], type: 'date'}
           ]
        });
        $('#payment-list-datatable_wrapper').removeClass( 'form-inline' );
      })
    </script>
@stop