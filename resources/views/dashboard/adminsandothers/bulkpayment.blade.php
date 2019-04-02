@extends('adminlte::page')

@section('title', 'CVCS | একাধিক সদস্যের পরিশোধ')

@section('css')
  {!!Html::style('css/parsley.css')!!}
@stop

@section('content_header')
    <h1>
      একাধিক সদস্যের পরিশোধ
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'bulkpayer'))
  	<div class="row">
      {!! Form::open(['route' => 'dashboard.storememberpaymentbulk', 'method' => 'POST', 'class' => 'form-default', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data']) !!}
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">পরিশোধ ফরম</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="form-group">
              {{-- {!! Form::label('amount', 'পরিমাণ (৳)') !!} --}}
              {!! Form::text('amount', null, array('class' => 'form-control', 'id' => 'amount', 'placeholder' => 'টাকার পরিমাণ লিখুন (৫০০ এর গুণিতকে)', 'required', 'data-parsley-type' => 'number','data-parsley-type-message' => 'সংখ্যায় লিখুন')) !!}
            </div>
            <div class="form-group">
              {{-- {!! Form::label('bank', 'ব্যাংকের নাম') !!} --}}
              {!! Form::text('bank', null, array('class' => 'form-control', 'id' => 'amount', 'placeholder' => 'ব্যাংকের নাম লিখুন', 'required' => '', 'data-parsley-required-message' => 'ব্যাংকের নামটি লিখুন')) !!}
            </div>
            <div class="form-group">
              {{-- {!! Form::label('branch', 'ব্রাঞ্চের নাম') !!} --}}
              {!! Form::text('branch', null, array('class' => 'form-control', 'id' => 'amount', 'placeholder' => 'ব্রাঞ্চের নাম লিখুন', 'required' => '')) !!}
            </div>
            <label>রিসিটের ছবি (সর্বোচ্চ ৩টি, ৫০০ কিলোবাইট এর মধ্যে প্রতিটি)</label>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
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
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="image" name="image">
                            </span>
                        </span>
                        <input type="text" class="form-control text-blue" readonly>
                    </div>
                    <center>
                      <img src="{{ asset('images/800x500.png')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                    </center>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="image" name="image">
                            </span>
                        </span>
                        <input type="text" class="form-control text-blue" readonly>
                    </div>
                    <center>
                      <img src="{{ asset('images/800x500.png')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                    </center>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-users"></i>
            <h3 class="box-title">সদস্য তালিকা</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#membersModal" data-backdrop="static"><i class="fa fa-plus"></i> সদস্য যোগ করুন</button><br/><br/>

            <div id="member_list"></div>

            <!-- Add Member Modal -->
            <!-- Add Member Modal -->
            <div class="modal fade" id="membersModal" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">সদস্য নির্বাচন করুন</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="member_id">সদস্য নির্বাচন করুন</label><br/>
                      <select class="form-control" name="member_select" id="member_select" data-placeholder="সদস্য নির্বাচন করুন">
                        <option value="" disabled="" selected="">মেম্বার আইডি/নাম/মোবাইল নম্বর</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="add_member_btn">যোগ করুন</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Add Member Modal -->
            <!-- Add Member Modal -->
            {{-- {!! Form::hidden('member_ids', null, ['id' => 'member_ids', 'required' => '']) !!} --}}
            <br/><br/>
            <div class="form-group">
              {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary', 'id' => 'submitBtn')) !!}
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
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
  <script type="text/javascript">
    setTimeout(function() {
      $.ajax({
          url: '{{ url('/dashboard/member/payment/bulk/search/api') }}',
          type: 'GET',
          dataType: 'json', // added data type
          success: function(items) {
              // console.log(items);
              $.each(items, function (i, item) {
                  $('#member_select').append($('<option>', { 
                      value: item.name_bangla + "|" + item.member_id,
                      text : item.name_bangla + "-" + item.member_id + "-(☎ " + item.mobile +")"
                  }));
              });
          }
      });
      
      $('#member_select').select2();
    }, 1000);

  </script>
  <script type="text/javascript">
    $(document).ready( function() {
      $('#add_member_btn').click(function() {
        var member_select = $('#member_select').val();
        if(member_select == null) {
          toastr.warning('সদস্য নির্বাচন করুন!', 'WARNING');
        } else {
          // add member to the box
          var member_data = member_select.split('|');
          console.log(member_data);
          $('#member_list').append('<div class="row" id="memberRow'+member_data[1]+'"><div class="col-md-5">'+ member_data[0] +'</div><div class="col-md-5"><input type="number" class="form-control" name="amount'+member_data[1]+'" required/></div><div class="col-md-2"><button type="button" class="btn btn-danger btn-sm" title="অপসারণ করুন" onclick="removeMember(memberRow'+member_data[1]+', amount'+member_data[1]+')"><i class="fa fa-trash"></i></button></div><div class="col-md-12"><input type="hidden" name="amountids[]" id="amountids" value="'+member_data[1]+'"><hr/></div></div>');
          $('#membersModal').modal('toggle');

          // append the amountids field
          // var selected_members = [];
          // $("input[name='amountids[]']").each(function (){
          //     selected_members.push($(this).val());
          // });
          // $('#member_ids').val(selected_members);
          // if($('#member_ids').val() == '') {
          //   toastr.warning('অন্তত একজন সদস্য নির্বাচন করুন!', 'Warning');
          // } else {

          // }

          // remove item from select options
          // $("#member_select option[value='"+$('#member_select').val()+"']").remove();
        }
      });

      
    });

    function removeMember(idofmemberrow, idofmemberamount) {
      $(idofmemberrow).remove();
      $(idofmemberamount).removeAttr('required');

      // remove from amountids field
      // append the amountids field
      var selected_members = [];
      $("input[name='amountids[]']").each(function (){
          selected_members.push($(this).val());
      });
      $('#member_ids').val(selected_members);
      if($('#member_ids').val() == '') {
        toastr.warning('অন্তত একজন সদস্য নির্বাচন করুন!', 'Warning');
      } else {

      }
    }
  </script>
@stop