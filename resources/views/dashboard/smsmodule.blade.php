@extends('adminlte::page')

@section('title', 'CVCS | SMS মডিউল')

@section('css')

@stop

@section('content_header')
    <h1>
      SMS মডিউল (মোট {{ $notifcount }} টি)
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">সকলকে SMS</h3>

          <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body no-padding">
          {!! Form::open(['route' => 'dashboard.sendsmsapplicant', 'method' => 'POST', 'class' => 'form-default']) !!}
            <div class="modal-body">
              {!! Form::textarea('message', null, array('class' => 'form-control textarea', 'placeholder' => 'বার্তা লিখুন', 'required' => '')) !!}
            </div>
            <div class="modal-footer">
                  {!! Form::submit('বার্তা পাঠান', array('class' => 'btn btn-warning')) !!}
                  <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
              {!! Form::close() !!}
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">পেমেন্ট অনুরোধ মেসেজ</h3>
        </div>
        <div class="box-body no-padding">
          {!! Form::open(['route' => 'dashboard.sendsmsapplicant', 'method' => 'POST', 'class' => 'form-default']) !!}
            <div class="modal-body">
              {!! Form::textarea('message', null, array('class' => 'form-control textarea', 'placeholder' => 'বার্তা লিখুন', 'required' => '')) !!}
            </div>
            <div class="modal-footer">
                  {!! Form::submit('বার্তা পাঠান', array('class' => 'btn btn-warning')) !!}
                  <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
              {!! Form::close() !!}
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@stop

@section('js')

@stop