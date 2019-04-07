@extends('adminlte::master')
@section('title')
    CVCS | পাসওয়ার্ড রিসেট
@endsection
@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg"><b>{{ $mobile }}</b>-নম্বরে পাঠানো ৬ ডিজিটের কোডটি দিন</p>
            <form action="{{ route('index.mobileresetverifycode') }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <input type="text" name="mobile" class="form-control" value="{{ $mobile }}" placeholder="সংশ্লিষ্ট ১১ ডিজিট মোবাইল নম্বর" readonly="" required="">
                </div>
                <div class="form-group">
                    <input type="text" name="security_code" class="form-control" placeholder="SMS-এ পাওয়া সিকিউরিটি কোডটি লিখুন" required="">
                </div>
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >দাখিল করুন</button>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop
