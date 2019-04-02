@extends('adminlte::page')

@section('title', 'CVCS | তথ্য এবং টেক্সট')

@section('content_header')
    <h1><i class="fa fa-pic"></i> তথ্য এবং টেক্সট</h1>
@stop

@section('content')
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">Basic Information</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($basicinfo, ['route' => ['dashboard.updatebasicinfo', $basicinfo->id], 'method' => 'PUT']) !!}
              <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                {!! Form::text('address', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Write Address')) !!}
              </div>
              <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                {!! Form::text('contactno', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Write Contact No')) !!}
              </div>
              <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                {!! Form::text('email', null, array('class' => 'form-control text-blue', 'required' => '', 'placeholder' => 'Write Email Address')) !!}
              </div>
              <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-facebook-official"></i></span>
                {!! Form::text('fb', null, array('class' => 'form-control text-blue', 'placeholder' => 'Write Facebook Page Url (Optional)')) !!}
              </div>
              <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                {!! Form::text('twitter', null, array('class' => 'form-control text-blue', 'placeholder' => 'Write Twitter Page Url (Optional)')) !!}
              </div>
              <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                {!! Form::text('gplus', null, array('class' => 'form-control text-blue', 'placeholder' => 'Write Google Plus Page Url (Optional)')) !!}
              </div>
              <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                {!! Form::text('ytube', null, array('class' => 'form-control text-blue', 'placeholder' => 'Write YouTube Channel Url (Optional)')) !!}
              </div>
              <div class="input-group form-group">
                <span class="input-group-addon"><i class="fa fa-linkedin-square"></i></span>
                {!! Form::text('linkedin', null, array('class' => 'form-control text-blue', 'placeholder' => 'Write LinkedIn Page Url (Optional)')) !!}
              </div>
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
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
                {!! Form::textarea('text', str_replace('<br />', "", $about->text), array('class' => 'form-control text-blue textarea', 'required' => '', 'placeholder' => 'সিভিসিএস-এর ব্যাপারে লিখুন')) !!}
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
                {!! Form::textarea('text', str_replace('<br />', "", $whatwedo->text), array('class' => 'form-control text-blue textarea', 'required' => '', 'placeholder' => 'আমরা যা করি লিখুন')) !!}
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
            <h3 class="box-title">সংক্ষিপ্ত ইতিহাস</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($whoweare, ['route' => ['dashboard.updateabouts', $whoweare->id], 'method' => 'PUT']) !!}
              <div class="form-group">
                <label>Text:</label>
                {!! Form::textarea('text', str_replace('<br />', "", $whoweare->text), array('class' => 'form-control text-green textarea', 'required' => '', 'placeholder' => 'আমরা কারা লিখুন')) !!}
              </div>
            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">Membership (সদস্যপদ)</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($membership, ['route' => ['dashboard.updateabouts', $membership->id], 'method' => 'PUT']) !!}
              <div class="form-group">
                <label>Text:</label>
                {!! Form::textarea('text', str_replace('<br />', "", $membership->text), array('class' => 'form-control text-green textarea', 'required' => '', 'placeholder' => 'সদস্যপদ সম্পর্কে লিখুন')) !!}
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
                {!! Form::textarea('text', str_replace('<br />', "", $ataglance->text), array('class' => 'form-control text-green textarea', 'required' => '', 'placeholder' => 'এক নজরে লিখুন')) !!}
              </div>
            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">মিশন ও ভিশন</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {!! Form::model($mission, ['route' => ['dashboard.updateabouts', $mission->id], 'method' => 'PUT']) !!}
              <div class="form-group">
                <label>Text:</label>
                {!! Form::textarea('text', str_replace('<br />', "", $mission->text) , array('placeholder' => 'মিশন ও ভিশন লিখুন','class' => 'form-control text-green textarea', 'autocomplete' => 'off')) !!}
              </div>
            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-fw fa-floppy-o" aria-hidden="true"></i> Submit</button>
            {!! Form::close() !!}
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
@stop