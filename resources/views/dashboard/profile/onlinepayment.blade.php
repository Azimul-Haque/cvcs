@extends('adminlte::page')

@section('title', 'CVCS | সদস্য অনলাইন পরিশোধ')

@section('css')
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      অনলাইন পরিশোধ (শুধু নিজের)
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role_type != 'admin')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-file-text-o"></i>
          <h3 class="box-title">পরিশোধ ফরম</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          @if(Auth::user()->activation_status == 0)
            <p class="text-danger">আপনার একাউন্টটি এখনও প্রক্রিয়াধীন রয়েছে। অনুমোদিত হলে আপনাকে SMS-এ জানানো হবে। একাউন্টটি সচল হলে এই পাতার সকল তথ্য ব্যবহার করতে পারবেন।</p>
          @else
            {!! Form::open(['route' => 'dashboard.storememberonlinepaymentself', 'method' => 'POST', 'class' => 'form-default', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data']) !!}
              {!! Form::hidden('member_id', Auth::user()->member_id) !!}
              <div class="form-group">
                {{-- {!! Form::label('amount', 'পরিমাণ (৳)') !!} --}}
                {!! Form::text('amount', null, array('class' => 'form-control', 'id' => 'amount', 'placeholder' => 'টাকার পরিমাণ লিখুন (৩০০ বা এর থেকে বেশি)', 'required', 'data-parsley-type' => 'number','data-parsley-type-message' => 'সংখ্যায় লিখুন')) !!}
              </div>
              {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary', 'id' => 'submitBtn')) !!}
            {!! Form::close() !!}
          @endif
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
  @endif
@stop

@section('js')
  {!!Html::script('js/parsley.min.js')!!}
  <script type="text/javascript">
    $(document).ready( function() {

      $('form').submit(function() {
        $('#submitBtn').attr('disabled', true);
      });

      $('#amount').blur(function() {
        var value = $('#amount').val();
        if(value == '') {
          if($(window).width() > 768) {
            toastr.info('পরিমাণ ৩০০ বা এর থেকে বেশি দিন', 'INFO').css('width', '400px');
          } else {
            toastr.info('পরিমাণ ৩০০ বা এর থেকে বেশি দিন', 'INFO').css('width', ($(window).width()-25)+'px');
          }
          $('#submitBtn').attr('disabled', false);
        } else {
          $('#submitBtn').attr('disabled', true);
        }
        //EDIT HOBE EKHANE
        //EDIT HOBE EKHANE
        //EDIT HOBE EKHANE
        if(value < 5) {
          if($(window).width() > 768) {
            toastr.info('পরিমাণ ৩০০ বা এর থেকে বেশি দিন', 'INFO').css('width', '400px');
          } else {
            toastr.info('পরিমাণ ৩০০ বা এর থেকে বেশি দিন', 'INFO').css('width', ($(window).width()-25)+'px');
          }
          $('#submitBtn').attr('disabled', true);
        } else {
          $('#submitBtn').attr('disabled', false);
        }
      })
    });
  </script>
@stop