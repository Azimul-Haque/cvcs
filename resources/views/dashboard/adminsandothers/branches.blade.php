@extends('adminlte::page')

@section('title', 'CVCS | দপ্তর সমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
      দপ্তর সমূহ
      <div class="pull-right">
        @if(Auth::user()->role == 'admin')
        <a class="btn btn-success" href="#!" title="দপ্তর যোগ করুন (কাজ চলছে...)"><i class="fa fa-fw fa-plus" aria-hidden="true"></i></a> {{-- {{ route('dashboard.createbulkpayer') }} --}}
        @endif
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role == 'admin')
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th>নাম</th>
          <th>সদস্য সংখ্যা</th>
          <th>ঠিকানা</th>
          <th width="15%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($branches as $branch)
        <tr>
          <td>{{ bangla($branch->id) }}</td>
          <td><a href="{{ route('dashboard.branch.members', $branch->id) }}">{{ $branch->name }}</a></td>
          <td>{{ bangla($branch->users->where('activation_status', 1)->count()) }} জন</td>
          <td>{{ $branch->address }}</td>
          <td>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $branch->id }}" data-backdrop="static" title="দপ্তর সম্পাদনা করুন"><i class="fa fa-pencil"></i></button>
            <a href="{{ route('dashboard.branch.members', $branch->id) }}" class="btn btn-sm btn-success" title="দপ্তরের সদস্য দেখুন">
              <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('dashboard.bulkpaymentofbranch', $branch->id) }}" class="btn btn-sm btn-warning" title="দপ্তরের একাধিক পরিশোধ করুন">
              <i class="fa fa-cubes"></i>
            </a>
            <!-- Remove BulK Payer Modal -->
            <!-- Remove BulK Payer Modal -->
            <div class="modal fade" id="editModal{{ $branch->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">দপ্তর সম্পাদনা</h4>
                  </div>
                  {!! Form::model($branch, ['route' => ['dashboard.updatebranch', $branch->id], 'method' => 'PUT', 'class' => 'form-default']) !!}
                        
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
            <a href="{{ url('dashboard/reports/export/branch/members/list/pdf?branch_id=' . $branch->id) }}" class="btn btn-sm btn-info" title="সদস্য তালিকা ডাউনলোড করুন">
              <i class="fa fa-download"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $branches->links() }}

  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')

@stop