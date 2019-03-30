@extends('adminlte::page')

@section('title', 'CVCS | FAQ')

@section('css')

@stop

@section('content_header')
    <h1>
      FAQ (সাধারণ জিজ্ঞাসা)
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#addFAQModal" data-backdrop="static" title="জিজ্ঞাসা ও উত্তর তৈরি করুন"><i class="fa fa-fw fa-plus" aria-hidden="true"></i></button>
      </div>
    </h1>
@stop

@section('content')
  <div class="table-responsive">
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th width="30%">Title</th>
          <th width="60%">Attachment</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($faqs as $faq)
        <tr>
          <td>{{ $faq->question }}</td>
          <td>{{ $faq->answer }}</td>
          <td>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editFAQModal{{ $faq->id }}" data-backdrop="static" title="প্রশ্ন সম্পাদনা করুন"><i class="fa fa-pencil"></i></button>
            <!-- Edit FAQ Modal -->
            <!-- Edit FAQ Modal -->
            <div class="modal fade" id="editFAQModal{{ $faq->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">প্রশ্ন সম্পাদনা</h4>
                  </div>
                  <div class="modal-body">
                  {!! Form::model($faq, ['route' => ['dashboard.updatefaq', $faq->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                      {!! Form::label('question', 'প্রশ্ন') !!}
                      {!! Form::text('question', null, array('class' => 'form-control', 'placeholder' => 'প্রশ্ন লিখুন', 'required')) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('answer', 'উত্তর') !!}
                      {!! Form::textarea('answer', null, array('class' => 'form-control textarea', 'placeholder' => 'উত্তর লিখুন', 'required')) !!}
                    </div>
                  </div>
                  <div class="modal-footer">
                        {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
            <!-- Edit FAQ Modal -->
            <!-- Edit FAQ Modal -->

            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteFAQModal{{ $faq->id }}" data-backdrop="static" title="প্রশ্ন-উত্তর মুছে দিন"><i class="fa fa-trash-o"></i></button>
            <!-- Delete FAQ Modal -->
            <!-- Delete FAQ Modal -->
            <div class="modal fade" id="deleteFAQModal{{ $faq->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">প্রশ্ন-উত্তর মুছে দিন</h4>
                  </div>
                  <div class="modal-body">
                    আপনি নিশ্চিতভাবে প্রশ্নটি মুছে দিতে চান?
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($faq, ['route' => ['dashboard.deletefaq', $faq->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('মুছে দিন', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete FAQ Modal -->
            <!-- Delete FAQ Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $faqs->links() }}


  <!-- Add FAQ Modal -->
  <!-- Add FAQ Modal -->
  <div class="modal fade" id="addFAQModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header modal-header-success">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">প্রশ্ন-উত্তর যোগ করুন</h4>
        </div>
        <div class="modal-body">
          {!! Form::open(['route' => 'dashboard.storefaq', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
              <div class="form-group">
                {!! Form::label('question', 'প্রশ্ন') !!}
                {!! Form::text('question', null, array('class' => 'form-control', 'placeholder' => 'প্রশ্ন লিখুন', 'required')) !!}
              </div>
              <div class="form-group">
                {!! Form::label('answer', 'উত্তর') !!}
                {!! Form::textarea('answer', null, array('class' => 'form-control textarea', 'placeholder' => 'উত্তর লিখুন', 'required')) !!}
              </div>
        </div>
        <div class="modal-footer">
              {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!}
              <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- Add FAQ Modal -->
  <!-- Add FAQ Modal -->
@stop

@section('js')

@stop