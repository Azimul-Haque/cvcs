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
    <span style="font-size: 20px;">সদস্যভিত্তিক পরিশোধ-বকেয়া রিপোর্ট ({{ $branch->name }})</span><br/>
  </p>
  
  <div class="" style="padding-top: 0px;">
    <table class="">
      <tr class="graybackground">
        <th width="5%">#</th>
        <th width="40%">সদস্য</th>
        <th>ছবি</th>
        <th>সদস্যপদ বাবদ পরিশোধ</th>
        <th>হিসাব শুরুর মাস</th>
        <th>মোট মাসিক কিস্তি পরিশোধ<br/>({{ bangla(date('F, Y')) }} পর্যন্ত)</th>
        <th>মোট মাসিক কিস্তি বকেয়া<br/>({{ bangla(date('F, Y')) }} পর্যন্ত)</th>
      </tr>
      @php
        $counter = 1;
      @endphp
      @foreach($members->sortByDesc('totalpendingmonthly') as $member)
        <tr>
          <td align="center">{{ bangla($counter) }}</td>
          <td>
            {{ $member->name_bangla }}, <small>{{ $member->position->name }}</small><br/>
            <small>আইডিঃ {{ $member->member_id }}, ফোনঃ {{ $member->mobile }}</small>
          </td>
          <td>
            @if($member->image != null && file_exists(public_path('images/users/'.$member->image)))
              <img src="{{ public_path('images/users/'.$member->image)}}" style="height: 50px; width: auto;" />
            @else
              <img src="{{ public_path('images/user.png')}}" style="height: 50px; width: auto;" />
            @endif
          </td>
          <td align="center">৳ ২০০০</td>
          <td align="center">
            @if($member->joining_date == '' || $member->joining_date == null || strtotime('31-01-2019') > strtotime($member->joining_date))
              {{ bangla(date('F, Y', strtotime('31-01-2019'))) }}
            @else
              {{ bangla(date('F, Y', strtotime($member->joining_date))) }}
            @endif
          </td>
          <td align="center">৳ {{ bangla($member->payments->sum('amount')) }}</td>
          <td align="center">৳ {{ bangla($member->totalpendingmonthly) }}</td>
        </tr>
        @php
          $counter++;
        @endphp
      @endforeach

      <tr class="graybackground">
        <th width="5%"></th>
        <th></th>
        <th align="right">মোট</th>
        <th>৳ {{ bangla($members->count() * 2000) }}</th>
        <th></th>
        <th>৳ {{ bangla($intotalmontlypaid) }}</th>
        <th>৳ {{ bangla($intotalmontlydues) }}</th>
      </tr>
      
    </table>
  </div>
 
  <htmlpagefooter name="page-footer">
    <small>ডাউনলোডের সময়কালঃ <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
    <small style="font-family: Calibri; color: #6D6E6A;">Generated by: https://cvcsbd.com</small>
  </htmlpagefooter>
</body>
</html>