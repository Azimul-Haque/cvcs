@extends('adminlte::page')

@section('title', 'CVCS | Form Messages')

@section('css')

@stop

@section('content_header')
    <h1>
      Form Messages
      <div class="pull-right">
      </div>
    </h1>
@stop

@section('content')
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th>নাম</th>
          <th width="20%">ইমেইল</th>
          <th width="35%">বার্তা</th>
          <th width="20%">সময়</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($messages as $message)
        <tr>
          <td>{{ $message->name }}</td>
          <td>{{ $message->email }}</td>
          <td>{{ $message->message }}</td>
          <td>{{ date('F d, Y H:i A', strtotime($message->created_at)) }}</td>
          <td>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteFormMessageModal{{ $message->id }}" data-backdrop="static" title="Delete Message"><i class="fa fa-trash-o"></i></button>
            <!-- Delete Message Modal -->
            <!-- Delete Message Modal -->
            <div class="modal fade" id="deleteFormMessageModal{{ $message->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Message</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete this message?</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($message, ['route' => ['dashboard.deleteformmessage', $message->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete Message', array('class' => 'btn btn-danger')) !!}
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
    {{ $messages->links() }}
@stop

@section('js')

@stop