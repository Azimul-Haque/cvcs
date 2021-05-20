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
  @if(Auth::user()->role == 'admin' || Auth::user()->role_type == 'bulkpayer')
    <div class="row">
      <div class="col-md-4">
        <div class="box box-primary" id="beforedivheightcommodity">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-bar-chart"></i>
            <h3 class="box-title">দপ্তরভিত্তিক সদস্য তালিকা</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['route' => 'reports.branchmemberslist', 'method' => 'GET']) !!}
              <div class="form-group">
                <select name="branch_id" class="form-control" required="">
                  <option value="" selected="" disabled="">দপ্তরের নাম নির্ধারণ করুন</option>
                  @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                  @endforeach
                </select>
              </div>
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> ডাউনলোড</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>

        <div class="box box-primary" id="beforedivheightcommodity">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-bar-chart"></i>
            <h3 class="box-title">পদবিভিত্তিক সদস্য তালিকা</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['route' => 'reports.designationsmemberslist', 'method' => 'GET']) !!}
              <div class="form-group">
                <select name="position_id" class="form-control" required="">
                  <option value="" selected="" disabled="">পদবির নাম নির্ধারণ করুন</option>
                  @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                  @endforeach
                </select>
              </div>
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> ডাউনলোড</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-4">
        <div class="box box-success" id="beforedivheightcommodity">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-bar-chart"></i>
            <h3 class="box-title">সাধারণ রিপোর্ট</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['route' => 'reports.getpaymentsallreport', 'method' => 'GET']) !!}
              <div class="form-group">
                <select name="report_type" class="form-control" required="">
                  <option value="" selected="" disabled="">রিপোর্টের ধরন নির্ধারণ করুন</option>
                  <option value="1">সাধারণ রিপোর্ট</option>
                  <option value="2">দপ্তরভিত্তিক রিপোর্ট</option>
                </select>
              </div>
              <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> ডাউনলোড</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>

        <div class="box box-success" id="beforedivheightcommodity">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-database"></i>
            <h3 class="box-title">ডাটাবেজ ব্যাকআপ</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['route' => 'reports.getdbbackup', 'method' => 'GET']) !!}
              <div class="form-group">
                <select name="report_type" class="form-control" required="">
                  <option value="" selected="" disabled="">রিপোর্টের ধরন নির্ধারণ করুন</option>
                  <option value="1">সম্পূর্ণ ডাটাবেজ</option>
                </select>
              </div>
              <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> ডাউনলোড</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-4">
        <div class="box box-warning" id="beforedivheightcommodity">
          <div class="box-header with-border text-yellow">
            <i class="fa fa-fw fa-bar-chart"></i>
            <h3 class="box-title">দপ্তরের সদস্য পরিশোধ ও বকেয়া</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::open(['route' => 'reports.getbranchmemberspaymentreport', 'method' => 'GET']) !!}
              <div class="form-group">
                <select name="branch_id" class="form-control" required="">
                  <option value="" selected="" disabled="">দপ্তর নির্ধারণ করুন</option>
                  @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                  @endforeach
                </select>
              </div>
              <button class="btn btn-warning" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> ডাউনলোড</button>
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