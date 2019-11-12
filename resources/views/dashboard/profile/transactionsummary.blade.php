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
    	<div class="col-md-12">
    		<h4>মাসিক পরিশোধের হিসাব</h4>
            @if(Auth()->user()->joining_date == '' || Auth()->user()->joining_date == null || strtotime('31-01-2019') > strtotime(Auth()->user()->joining_date))
          @php
              $startyear = 2019;
              $today = date("Y-m-d H:i:s");
              $approvedcash = $membertotalmontlypaid->totalamount; // without the membership money;
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
        @else
          {{-- jodi date Jan 31, 2019 er beshi hoy --}}
          @php
              $startyear = date('Y', strtotime(Auth()->user()->joining_date));
              $startmonth = date('m', strtotime(Auth()->user()->joining_date));
              $today = date("Y-m-d H:i:s");
              $approvedcash = $membertotalmontlypaid->totalamount; // without the membership money;
              $endyear = $startyear + ceil($approvedcash/(500 * 12)); // get total year
              if(date('Y') > $endyear) {
                  $endyear = date('Y');
              }
              $totalyears = $endyear - $startyear;
              $totalmonths = ($totalyears * 12) + (12 - $startmonth + 1);
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
                @php
                  $thisyear = $startyear;
                  $fractionyearsmonths = $totalmonths % 12;
                  $fractionyearsmonthscount = $fractionyearsmonths;
                  $monthsarray = [];
                @endphp
                @for($i=1; $i <= $fractionyearsmonthscount; $i++)
                  @php
                    $monthsarray[] = '01-'.(12-$fractionyearsmonths + 1).'-'.$thisyear;

                    $fractionyearsmonths--; // this ends with 0;
                  @endphp
                @endfor

                @php
                  $leftmonths = $totalmonths - $fractionyearsmonthscount;
                  if($leftmonths > 0) {
                    $thisyear = $thisyear + 1;
                    for ($j=1; $j <= $leftmonths; $j++) { 
                      $thismonth = $j%12;
                      if($thismonth == 0) {
                        $thismonth = 12;
                      }
                      $monthsarray[] = '01-'.$thismonth.'-'.$thisyear;
                      if($j%12 == 0) {
                        $thisyear++;
                      }
                    }
                  }
                  
                @endphp
                @foreach($monthsarray as $month)
                  <tr>
                    <td>{{ date('F Y', strtotime($month)) }}</td>
                    <td>
                      @if($approvedcash/500 > 0)
                        <span class="badge badge-success"><i class="fa fa-check"></i>পরিশোধিত</span>
                      @elseif(date('Y-m-d H:i:s', strtotime($month)) < $today)
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
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
    	</div>
    	{{-- <div class="col-md-6"></div> --}}
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