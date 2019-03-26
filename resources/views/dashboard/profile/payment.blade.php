@extends('adminlte::page')

@section('title', 'CVCS | সদস্য তথ্য')

@section('css')

@stop

@section('content_header')
    <h1>
      পরিশোধ
      <div class="pull-right">
        @if(Auth::user()->activation_status == 0)
          
        @else
          <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal" data-backdrop="static" title="শুধু নিজের টাকা পরিশোধ করুন"><i class="fa fa-fw fa-user" aria-hidden="true"></i></button>
          <button class="btn btn-danger" data-toggle="modal" data-target="#deleteMemberModal" data-backdrop="static" title="একাধিক সদস্যের টাকা পরিশোধ করুন"><i class="fa fa-fw fa-users" aria-hidden="true"></i></button>
        @endif
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->activation_status == 0)
    <p class="text-danger">আপনার একাউন্টটি এখনও প্রক্রিয়াধীন রয়েছে। অনুমোদিত হলে আপনাকে SMS-এ জানানো হবে। একাউন্টটি সচল হলে এই পাতার সকল তথ্য ব্যবহার করতে পারবেন।</p>
  @else

  @endif
@stop

@section('js')

@stop