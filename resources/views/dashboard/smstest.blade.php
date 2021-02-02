@extends('adminlte::page')

@section('title', 'CVCS | SMS Test')

@section('css')

@stop

@section('content_header')
    <h1>
      SMS Test
      <div class="pull-right">
        {{-- <button class="btn btn-success" data-toggle="modal" data-target="#addMemberModal" data-backdrop="static"id=""><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Member</button> --}}
      </div>
    </h1>
@stop

@section('content')
    {{ count($smsdata) }}
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>SMS</th>
        </tr>
      </thead>
      <tbody>
        @foreach($smsdata as $sms)
        <tr>
          <td>{{ $sms['to'] }}</td>
          <td>{{ rawurldecode($sms['message']) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>


    
@stop

@section('js')

@stop