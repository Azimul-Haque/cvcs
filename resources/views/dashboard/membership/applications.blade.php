@extends('adminlte::page')

@section('title', 'CVCS | আবেদনসমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
      আবেদনসমূহ
      <div class="pull-right">
        <a class="btn btn-success" href="{{ route('index.application') }}" target="_blank"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Member</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>নাম</th>
          <th>যোগাযোগের নম্বর ও ইমেইল এড্রেস</th>
          <th>অফিস তথ্য</th>
          <th>পরিশোধ তথ্য</th>
          <th>ছবি</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($applications as $application)
        <tr>
          <td>
            <a href="{{ route('dashboard.singleapplication', $application->unique_key) }}" title="আবেদনটি দেখুন">
              {{ $application->name_bangla }}<br/>{{ $application->name }}
            </a>
          </td>
          <td>{{ $application->mobile }}<br/>{{ $application->email }}</td>
          <td>{{ $application->office }}<br/>{{ $application->profession }} ({{ $application->designation }})</td>
          <td>৳ {{ $application->application_payment_amount }}<br/>{{ $application->application_payment_bank }} ({{ $application->application_payment_branch }})</td>
          <td>
            @if($application->image != null)
              <img src="{{ asset('images/users/'.$application->image)}}" style="height: 50px; width: auto;" />
            @else
              <img src="{{ asset('images/user.png')}}" style="height: 50px; width: auto;" />
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-success" href="{{ route('dashboard.singleapplication', $application->unique_key) }}" title="আবেদনটি দেখুন"><i class="fa fa-eye"></i></a>
            {{-- <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $application->id }}" data-backdrop="static"><i class="fa fa-trash-o"></i></button> --}}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $applications->links() }}
@stop

@section('js')

@stop