@extends('adminlte::page')

@section('title', 'CVCS | Membership Applications')

@section('css')

@stop

@section('content_header')
    <h1>
      Applications
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#addNoticeModal" data-backdrop="static"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Member</button>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      <center>
        <img src="{{ asset('images/Work_In_Progress.gif') }}" alt="Work In Progress" class="img-responsive" style="max-height: 200px; width: auto;">
      </center>
    </div>
  </div>
@stop

@section('js')

@stop