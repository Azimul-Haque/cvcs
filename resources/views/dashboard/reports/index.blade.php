@extends('adminlte::page')

@section('title', 'CVCS | পদবী সমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
      পদবী সমূহ
      <div class="pull-right">
        @if(Auth::user()->role == 'admin')
        <a class="btn btn-success" href="#!" title="পদবী যোগ করুন (কাজ চলছে...)"><i class="fa fa-fw fa-plus" aria-hidden="true"></i></a> {{-- {{ route('dashboard.createbulkpayer') }} --}}
        @endif
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role == 'admin')
    <div class="col-md-3">
      <div class="box box-primary" id="beforedivheightcommodity">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-bar-chart"></i>
          <h3 class="box-title">Commodity Reports</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {{-- {!! Form::open(['route' => 'reports.getcommoditypdf', 'method' => 'GET']) !!} --}}
            <div class="form-group">
              {!! Form::text('from', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Enter From Date', 'id' => 'fromcomexDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('to', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Enter To Date', 'id' => 'tocomexDate', 'autocomplete' => 'off', 'readonly' => '')) !!}
            </div>
          <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> Get Report</button>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')

@stop