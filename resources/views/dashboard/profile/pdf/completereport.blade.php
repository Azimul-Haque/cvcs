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
    font-size: 14px;
  }
  @page {
    header: page-header;
    footer: page-footer;
    background-image: url({{ public_path('images/cvcs_background.png') }});
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;
  }
  </style>
</head>
<body>
  <h2 align="center">
    <img src="{{ public_path('images/custom2.png') }}" style="height: 100px; width: auto;"><br/>
    কাস্টমস অ্যান্ড ভ্যাট কো-অপারেটিভ সোসাইটি
  </h2>
  <p align="center" style="padding-top: -20px;">
    <span style="font-size: 20px;">সদস্য রিপোর্ট</span><br/>
  </p>
  
  <div class="" style="padding-top: 0px;">
    <table class="">
      <tr>
        <td colspan="2" style="background: rgba(192,192,192, 0.7);">ব্যক্তিগত তথ্য</td>
      </tr>
      <tr>
        <td width="70%">
          সদস্যঃ <big>{{ $member->name_bangla }} (<span style="font-family: Calibri;">{{ $member->name }}</span>)</big><br/>
          সদস্যপদ আইডিঃ {{ $member->member_id }}<br/>
          জাতীয় পরিচয়পত্র নং- {{ $member->nid }}<br/>
          জন্ম তারিখঃ {{ date('F d, Y', strtotime($member->dob)) }}<br/><br/>
          দপ্তরের নামঃ {{ $member->branch->name }}<br/>
          পদবিঃ {{ $member->position->name }}<br/>
          যোগদানের তারিখঃ
            @if($member->joining_date != null)
              {{ date('F d, Y', strtotime($member->joining_date)) }}
            @else
              N/A
            @endif
            <br/><br/>
          ইমেইলঃ {{ $member->email }}<br/>
          মোবাইল নম্বরঃ {{ $member->mobile }}
        </td>
        <th>
          <img src="{{ public_path('images/users/'. $member->image) }}" style="height: 150px; width: auto;">
        </th>
      </tr>
    </table>
  </div>
  
  <div class="" style="padding-top: 20px;">
    <table class="">
      <tr>
        <td colspan="2" style="background: rgba(192,192,192, 0.7);">
          @if($member->nominee_two_name != '')
            নমিনি ১ এর তথ্য
          @else
            নমিনির তথ্য
          @endif
        </td>
      </tr>
      <tr>
        <td width="70%">
          নমিনির নামঃ <big>{{ $member->nominee_one_name }}</big><br/>
          @if($member->nominee_one_identity_type == 0)
            জাতীয় পরিচয়পত্র নং- 
          @else
            জন্ম নিবন্ধন নং-
          @endif
          {{ $member->nominee_one_identity_text }}<br/>
          সম্পর্কঃ {{ $member->nominee_one_relation }}<br/>
          শতকরা হারঃ {{ $member->nominee_one_percentage }}%
        </td>
        <th>
          <img src="{{ public_path('images/users/'. $member->nominee_one_image) }}" style="height: 150px; width: auto;">
        </th>
      </tr>
    </table>
  </div>

  @if($member->nominee_two_name != '')
    <div class="" style="padding-top: 20px;">
      <table class="">
        <tr>
          <td colspan="2" style="background: rgba(192,192,192, 0.7);">নমিনি ২ এর তথ্য</td>
        </tr>
        <tr>
          <td width="70%">
            নমিনির নামঃ <big>{{ $member->nominee_two_name }}</big><br/>
            @if($member->nominee_two_identity_type == 0)
              জাতীয় পরিচয়পত্র নং- 
            @else
              জন্ম নিবন্ধন নং-
            @endif
            {{ $member->nominee_two_identity_text }}<br/>
            সম্পর্কঃ {{ $member->nominee_two_relation }}<br/>
            শতকরা হারঃ {{ $member->nominee_two_percentage }}%
          </td>
          <th>
            <img src="{{ public_path('images/users/'. $member->nominee_two_image) }}" style="height: 150px; width: auto;">
          </th>
        </tr>
      </table>
    </div>
  @endif
  
  <div class="" style="padding-top: 20px;">
    <table class="">
      <tr>
        <td colspan="4" style="background: rgba(192,192,192, 0.7);">পরিশোধের সারসংক্ষেপ</td>
      </tr>
      <tr>
        <th width="25%" style="background: rgba(124,252,0, 0.5);">
          প্রক্রিয়াধীন অর্থ<br/>
          <big>
            ৳ 
            @if(empty($pendingfordashboard->totalamount))
              0.00
            @else
              {{ $pendingfordashboard->totalamount }}
            @endif
          </big>
        </th>
        <th width="25%" style="background: rgba(124,252,0, 0.5);">
          অনুমোদিত অর্থ<br/>
          <big>
            ৳ 
            @if(empty($approvedfordashboard->totalamount))
              0.00
            @else
              {{ $approvedfordashboard->totalamount }}
            @endif
          </big>
        </th>
        <th width="25%" style="background: rgba(124,252,0, 0.5);">
          প্রক্রিয়াধীন পরিশোধ<br/>
          <big>
            @if(empty($pendingcountdashboard))
              0
            @else
              {{ $pendingcountdashboard }}
            @endif
            টি
          </big>
        </th>
        <th width="25%" style="background: rgba(124,252,0, 0.5);">
          অনুমোদিত পরিশোধ<br/>
            @if(empty($approvedcountdashboard))
              0
            @else
              {{ $approvedcountdashboard }}
            @endif
            টি
          </big>
        </th>
      </tr>
    </table>
  </div>

  <pagebreak></pagebreak>

  <div class="" style="padding-top: 0px;">
    <table class="">
      <thead>
        <tr>
          <td colspan="6" style="background: rgba(192,192,192, 0.7);">পরিশোধের বিবরণ</td>
        </tr>
        <tr>
          <th style="background: rgba(124,252,0, 0.5);">জমাদানকারী</th>
          <th style="background: rgba(124,252,0, 0.5);">পরিশোধের ধরণ</th>
          <th style="background: rgba(124,252,0, 0.5);">পেমেন্ট স্ট্যাটাস ও টাইপ</th>
          <th style="background: rgba(124,252,0, 0.5);">পরিমাণ</th>
          <th style="background: rgba(124,252,0, 0.5);">ব্যাংক ও ব্রাঞ্চ</th>
          <th style="background: rgba(124,252,0, 0.5);">সময়কাল</th>
        </tr>
      </thead>
      <tbody>
      @foreach($member->payments as $payment)
      <tr>
        <td>
          {{ $payment->payee->name_bangla }}
        </td>
        <td>
          @if($payment->payment_category == 0)
            সদস্যপদ বাবদ
          @else
            মাসিক পরিশোধ
          @endif
        </td>
        <td>
          @if($payment->payment_status == 0)
            প্রক্রিয়াধীন 
          @elseif($payment->payment_status == 1)
            অনুমোদিত
          @endif<br/>
          @if($payment->payment_type == 1)
            SINGLE
          @elseif($payment->payment_type == 2)
            BULK
          @endif
        </td>
        <td><big>৳ {{ $payment->amount }}</big></td>
        <td>{{ $payment->bank }}, {{ $payment->branch }}</td>
        <td>{{ date('F d, Y, h:m:i A', strtotime($payment->created_at)) }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>

  <div class="" style="padding-top: 20px;">
    <table class=""> {{-- eitaake datatable e convert krote hobe --}}
      <thead>
        <tr>
          <td colspan="3" style="background: rgba(192,192,192, 0.7);">মাসিক পরিশোধের বিবরণ</td>
        </tr>
        <tr>
          <th>মাস</th>
          <th>পরিশোধ</th>
          <th>পরিমাণ</th>
        </tr>
      </thead>
      <tbody>
        @if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
          @php
              $startyear = 2019;
              $today = date("Y-m-d H:i:s");
              $approvedcash = $approvedfordashboard->totalamount - 5000; // without the membership money;
              $totalyear = $startyear + ceil($approvedcash/(500 * 12)) - 1; // get total year
              if(date('Y') > $totalyear) {
                  $totalyear = date('Y');
              }
          @endphp
          @for($i=$startyear; $i <= $totalyear; $i++)
            @for($j=1; $j <= 12; $j++) {{--  strtotime("11-12-10") --}}
              @php
                $thismonth = '01-'.$j.'-'.$i;
              @endphp
              <tr>
                <td>{{ date('F Y', strtotime($thismonth)) }}</td>
                <td>
                  @if($approvedcash/500 > 0)
                    <span>পরিশোধিত</span>
                  @elseif(date('Y-m-d H:i:s', strtotime($thismonth)) < $today)
                    <span style="color: red;">পরিশোধনীয়</span>
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
        @else
          @php
              $startyear = date('Y', strtotime($member->joining_date));
              $startmonth = date('m', strtotime($member->joining_date));
              $today = date("Y-m-d H:i:s");
              $approvedcash = $approvedfordashboard->totalamount - 5000; // without the membership money;
              $endyear = $startyear + ceil($approvedcash/(500 * 12)) - 1; // get total year
              if(date('Y') > $endyear) {
                  $endyear = date('Y');
              }
              $totalyears = $endyear - $startyear;
              $totalmonths = ($totalyears * 12) + (12 - $startmonth + 1);
          @endphp
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
        @endif
        
      </tbody>
    </table>
  </div>
 
  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #6D6E6A;">Generated by: https://cvcsbd.com</small>
  </htmlpagefooter>
</body>
</html>