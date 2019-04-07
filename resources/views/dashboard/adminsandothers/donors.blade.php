@extends('adminlte::page')

@section('title', 'CVCS | Donors (দাতা তালিকা)')

@section('css')

@stop

@section('content_header')
    <h1>
      Donors (দাতা তালিকা)
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#addDonorModal" data-backdrop="static" title="নতুন Donor (দাতা) যোগ করুন"><i class="fa fa-plus"></i></button>
      </div>
    </h1>
@stop

@section('content')
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>প্রতিষ্ঠানের নাম</th>
          <th>ঠিকানা</th>
          <th>ইমেইল</th>
          <th>যোগাযোগ</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($donors as $donor)
        <tr>
          <td>{{ $donor->name }}</td>
          <td>{{ $donor->address }}</td>
          <td>{{ $donor->email }}</td>
          <td>{{ $donor->phone }}</td>
          <td>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $donor->id }}" data-backdrop="static" title="সম্পাদনা করুন"><i class="fa fa-pencil"></i></button>
            <!-- Edit Donor Modal -->
            <!-- Edit Donor Modal -->
            <div class="modal fade" id="editModal{{ $donor->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">সম্পাদনা</h4>
                  </div>
                  {!! Form::model($donor, ['route' => ['dashboard.updatedonor', $donor->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            {!! Form::label('name', 'প্রতিষ্ঠানের নাম') !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'প্রতিষ্ঠানের নাম লিখুন', 'required')) !!}
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
                            {!! Form::label('email', 'ইমেইল এড্রেস') !!}
                            {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'ইমেইল এড্রেস লিখুন', 'required')) !!}
                          </div>
                        </div>
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
            <!-- Edit Donor Modal -->
            <!-- Edit Donor Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $donors->links() }}

  <!-- Add Donor Modal -->
  <!-- Add Donor Modal -->
  <div class="modal fade" id="addDonorModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header modal-header-success">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">নতুন Donor (দাতা) যোগ</h4>
        </div>
        {!! Form::open(['route' => 'dashboard.storedonor', 'method' => 'POST', 'class' => 'form-default']) !!}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('name', 'প্রতিষ্ঠানের নাম') !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'প্রতিষ্ঠানের নাম লিখুন', 'required')) !!}
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
                  {!! Form::label('email', 'ইমেইল এড্রেস') !!}
                  {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'ইমেইল এড্রেস লিখুন', 'required')) !!}
                </div>
              </div>
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
  <!-- Add Donor Modal -->
  <!-- Add Donor Modal -->
@stop

@section('js')

@stop