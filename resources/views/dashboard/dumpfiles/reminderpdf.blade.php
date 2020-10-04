<html>
<head>
  <title>Reminder SMS List | Download | PDF</title>
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
    font-size: 10px;
  }
  /*
  page@ {
    header: page-header;
    footer: page-footer;
    background-image: url({{ public_path('images/cvcs_background.png') }});
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;
  }*/
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
    <span style="font-size: 20px;">রিমাইন্ডার এসএমএস তালিকা</span><br/>
  </p>
  
  <div class="" style="padding-top: 0px;">
    <table class="">
      <tr class="graybackground">
        <th width="5%">#</th>
        <th width="20%">সদস্য</th>
        <th>যোগাযোগ</th>
        <th width="40%">এসএমএস</th>
        <th>যোগদানের তারিখ</th>
        <th>মোট পাওনা</th>
      </tr>
      @php
        $counter = 1;
      @endphp
      @foreach($smsdata as $member)
        @if($member['due'] > 0)
          <tr>
            <td align="center">{{ bangla($counter++) }}</td>
            <td>
              <span style="font-family: Calibri; font-size: 9px;">{{ $member['name'] }}</span><br/>
              <small>Member ID: <span style="font-family: Calibri; font-size: 9px;"><b>{{ $member['member_id'] }}</b></span></small>
            </td>
            <td align="center"><span style="font-family: Calibri; font-size: 9px;">{{ $member['to'] }}</span></td>
            <td align="left"><span style="font-family: Calibri; font-size: 9px;">{{ $member['message'] }}</span></td>
            <td align="center">
              @if(strtotime('31-01-2019') > strtotime($member['joining_date']))
                <span span style="font-family: Calibri; font-size: 9px;">Before <b>January, 2019</b> or did not provide joining date</span>
              @else
                <span style="font-family: Calibri; font-size: 9px;"><b>{{ date('F d, Y', strtotime($member['joining_date'])) }}</b></span>
              @endif
            </td>
            <td align="center"><span style="font-family: Calibri; font-size: 9px;">{{ $member['due'] }}/-</span></td>
          </tr>
        @endif
      @endforeach      
    </table>
  </div>
 
  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #6D6E6A;">Generated by: https://cvcsbd.com</small>
  </htmlpagefooter>
</body>
</html>