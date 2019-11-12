@extends('adminlte::page')

@section('title', 'CVCS | রিপোর্ট')

@section('css')

@stop

@section('content_header')
    <h1>
      রিপোর্ট
      <div class="pull-right">

      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role == 'admin')
    <div class="row">
      <div class="col-md-3">
        <div class="box box-primary" id="beforedivheightcommodity">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-bar-chart"></i>
            <h3 class="box-title">পরিশোধ ও বকেয়া রিপোর্ট</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {{-- {!! Form::open(['route' => 'reports.getcommoditypdf', 'method' => 'GET']) !!} --}}
              <div class="form-group">
                <select name="report_type" class="form-control">
                  <option value="" selected="" disabled="">রিপোর্টের ধরন নির্ধারণ করুন</option>
                  <option value="1">সাধারণ রিপোর্ট</option>
                  <option value="2">দপ্তরভিত্তিক রিপোর্ট</option>
                  <option value="3">দপ্তরের সদস্যগোণের বিস্তারিত রিপোর্ট</option>
                </select>
              </div>
            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> ডাউনলোড</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')

@stop