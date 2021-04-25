@extends('adminlte::page')

@section('title', 'EasyPeriod | Report')

@section('css')

@stop

@section('content_header')
    <h1>
      EasyPeriod | Report
      <div class="pull-right">

      </div>
    </h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary" id="beforedivheightcommodity">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-envelope-o"></i>
            <h3 class="box-title">Messages</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email, Datetime</th>
                  <th>Location</th>
                  <th>Message</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($messages as $message)
                <tr>
                  <td>{{ $message->name }}</td>
                  <td>
                    {{ $message->email }}<br/>
                    <small class="text-green">{{ date('F d, Y h:i A', strtotime($message->created_at)) }}</small>
                  </td>
                  <td>{{ $message->location }}</td>
                  <td>{{ $message->message }}</td>
                  <td>
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMessage{{ $message->id }}" data-backdrop="static" title="Delete"><i class="fa fa-trash-o"></i></button>
                    <!-- Delete Message Modal -->
                    <!-- Delete Message Modal -->
                    <div class="modal fade" id="deleteMessage{{ $message->id }}" role="dialog">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Message</h4>
                          </div>
                          <div class="modal-body">
                            Confirm resolve/ delete this message?
                          </div>
                          <div class="modal-footer">
                            {!! Form::model($message, ['route' => ['dashboard.easyperiod.delmessage', $message->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                                {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Delete Message Modal -->
                    <!-- Delete Message Modal -->
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
@stop

@section('js')

@stop