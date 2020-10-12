@extends('adminlte::page')

@section('title', 'CVCS | SMS মডিউল')

@section('css')

@stop

@section('content_header')
    <h1>
      SMS মডিউল (সর্বমোট ব্যবহারযোগ্য এসএমএসঃ 
      @if($notifsmsbalance > 0)
        <b>{{ (int) ($notifsmsbalance/0.30) }}</b> টি
      @endif 
      )
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-success" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-paper-plane"></i>

          <h3 class="box-title">এসএমএস পাঠান (Send Bulk SMS)</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <big>Total Recipients: {{ $notifregisteredmember }}</big>
          {!! Form::open(['route' => ['dashboard.sms.sendbulk'], 'method' => 'POST', 'id' => 'sendBulkForm']) !!}
            <div class="form-group">
              <input type="hidden" name="smsbalance" value="{{ $notifsmsbalance / 0.30 }}">
              <label for="singlemessage">Message:</label>
              <textarea type="text" name="message" id="singlemessage" class="form-control textarea" required="" placeholder="Write message"></textarea>
            </div>
            <table class="table">
              <tr id="smstestresult">
                <td>Encoding: <span class="encoding">GSM_7BIT</span></td>
                <td>Length: <span class="length">0</span></td>
                <td>Per SMS Cost: <span class="messages" id="smscount">0</span></td>
                <td>Remaining: <span class="remaining">160</span></td>
              </tr>
            </table>
            <input type="hidden" name="smscount" id="smscounthidden" required="">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#sendBulkModal" data-backdrop="static"><i class="fa fa-paper-plane" aria-hidden="true"></i> বার্তা পাঠান</button>
            <div class="modal fade" id="sendBulkModal" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> SMS প্রেরণ নিশ্চিতকরণ</h4>
                  </div>
                  <div class="modal-body">
                    আপনি কি নিশ্চিতভাবে <b>{{ $notifregisteredmember }}</b> জনকে এ বার্তাটি পাঠাতে চান?</b>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="sendBulkModalBtn"><i class="fa fa-paper-plane"></i> বার্তা পাঠান</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                  </div>
                </div>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">মাসিক পেমেন্ট রিমাইন্ডার মেসেজ <b>[ডায়নামিক মেসেজ ব্যালেন্সঃ {{ (int) ($notifgbsmsbalance / 0.30) }} টি]</b></h3>
        </div>
        <div class="box-body">
          {!! Form::open(['route' => 'dashboard.sms.sendreminder', 'method' => 'POST', 'class' => 'form-default', 'id' => 'sendOneToManyForm']) !!}
            <b>SMS Template: </b><br/>
            Dear [Member Name], your montly payment for [Months Count] month(s) is due, please pay it. Total due: [Total Due Amount]/-.Login: https://cvcsbd.com/login<br/><br/>
            {!! Form::hidden('hiddengbbalance', (int) ($notifgbsmsbalance / 0.20)) !!}
            {!! Form::text('confirmation', null, array('class' => 'form-control', 'placeholder' => 'Type "Confirm"', 'required' => '', 'id' => 'confirmation')) !!}<br/>
            <button type="submit" class="btn btn-info" id="sendOneToManyBtn"><i class="fa fa-paper-plane"></i> বার্তা পাঠান</button>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')
  <script type="text/javascript" src="{{ asset('js/smscounter.js') }}"></script>
  <script type="text/javascript">
    $('#singlemessage').countSms('#smstestresult');
    $('#singlemessage').keyup(function() {
        $('#smscounthidden').val($('#smscount').text());
    });

    $('#sendBulkModalBtn').click(function(e) {
      if(!$('#singlemessage').val()) {
        if($(window).width() > 768) {
          toastr.error('কিছুতো লিখুন!', 'ERROR').css('width', '400px');
        } else {
          toastr.error('কিছুতো লিখুন!', 'ERROR').css('width', ($(window).width()-25)+'px');
        }
      } else {
        $("#sendBulkModalBtn").prop('disabled', true);
        $('#sendBulkForm').submit();
      }
    });

    $('#sendOneToManyBtn').click(function(e) {
      if(!$('#confirmation').val() || $('#confirmation').val() != 'Confirm') {
        if($(window).width() > 768) {
          toastr.error('Confirm শব্দটি লিখুন!', 'ERROR').css('width', '400px');
        } else {
          toastr.error('Confirm শব্দটি লিখুন!', 'ERROR').css('width', ($(window).width()-25)+'px');
        }
      } else if($('#confirmation').val() == 'Confirm') {
        $("#sendOneToManyBtn").prop('disabled', true);
        $('#sendOneToManyForm').submit();
      }
    });
  </script>
@stop