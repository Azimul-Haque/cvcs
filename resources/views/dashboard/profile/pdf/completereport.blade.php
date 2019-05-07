<html>
<head>
  <title>Report | Download | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
    background-image: url({{ public_path('images/cvcs_background.png') }});
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;
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
    /*header: page-header;
    footer: page-footer;*/
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
          জন্ম তারিখঃ {{ date('F d, Y, h:m:i A', strtotime($member->dob)) }}<br/><br/>
          দপ্তরের নামঃ {{ $member->office }}<br/>
          পদবিঃ {{ $member->designation }}<br/><br/>
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
    </table>
  </div>
 
  <div class="" style="bottom: 0; position: fixed; width: 100%; border-bottom: 1px solid #000000;">
    ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:m:i A') }}</span>
  </div>

  {{-- <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Generated by: https://cvcsbd.com</small>
  </htmlpagefooter> --}}
  <p style="bottom: 5; position: absolute;"><small style="font-family: Calibri; color: #6D6E6A;">Generated by: https://cvcsbd.com</small></p>
</body>
</html>