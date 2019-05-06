@extends('adminlte::page')

@section('title', 'CVCS | সদস্য তথ্য')

@section('css')

@stop

@section('content_header')
    <h1>
      পাসওয়ার্ড পরিবর্তন
      <div class="pull-right">

      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="box box-primary" id="beforedivheightcommodity">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-lock"></i>
          <h3 class="box-title">পাসওয়ার্ড পরিবর্তন করুন</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'dashboard.member.changepassword', 'method' => 'POST', 'class' => 'form-default', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
              <input type="password" name="oldpassword" id="oldpassword" class="form-control" autocomplete="off" required="" placeholder="পুরোনো পাসওয়ার্ড লিখুন">
            </div>
            <div class="form-group">
              <input type="password" name="newpassword" id="newpassword" class="form-control" autocomplete="off" required="" placeholder="নতুন পাসওয়ার্ড দিন">
            </div>
            <div class="form-group">
              <input type="password" name="againnewpassword" id="againnewpassword" class="form-control" autocomplete="off" required="" placeholder="নতুন পাসওয়ার্ডটি আবার দিন">
              <small><span id="password_match_text"></span></small>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" id="change_password_btn" type="submit">দাখিল করুন</button>
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
@stop

@section('js')
  <script type="text/javascript">
    $('#againnewpassword').keyup(function() {
      if($('#againnewpassword').val() != $('#newpassword').val()) {
        $('#password_match_text').html('<span style="color: #DC143C;"><b>✕ মিলছে না</b></span>');
      } else {
        $('#password_match_text').text('✓ মিলেছে');
        $('#password_match_text').html('<span style="color: #008000;"><b>✓ মিলেছে</b></span>');
      }
    })
  </script>
@stop