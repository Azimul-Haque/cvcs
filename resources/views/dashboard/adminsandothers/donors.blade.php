@extends('adminlte::page')

@section('title', 'CVCS | ডোনেশন সংক্রান্ত')

@section('css')
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      ডোনেশন সংক্রান্ত
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">ডোনেশন তালিকা</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDonationModal" data-backdrop="static" title="নতুন ডোনেশন যোগ করুন" data-placement="top"><i class="fa fa-plus"></i></button>
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
                  
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#approvePaymentModal{{ $donation->id }}" data-backdrop="static" title="অনুমোদন করুন" @if($donation->payment_status != 0) disabled="" @endif><i class="fa fa-check"></i></button>
                  
                    <!-- Approve Payment Modal -->
                    <!-- Approve Payment Modal -->
                    <div class="modal fade" id="approvePaymentModal{{ $donation->id }}" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header modal-header-success">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-check"></i> ডোনেশন অনুমোদন</h4>
                          </div>
                          <div class="modal-body">
                            <big>আপনি কী নিশ্চিতভাবে এই ডোনেশনটি অনুমোদন করতে চান?</big><br/>
                            <strong>প্রতিষ্ঠান</strong> {{ $donation->donor->name }}<br/>
                            <strong>জমাদানকারীঃ</strong> {{ $donation->submitter->name_bangla }}<br/>
                            <strong>পরিমাণঃ</strong> ৳ {{ $donation->amount }}<br/>
                            <strong>ব্যাংকঃ</strong> {{ $donation->bank }}<br/>
                            <strong>ব্রাঞ্চঃ</strong> {{ $donation->branch }}<br/>
                            <strong>পে স্লিপ</strong> {{ $donation->pay_slip }}<br/>
                            <strong>সময়কালঃ</strong> {{ date('F d, Y H:i A', strtotime($donation->created_at)) }}<br/><br/>
                          </div>
                          <div class="modal-footer">
                            {!! Form::model($donation, ['route' => ['dashboard.approvedonation', $donation->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                                {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!}
                                <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Approve Payment Modal -->
                    <!-- Approve Payment Modal -->
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
    <div class="col-md-4">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">ডোনার (দাতা) তালিকা</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addDonorModal" data-backdrop="static" title="নতুন Donor (দাতা) যোগ করুন" data-placement="top"><i class="fa fa-plus"></i></button>
          </div>
        </div>

        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>প্রতিষ্ঠানের নাম</th>
                  <th>যোগাযোগ</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($donors as $donor)
                <tr>
                  <td><a href="{{ route('dashboard.donationofdonor', $donor->id) }}">{{ $donor->name }}</a></td>
                  <td>{{ $donor->phone }}, {{ $donor->email }}<br/>{{ $donor->address }}</td>
                  <td>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#editModal{{ $donor->id }}" data-backdrop="static" title="সম্পাদনা করুন"><i class="fa fa-pencil"></i></button>
                    <!-- Edit Donor Modal -->
                    <!-- Edit Donor Modal -->
                    <div class="modal fade" id="editModal{{ $donor->id }}" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header modal-header-success">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">সম্পাদনা</h4>
                          </div>
                          {!! Form::model($donor, ['route' => ['dashboard.updatedonor', $donor->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    {!! Form::label('name', 'প্রতিষ্ঠানের নাম') !!}
                                    {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'প্রতিষ্ঠানের নাম লিখুন', 'required')) !!}
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    {!! Form::label('address', 'ঠিকানা') !!}
                                    {!! Form::text('address', null, array('class' => 'form-control', 'placeholder' => 'ঠিকানা লিখুন', 'required')) !!}
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    {!! Form::label('email', 'ইমেইল এড্রেস') !!}
                                    {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'ইমেইল এড্রেস লিখুন', 'required')) !!}
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    {!! Form::label('phone', 'ফোন নম্বর') !!}
                                    {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'ফোন নম্বর লিখুন', 'required')) !!}
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!}
                              <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                            </div>
                          {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                    <!-- Edit Donor Modal -->
                    <!-- Edit Donor Modal -->
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="box-footer">
          {{ $donors->links() }}
        </div>
      </div>
    </div>
  </div>

  <!-- Add Donation Modal -->
  <!-- Add Donation Modal -->
  <div class="modal fade" id="addDonationModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">নতুন ডোনেশন যোগ</h4>
        </div>
        {!! Form::open(['route' => 'dashboard.storedonation', 'method' => 'POST', 'class' => 'form-default', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data']) !!}
          <div class="modal-body">
            {!! Form::hidden('submitter_id', Auth::user()->id) !!}
            <div class="form-group">
              {{-- {!! Form::label('amount', 'পরিমাণ (৳)') !!} --}}
              <select class="form-control" name="donor_id" required="">
                <option selected="" disabled="">ডোনার (দাতা) নির্ধারণ করুন</option>
                @foreach($donors as $donor)
                <option value="{{ $donor->id }}">{{ $donor->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              {{-- {!! Form::label('amount', 'পরিমাণ (৳)') !!} --}}
              {!! Form::text('amount', null, array('class' => 'form-control', 'id' => 'amount', 'placeholder' => 'টাকার পরিমাণ লিখুন (৫০০ এর গুণিতকে)', 'required', 'data-parsley-type' => 'number','data-parsley-type-message' => 'সংখ্যায় লিখুন')) !!}
            </div>
            <div class="form-group">
              {{-- {!! Form::label('bank', 'ব্যাংকের নাম') !!} --}}
              {!! Form::text('bank', null, array('class' => 'form-control', 'id' => 'bank', 'placeholder' => 'ব্যাংকের নাম লিখুন', 'required' => '', 'data-parsley-required-message' => 'ব্যাংকের নামটি লিখুন')) !!}
            </div>
            <div class="form-group">
              {{-- {!! Form::label('branch', 'ব্রাঞ্চের নাম') !!} --}}
              {!! Form::text('branch', null, array('class' => 'form-control', 'id' => 'branch', 'placeholder' => 'ব্রাঞ্চের নাম লিখুন', 'required' => '')) !!}
            </div>
            <div class="form-group">
              {{-- {!! Form::label('pay_slip', 'ব্রাঞ্চের নাম') !!} --}}
              {!! Form::text('pay_slip', null, array('class' => 'form-control', 'id' => 'pay_slip', 'placeholder' => 'পে স্লিপ নম্বর লিখুন', 'required' => '')) !!}
            </div>
            <div class="form-group">
                <label>রিসিটের ছবি (সর্বোচ্চ ৫০০ কিলোবাইট)</label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-default btn-file">
                            Browse <input type="file" id="image" name="image" required="">
                        </span>
                    </span>
                    <input type="text" class="form-control text-blue" readonly>
                </div>
                <center>
                  <img src="{{ asset('images/800x500.png')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                </center>
            </div>
          </div>
          <div class="modal-footer">
            {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary')) !!}
            <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- Add Donation Modal -->
  <!-- Add Donation Modal -->

  <!-- Add Donor Modal -->
  <!-- Add Donor Modal -->
  <div class="modal fade" id="addDonorModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header modal-header-success">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">নতুন Donor (দাতা) যোগ</h4>
        </div>
        {!! Form::open(['route' => 'dashboard.storedonor', 'method' => 'POST', 'class' => 'form-default', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data']) !!}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('name', 'প্রতিষ্ঠানের নাম') !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'প্রতিষ্ঠানের নাম লিখুন', 'required')) !!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('address', 'ঠিকানা') !!}
                  {!! Form::text('address', null, array('class' => 'form-control', 'placeholder' => 'ঠিকানা লিখুন', 'required')) !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('email', 'ইমেইল এড্রেস') !!}
                  {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'ইমেইল এড্রেস লিখুন', 'required')) !!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('phone', 'ফোন নম্বর') !!}
                  {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'ফোন নম্বর লিখুন', 'required')) !!}
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!}
            <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- Add Donor Modal -->
  <!-- Add Donor Modal -->
@stop

@section('js')
  {!!Html::script('js/parsley.min.js')!!}
  <script type="text/javascript">
    // $(document).ready( function() {
    //   $('#amount').blur(function() {
    //     var value = $('#amount').val();
    //     if(value == '') {
    //       if($(window).width() > 768) {
    //         toastr.info('পরিমাণ ৫০০ এর গুণিতক', 'INFO').css('width', '400px');
    //       } else {
    //         toastr.info('পরিমাণ ৫০০ এর গুণিতক', 'INFO').css('width', ($(window).width()-25)+'px');
    //       }
    //       $('#submitBtn').attr('disabled', false);
    //     } else {
    //       $('#submitBtn').attr('disabled', true);
    //     }
    //     if(value % 500 != 0) {
    //       if($(window).width() > 768) {
    //         toastr.info('পরিমাণ ৫০০ এর গুণিতকে দিন', 'INFO').css('width', '400px');
    //       } else {
    //         toastr.info('পরিমাণ ৫০০ এর গুণিতকে দিন', 'INFO').css('width', ($(window).width()-25)+'px');
    //       }
    //       $('#submitBtn').attr('disabled', true);
    //     } else {
    //       $('#submitBtn').attr('disabled', false);
    //     }
    //   })
    // });
  </script>
  <script type="text/javascript">
    $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
      });

      $('.btn-file :file').on('fileselect', function(event, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = label;
          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
      });
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image").change(function(){
          readURL(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 500) {
            $("#image").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
    });
  </script>
@stop