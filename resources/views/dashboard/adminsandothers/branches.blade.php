@extends('adminlte::page')

@section('title', 'CVCS | ব্রাঞ্চ তালিকা')

@section('css')

@stop

@section('content_header')
    <h1>
      ব্রাঞ্চ তালিকা
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#addDonorModal" data-backdrop="static" title="নতুন ব্রাঞ্চ যোগ করুন"><i class="fa fa-plus"></i></button>
      </div>
    </h1>
@stop

@section('content')
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ব্রাঞ্চের নাম</th>
          <th>ঠিকানা</th>
          <th>যোগাযোগ</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($branches as $branch)
        <tr>
          <td>{{ $branch->name }}</td>
          <td>{{ $branch->address }}</td>
          <td>{{ $branch->phone }}</td>
          <td>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $branch->id }}" data-backdrop="static" title="সম্পাদনা করুন"><i class="fa fa-pencil"></i></button>
            <!-- Edit Branch Modal -->
            <!-- Edit Branch Modal -->
            <div class="modal fade" id="editModal{{ $branch->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">সম্পাদনা</h4>
                  </div>
                  {!! Form::model($branch, ['route' => ['dashboard.updatebranch', $branch->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('name', 'ব্রাঞ্চের নাম') !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'ব্রাঞ্চের নাম লিখুন', 'required')) !!}
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('address', 'ঠিকানা') !!}
                            {!! Form::text('address', null, array('class' => 'form-control', 'placeholder' => 'ঠিকানা লিখুন', 'required')) !!}
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('phone', 'ফোন নম্বর') !!}
                            {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'ফোন নম্বর লিখুন', 'required')) !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary')) !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                    </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
            <!-- Edit Branch Modal -->
            <!-- Edit Branch Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $branches->links() }}

  <!-- Add Branch Modal -->
  <!-- Add Branch Modal -->
  <div class="modal fade" id="addDonorModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header modal-header-success">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">নতুন ব্রাঞ্চ যোগ</h4>
        </div>
        {!! Form::open(['route' => 'dashboard.storebranch', 'method' => 'POST', 'class' => 'form-default']) !!}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('name', 'ব্রাঞ্চের নাম') !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'ব্রাঞ্চের নাম লিখুন', 'required')) !!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('address', 'ঠিকানা') !!}
                  {!! Form::text('address', null, array('class' => 'form-control', 'placeholder' => 'ঠিকানা লিখুন', 'required')) !!}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('phone', 'ফোন নম্বর') !!}
                  {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'ফোন নম্বর লিখুন', 'required')) !!}
                </div>
              </div>
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
  <!-- Add Branch Modal -->
  <!-- Add Branch Modal -->
@stop

@section('js')

@stop