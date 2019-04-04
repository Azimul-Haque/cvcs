@extends('adminlte::page')

@section('title', 'CVCS | সদস্য পরিশোধ')

@section('css')
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      পরিশোধ (শুধু নিজের)
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
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
            {!! Form::open(['route' => 'dashboard.storememberpaymentself', 'method' => 'POST', 'class' => 'form-default', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data']) !!}
              {!! Form::hidden('member_id', Auth::user()->member_id) !!}
              <div class="form-group">
                {{-- {!! Form::label('amount', 'পরিমাণ (৳)') !!} --}}
                {!! Form::text('amount', null, array('class' => 'form-control', 'id' => 'amount', 'placeholder' => 'টাকার পরিমাণ লিখুন (৫০০ এর গুণিতকে)', 'required', 'data-parsley-type' => 'number','data-parsley-type-message' => 'সংখ্যায় লিখুন')) !!}
              </div>
              <div class="form-group">
                {{-- {!! Form::label('bank', 'ব্যাংকের নাম') !!} --}}
                {!! Form::text('bank', null, array('class' => 'form-control', 'id' => 'bank', 'placeholder' => 'ব্যাংকের নাম লিখুন', 'required' => '', 'data-parsley-required-message' => 'ব্যাংকের নামটি লিখুন')) !!}
              </div>
              <div class="form-group">
                {{-- {!! Form::label('branch', 'ব্রাঞ্চের নাম') !!} --}}
                {!! Form::text('branch', null, array('class' => 'form-control', 'id' => 'branch', 'placeholder' => 'ব্রাঞ্চের নাম লিখুন', 'required' => '')) !!}
              </div>
              <div class="form-group">
                {{-- {!! Form::label('pay_slip', 'ব্রাঞ্চের নাম') !!} --}}
                {!! Form::text('pay_slip', null, array('class' => 'form-control', 'id' => 'pay_slip', 'placeholder' => 'পে স্লিপ নম্বর লিখুন', 'required' => '')) !!}
              </div>
              <div class="form-group">
                  <label>রিসিটের ছবি (সর্বোচ্চ ৫০০ কিলোবাইট)</label>
                  <div class="input-group">
                      <span class="input-group-btn">
                          <span class="btn btn-default btn-file">
                              Browse <input type="file" id="image" name="image" required="">
                          </span>
                      </span>
                      <input type="text" class="form-control text-blue" readonly>
                  </div>
                  <center>
                    <img src="{{ asset('images/800x500.png')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                  </center>
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
@stop

@section('js')
  {!!Html::script('js/parsley.min.js')!!}
  <script type="text/javascript">
    $(document).ready( function() {
      $('#amount').keyup(function() {
        var value = $('#amount').val();
        if(value % 500 == 0) {
          if($(window).width() > 768) {
            toastr.success('পরিমাণ ৫০০ এর গুণিতক', 'SUCCESS').css('width', '400px');
          } else {
            toastr.success('পরিমাণ ৫০০ এর গুণিতক', 'SUCCESS').css('width', ($(window).width()-25)+'px');
          }
          $('#submitBtn').attr('disabled', false);
        } else {
          if($(window).width() > 768) {
            toastr.info('পরিমাণ ৫০০ এর গুণিতকে দিন', 'INFO').css('width', '400px');
          } else {
            toastr.info('পরিমাণ ৫০০ এর গুণিতকে দিন', 'INFO').css('width', ($(window).width()-25)+'px');
          }
          $('#submitBtn').attr('disabled', true);
        }
      })
    });
  </script>
  <script type="text/javascript">
    $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
      });

      $('.btn-file :file').on('fileselect', function(event, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = label;
          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
      });
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image").change(function(){
          readURL(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 500) {
            $("#image").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
    });
  </script>
@stop