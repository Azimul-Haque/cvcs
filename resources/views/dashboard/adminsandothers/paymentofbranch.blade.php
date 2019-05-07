@extends('adminlte::page')

@section('title', 'CVCS | ' . $branch->name . '-এর পরিশোধসমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
      {{ $branch->name }}-এর পরিশোধসমূহ
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">ব্রাঞ্চ-এর প্রোফাইল</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">
          <center>
            <img src="{{ asset('images/branch.png') }}" class="img-responsive" style="max-height: 150px; width: auto;">
            <h3>{{ $branch->name }}</h3>
          </center>

          <div class="list-group">
              <a href="#" class="list-group-item"><i class="fa fa-phone"></i> {{ $branch->phone }}</a>
              <a href="#" class="list-group-item"><i class="fa fa-map-marker"></i> {{ $branch->address }}</a>
            </div>
        </div>
      </div>

      <div class="small-box bg-green">
        <div class="inner">
          <h3>
            @if(empty($totalapproved->totalamount))
              0.00<sup style="font-size: 20px">৳</sup>
            @else
              {{ $totalapproved->totalamount }}<sup style="font-size: 20px">৳</sup>
            @endif
          </h3>

          <p>সর্বমোট অনুমোদিত পরিশোধ</p>
        </div>
        <div class="icon">
          <i class="ion ion-cash"></i>
        </div>
        {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
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
                  <th>ব্রাঞ্চ</th>
                  <th>পরিমাণ</th>
                  <th>পেমেন্ট স্ট্যাটাস</th>
                  <th>পে স্লিপ<br/>পেমেন্ট আইডি</th>
                  <th>ব্যাংক<br/>ব্রাঞ্চ</th>
                  <th>Action</th>
                </tr>
                @foreach($branchpayments as $branchpayment)
                <tr>
                  <td>
                    <a href="{{ route('dashboard.donationofdonor', $branchpayment->branch->id) }}">{{ $branchpayment->branch->name }}</a>
                    <br/><small>দাখিলকারীঃ {{ $branchpayment->submitter->name_bangla }}</small>
                  </td>
                  <td>৳ {{ $branchpayment->amount }}</td>
                  <td>
                    @if($branchpayment->payment_status == 0)
                      <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> প্রক্রিয়াধীন</span>
                    @else
                      <span class="badge badge-success"><i class="fa fa-check"></i>অনুমোদিত</span>
                    @endif
                  </td>
                  <td>{{ $branchpayment->pay_slip }}<br/>{{ $branchpayment->payment_key }}</td>
                  <td>{{ $branchpayment->bank }}<br/>{{ $branchpayment->branch_name }}</td>
                  <td>
                    <button class="btn btn-sm btn-primary btn-with-count" data-toggle="modal" data-target="#seeReceiptModal{{ $branchpayment->id }}" data-backdrop="static" title="রিসিট সংযুক্তি দেখুন"><i class="fa fa-paperclip"></i></button>
                    <!-- See Receipts Modal -->
                    <!-- See Receipts Modal -->
                    <div class="modal fade" id="seeReceiptModal{{ $branchpayment->id }}" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-paperclip"></i> পরিশোধ সংযুক্তি</h4>
                          </div>
                          <div class="modal-body">
                            পে-স্লিপ নম্বরঃ {{ $branchpayment->pay_slip }}
                            <img src="{{ asset('images/receipts/'. $branchpayment->image) }}" alt="Receipt Image" class="img-responsive" style="">
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
          {{ $branchpayments->links() }}
        </div>
      </div>
    </div>

    
  </div>
@stop

@section('js')

@stop