<html>
<head>
  <title>Report | Download | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
  }

  table {
      border-collapse: collapse;
      width: 100%;
  }
  table, td, th {
      border: 1px solid black;
  }
  th, td{
    padding: 4px;
    font-family: 'kalpurush', sans-serif;
    font-size: 13px;
  }
  @page {
    header: page-header;
    footer: page-footer;
    background-image: url({{ public_path('images/cvcs_background.png') }});
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;
  }
  .graybackground {
    background: rgba(192,192,192, 0.7);
  }
  </style>
</head>
<body>
  <h2 align="center">
    <img src="{{ public_path('images/custom2.png') }}" style="height: 80px; width: auto;"><br/>
    কাস্টমস এন্ড ভ্যাট কো-অপারেটিভ সোসাইটি
  </h2>
  <p align="center" style="padding-top: -20px;">
    <span style="font-size: 20px;">'{{ bangla(date('F d, Y', strtotime($startdate))) }}' হতে '{{ bangla(date('F d, Y', strtotime($enddate))) }}' পর্যন্ত আদায়কৃত অর্থের হিসাব</span><br/>
  </p>
  
  <div class="" style="padding-top: -10px;">
    <table class="">
      <tr class="graybackground">
        <th width="7%">#</th>
        <th>সদস্য</th>
        <th>পদবি</th>
        <th width="">শেয়ার আমানত</th>
        <th width="">সঞ্চয় আমানত</th>
        <th width="">অগ্রিম</th>
        <th width="">মোট পরিশোধ</th>
      </tr>
      @php
        $counter = 1;
        $grandtotalshare = 0;
        $grandtotalpaid = 0;
        $grandtotaladvanced = 0;
        $grandtotal = 0;
      @endphp
      @foreach($payments as $payment)
        @if($payment->user)
          <tr>
            <td align="center">{{ bangla($counter) }}</td>
            <td>
              {{ $payment->user->joining_date > date('2019-01-01 00:00:00') ? 'Joining: ' . date('F, Y', strtotime($payment->user->joining_date)) : '' }}<br/>
              {{ $payment->user->name_bangla }}<br/>
              আইডিঃ {{ $payment->user->member_id }}
            </td>
            <td>
              {{ $payment->user->position->name }}
            </td>
            {{-- <td align="center">
              @if($payment->user->image != null && file_exists(public_path('images/users/'.$payment->user->image)))
                 <img src="{{ public_path('images/users/'.$payment->user->image)}}" style="height: 50px; width: auto;" />
              @else
                <img src="{{ public_path('images/user.png')}}" style="height: 50px; width: auto;" />
              @endif
            </td> --}}
            <td align="center">৳ ২,০০০</td>
            <td align="center">
              @php
                  $approvedcashformontly = $payment->totalamount - 2000;
                  $totalmonthsformember = 0;
                  $totalpaidmonthly = 0;
                  $totaladvancedmonthly = 0;
                  if($payment->user->joining_date == '' || $payment->user->joining_date == null || strtotime('31-01-2019') > strtotime($payment->user->joining_date)) {
                    // $from = Carbon::createFromFormat('Y-m-d', strtotime('2019-1-1'));
                    $from = Carbon\Carbon::parse('2019-1-1');
                    // $to = Carbon::createFromFormat('Y-m-d', strtotime($enddate));
                    $to = Carbon\Carbon::parse($enddate . '11:59:59');
                    echo $from . '<br/>';
                    echo $to . '<br/>';
                    $totalmonthsformember = $to->diffInDays($from);
                    if($approvedcashformontly - ($totalmonthsformember * 300) > 0) {
                      $totalpaidmonthly = $totalmonthsformember * 300;
                      $totaladvancedmonthly = $approvedcashformontly - ($totalmonthsformember * 300);
                    } else {
                      $totalpaidmonthly = $approvedcashformontly;
                      $totaladvancedmonthly = 0;
                    }
                  } else {
                    $startmonth = date('Y-m-', strtotime($payment->user->joining_date));
                    // $from = Carbon::createFromFormat('Y-m-d', strtotime($startmonth . '1'));
                    $from = Carbon\Carbon::parse($startmonth . '1');
                    // $to = Carbon::createFromFormat('Y-m-d', strtotime($enddate));
                    $to = Carbon\Carbon::parse($enddate . '11:59:59');
                    echo $from . '<br/>';
                    echo $to . '<br/>';
                    $totalmonthsformember = $to->diffInDays($from);
                    if($approvedcashformontly - ($totalmonthsformember * 300) > 0) {
                      $totalpaidmonthly = $totalmonthsformember * 300;
                      $totaladvancedmonthly = $approvedcashformontly - ($totalmonthsformember * 300);
                    } else {
                      $totalpaidmonthly = $approvedcashformontly;
                      $totaladvancedmonthly = 0;
                    }
                  }
              @endphp
              মোট মাসঃ {{ floor($totalmonthsformember/30) }}<br/>
              ৳ {{ bangla(local_currency($totalpaidmonthly)) }}
            </td>
            <td align="center">৳ {{ bangla(local_currency($totaladvancedmonthly)) }}</td>
            <td align="center">৳ {{ bangla(local_currency($payment->totalamount)) }}</td>
          </tr>
        @else
        <tr>
          <td align="center">{{ bangla($counter) }}</td>
          <td>ERROR: {{ $payment->member_id }}</td>
          <td></td>
          <td align="center">৳ ২,০০০</td>
          <td align="center">-</td>
          <td align="center">-</td>
          <td align="center">৳ {{ bangla($payment->totalamount) }}</td>
        </tr>
        @endif

        @php
          $counter++;
          $grandtotalshare = $grandtotalshare + 2000;
          $grandtotalpaid = $grandtotalpaid + $totalpaidmonthly;
          $grandtotaladvanced = $grandtotaladvanced + $totaladvancedmonthly;
          $grandtotal = $grandtotal + $payment->totalamount;
        @endphp
      @endforeach

      <tr class="graybackground">
        <th colspan="3" align="right">মোট</th>
        <th>৳ {{ bangla(local_currency($grandtotalshare)) }}</th>
        <th>৳ {{ bangla(local_currency($grandtotalpaid)) }}</th>
        <th>৳ {{ bangla(local_currency($grandtotaladvanced)) }}</th>
        <th>৳ {{ bangla(local_currency($grandtotal)) }}</th>
      </tr>
      
    </table>
  </div>
 
  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #6D6E6A;">Generated by: https://cvcsbd.com</small>
  </htmlpagefooter>
</body>
</html>