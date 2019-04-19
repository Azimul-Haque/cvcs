@extends('adminlte::page')

@section('title', 'CVCS | ' . $donor->name . '-এর ডোনেশনসমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
      {{ $donor->name }}-এর ডোনেশনসমূহ
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">ডোনার (দাতা)-এর প্রোফাইল</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <center>
            <img src="{{ asset('images/donor.png') }}" class="img-responsive" style="max-height: 150px; width: auto;">
            <h3>{{ $donor->name }}</h3>
          </center>

          <div class="list-group">
              <a href="#" class="list-group-item"><i class="fa fa-phone"></i> {{ $donor->phone }}</a>
              <a href="#" class="list-group-item"><i class="fa fa-envelope-o"></i> {{ $donor->email }}</a>
              <a href="#" class="list-group-item"><i class="fa fa-map-marker"></i> {{ $donor->address }}</a>
            </div>
        </div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">ডোনেশন তালিকা</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>

        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>প্রতিষ্ঠান</th>
                  <th>পরিমাণ</th>
                  <th>পেমেন্ট স্ট্যাটাস</th>
                  <th>পে স্লিপ<br/>পেমেন্ট আইডি</th>
                  <th>ব্যাংক<br/>ব্রাঞ্চ</th>
                  <th>Action</th>
                </tr>
                @foreach($donations as $donation)
                <tr>
                  <td>
                    <a href="{{ route('dashboard.donationofdonor', $donation->donor->id) }}">{{ $donation->donor->name }}</a>
                    <br/><small>দাখিলকারীঃ {{ $donation->submitter->name_bangla }}</small>
                  </td>
                  <td>৳ {{ $donation->amount }}</td>
                  <td>
                    @if($donation->payment_status == 0)
                      <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> প্রক্রিয়াধীন</span>
                    @else
                      <span class="badge badge-success"><i class="fa fa-check"></i>অনুমোদিত</span>
                    @endif
                  </td>
                  <td>{{ $donation->pay_slip }}<br/>{{ $donation->payment_key }}</td>
                  <td>{{ $donation->bank }}<br/>{{ $donation->branch }}</td>
                  <td>
                    <button class="btn btn-sm btn-primary btn-with-count" data-toggle="modal" data-target="#seeReceiptModal{{ $donation->id }}" data-backdrop="static" title="রিসিট সংযুক্তি দেখুন"><i class="fa fa-paperclip"></i></button>
                    <!-- See Receipts Modal -->
                    <!-- See Receipts Modal -->
                    <div class="modal fade" id="seeReceiptModal{{ $donation->id }}" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-paperclip"></i> পরিশোধ সংযুক্তি</h4>
                          </div>
                          <div class="modal-body">
                            পে-স্লিপ নম্বরঃ {{ $donation->pay_slip }}
                            <img src="{{ asset('images/receipts/'. $donation->image) }}" alt="Receipt Image" class="img-responsive" style="">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- See Receipts Modal -->
                    <!-- See Receipts Modal -->
                  </td>
                </tr>
                @endforeach
              </thead>
            </table>
          </div>
        </div>

        <div class="box-footer">
          {{ $donations->links() }}
        </div>
      </div>
    </div>

    
  </div>
@stop

@section('js')

@stop