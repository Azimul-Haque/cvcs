@extends('layouts.index')
@section('title')
    IIT Alumni | Login
@endsection

@section('css')

@endsection

@section('content')
    <section class="wow fadeIn bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-10 col-xs-11 center-col login-box">
                    <!-- form title  -->
                    <h1 style="text-align: center">Login</h1>
                    <!-- end form title  -->
                    <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                    {!! csrf_field() !!}
                        <div class="form-group no-margin-bottom">
                            <!-- label  -->
                            <label for="email" class="text-uppercase">Email</label>
                            <!-- end label  -->
                            <!-- input  -->
                            <input type="text" name="email" id="email">
                            <!-- end input  -->
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group no-margin-bottom">
                            <!-- label  -->
                            <label for="password" class="text-uppercase">Password</label>
                            <!-- end label  -->
                            <!-- input  -->
                            <input type="password" name="password" id="password">
                            <!-- end input  -->
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="checkbox margin-five">
                            <!-- checkbox  -->
                            <label>
                                <input type="checkbox"> Remember Me</label>
                            <!-- end checkbox  -->
                        </div>
                        <button class="btn highlight-button-dark btn-small btn-round margin-five no-margin-right" type="submit">Login</button>
                        <a href="#" class="display-block text-uppercase margin-five">Forgot Password?</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

@endsection