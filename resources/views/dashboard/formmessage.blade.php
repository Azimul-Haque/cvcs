@extends('adminlte::page')

@section('title', 'CVCS | Form Messages')

@section('css')

@stop

@section('content_header')
    <h1>
      যোগাযোগ ফর্মের বার্তাসমূহ
      <div class="pull-right">
      </div>
    </h1>
@stop

@section('content')
    <div class="table-responsive">
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th>নাম</th>
            <th width="20%">যোগাযোগ</th>
            <th width="35%">বার্তা</th>
            <th width="20%">সময়</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($messages as $message)
          <tr>
            <td>{{ $message->name }}</td>
            <td>{{ $message->mobile }}</td>
            <td>{{ $message->message }}</td>
            <td>{{ date('F d, Y H:i A', strtotime($message->created_at)) }}</td>
            <td>
              <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#resolveMessageModal{{ $message->id }}" data-backdrop="static" title="আর্কাইভ করুন (সমাধান)"><i class="fa fa-check"></i></button>
              <!-- Archive Message Modal -->
              <!-- Archive Message Modal -->
              <div class="modal fade" id="resolveMessageModal{{ $message->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-success">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">আর্কাইভ করুন</h4>
                    </div>
                    <div class="modal-body">
                      আপনি কি নিশ্চিতভাবে এই বার্তাটি আর্কাইভ করতে চান?</b>
                    </div>
                    <div class="modal-footer">
                      {!! Form::model($message, ['route' => ['dashboard.archiveformmessage', $message->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                          {!! Form::submit('আর্কাইভ করুন', array('class' => 'btn btn-success')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
              <!-- Archive Message Modal -->
              <!-- Archive Message Modal -->

              <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteFormMessageModal{{ $message->id }}" data-backdrop="static" title="মেসেজ ডিলেট করুন" disabled=""><i class="fa fa-trash-o"></i></button>
              <!-- Delete Message Modal -->
              <!-- Delete Message Modal -->
              <div class="modal fade" id="deleteFormMessageModal{{ $message->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">ডিলেট করুন</h4>
                    </div>
                    <div class="modal-body">
                      আপনি কি নিশ্চিতভাবে এই বার্তাটি ডিলেট করতে চান?</b>
                    </div>
                    <div class="modal-footer">
                      {!! Form::model($message, ['route' => ['dashboard.deleteformmessage', $message->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                          {!! Form::submit('ডিলেট করুন', array('class' => 'btn btn-danger')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
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
    {{ $messages->links() }}
@stop

@section('js')

@stop