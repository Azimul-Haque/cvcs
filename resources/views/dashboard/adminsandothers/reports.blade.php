@extends('adminlte::page')

@section('title', 'CVCS | রিপোর্ট')

@section('css')

@stop

@section('content_header')
    <h1>
      রিপোর্ট
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role == 'admin')
    কাজ চলছে...
  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')

@stop