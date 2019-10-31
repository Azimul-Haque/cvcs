@extends('adminlte::page')

@section('title', 'CVCS | দপ্তর সমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
      দপ্তর সমূহ
      <div class="pull-right">
        @if(Auth::user()->role_type == 'admin')
        <a class="btn btn-success" href="#!" title="দপ্তর যোগ করুন (কাজ চলছে...)"><i class="fa fa-fw fa-plus" aria-hidden="true"></i></a> {{-- {{ route('dashboard.createbulkpayer') }} --}}
        @endif
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role_type == 'admin')
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th>নাম</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($offices as $office)
        <tr>
          <td>{{ $office->id }}</td>
          <td>{{ $office->name }}</td>
          <td>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $office->id }}" data-backdrop="static" title="দপ্তর সম্পাদনা করুন"><i class="fa fa-pencil"></i></button>
            <!-- Remove BulK Payer Modal -->
            <!-- Remove BulK Payer Modal -->
            <div class="modal fade" id="editModal{{ $office->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">দপ্তর সম্পাদনা</h4>
                  </div>
                  {!! Form::model($office, ['route' => ['dashboard.office.update', $office->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                        
                  <div class="modal-body">
                    কাজ চলছে...
                  </div>
                  <div class="modal-footer">
                    {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary')) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
            <!-- Remove BulK Payer Modal -->
            <!-- Remove BulK Payer Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $offices->links() }}

  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')

@stop