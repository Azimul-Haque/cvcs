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
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Contact No & Email</th>
        <th>Office Info</th>
        <th>Photo</th>
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
  {{ $applications->links() }}
@stop

@section('js')

@stop