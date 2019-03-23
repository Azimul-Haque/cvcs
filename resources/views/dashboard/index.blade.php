@extends('adminlte::page')

@section('title', 'CVCS')

@section('content_header')
    <h1><i class="fa fa-cogs"></i> Dashboard (Homepage Customization)</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">About Text (CVCS সম্পর্কে)</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($about, ['route' => ['dashboard.updateabouts', $about->id], 'method' => 'PUT']) !!}
              <div class="form-group">
                <label>Text:</label>
                {!! Form::textarea('text', null, array('class' => 'form-control text-blue textarea', 'required' => '', 'placeholder' => 'Write About CVCS')) !!}
              </div>
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box box-primary">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">What we do (আমরা যা করি)</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($whatwedo, ['route' => ['dashboard.updateabouts', $whatwedo->id], 'method' => 'PUT']) !!}
              <div class="form-group">
                <label>Text:</label>
                {!! Form::textarea('text', null, array('class' => 'form-control text-blue textarea', 'required' => '', 'placeholder' => 'Write About CVCS')) !!}
              </div>
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box box-primary">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">Membership (সদস্যপদ)</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($membership, ['route' => ['dashboard.updateabouts', $membership->id], 'method' => 'PUT']) !!}
              <div class="form-group">
                <label>Text:</label>
                {!! Form::textarea('text', null, array('class' => 'form-control text-blue textarea', 'required' => '', 'placeholder' => 'Write About CVCS')) !!}
              </div>
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">Who we are (আমরা কারা)</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($whoweare, ['route' => ['dashboard.updateabouts', $whoweare->id], 'method' => 'PUT']) !!}
              <div class="form-group">
                <label>Text:</label>
                {!! Form::textarea('text', null, array('class' => 'form-control text-green textarea', 'required' => '', 'placeholder' => 'Write About CVCS')) !!}
              </div>
            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">At a Glance (এক নজরে)</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($ataglance, ['route' => ['dashboard.updateabouts', $ataglance->id], 'method' => 'PUT']) !!}
              <div class="form-group">
                <label>Text:</label>
                {!! Form::textarea('text', null, array('class' => 'form-control text-green textarea', 'required' => '', 'placeholder' => 'Write About CVCS')) !!}
              </div>
            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
@stop