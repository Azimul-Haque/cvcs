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
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#active_formmessage_tab" data-toggle="tab" aria-expanded="false">Unattended</a></li>
            <li class=""><a href="#responded_formmessage_tab" data-toggle="tab" aria-expanded="false">Responded</a></li>
            <li class=""><a href="#closed_formmessage_tab" data-toggle="tab" aria-expanded="false">Closed</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="active_formmessage_tab">
                <div class="table-responsive">
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
                                    <button class="btn btn-sm btn-info" data-toggle="modal"
                                            data-target="#replyFormMessageModal{{ $message->id }}"
                                            data-backdrop="static" title="বার্তা পাঠান"><i class="fa fa-envelope"></i>
                                    </button>
                                    <!-- Send Reply Message Modal -->
                                    <!-- Send Reply Message Modal -->
                                    <div class="modal fade" id="replyFormMessageModal{{ $message->id }}" role="dialog">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header modal-header-info">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title"><i class="fa fa-envelope"></i> জনাব/ জনাবা {{ $message->name }}-কে মেইল পাঠান</h4>
                                                </div>
                                                {!! Form::open(['route' => 'dashboard.smsmodule', 'method' => 'POST', 'class' => 'form-default']) !!}
                                                <div class="modal-body">
                                                    {!! Form::hidden('email', $message->email) !!}
                                                    {!! Form::label('subject', 'বিষয়:') !!}
                                                    {!! Form::text('subject', null, array('class' => 'form-control', 'placeholder' => 'বিষয় লিখুন', 'required' => '')) !!}
                                                    {!! Form::label('message', 'বার্তা:') !!}
                                                    {!! Form::textarea('message', null, array('class' => 'form-control textarea', 'placeholder' => 'বার্তা লিখুন', 'required' => '')) !!}
                                                </div>
                                                <div class="modal-footer">
                                                    {!! Form::submit('মেইল পাঠান', array('class' => 'btn btn-info')) !!}
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                                                    {!! Form::close() !!}
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Send Reply Message Modal -->
                                    <!-- Send Reply Message Modal -->

                                    <button class="btn btn-sm btn-success" title="জিজ্ঞাসাবাদ বন্ধ করুন"><i class="fa fa-check"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $messages->links() }}
            </div>


            <div class="tab-pane active" id="responded_formmessage_tab">
                <div class="table-responsive">
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
                                    <button class="btn btn-sm btn-success" title="জিজ্ঞাসাবাদ বন্ধ করুন"><i class="fa fa-check"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $messages->links() }}
            </div>

            <div class="tab-pane active" id="closed_formmessage_tab">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>নাম</th>
                            <th width="20%">ইমেইল</th>
                            <th width="35%">বার্তা</th>
                            <th width="20%">সময়</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ date('F d, Y H:i A', strtotime($message->created_at)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $messages->links() }}
            </div>
        </div>
    </div>


@stop

@section('js')

@stop
