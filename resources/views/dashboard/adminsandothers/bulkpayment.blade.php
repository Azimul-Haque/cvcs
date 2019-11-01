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
      {!! Form::open(['route' => 'dashboard.storememberpaymentbulk', 'method' => 'POST', 'class' => 'form-default', 'data-parsley-validate' => '', 'enctype' => 'multipart/form-data', 'id' => 'bulkpaymentform']) !!}
      <div class="col-md-7">
        <div class="box box-primary">
          <div class="box-header with-border text-blue">
            <i class="fa fa-fw fa-users"></i>
            <h3 class="box-title"><b>{{ Auth::user()->branch->name }}</b>-এর সদস্য তালিকা</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive" style="height: 600px; overflow: auto; padding: 0px;">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>নাম</th>
                  <th>মেম্বার আইডি</th>
                  <th>যোগাযোগ</th>
                  <th>অফিস তথ্য</th>
                  <th>ছবি</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($members as $member)
                <tr id="member_table_td_{{ $member->member_id }}">
                  <td>{{ $member->name_bangla }}<br/>{{ $member->name }}</td>
                  <td>{{ $member->member_id }}</td>
                  <td><small>{{ $member->mobile }}<br/>{{ $member->email }}</small></td>
                  <td><small>{{ $member->branch->name }}<br/>{{ $member->position->name }}</small></td>
                  <td>
                    @if(file_exists(public_path('images/users/'.$member->image)))
                      <img src="{{ asset('images/users/'.$member->image)}}" style="height: 40px; width: auto;" />
                    @else
                      <img src="{{ asset('images/user.png')}}" style="height: 40px; width: auto;" />
                    @endif
                  </td>
                  <td>
                    <button type="button" class="btn btn-success btn-sm" title="সদস্য যোগ করুন" onclick="addMember({{ $member->member_id }}, {{ $member }})"><i class="fa fa-plus"></i></button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-5">
        <div class="box box-success">
          <div class="box-header with-border text-green">
            <i class="fa fa-fw fa-user-plus"></i>
            <h3 class="box-title">যোগকৃত সদস্য তালিকা</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            {{-- <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#membersModal" data-backdrop="static"><i class="fa fa-plus"></i> সদস্য যোগ করুন</button><br/><br/> --}}

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
            
          </div>
          <!-- /.box-body -->
        </div>
      </div><br/>
      <div class="col-md-7">
        <div class="box box-warning">
          <div class="box-header with-border text-orange">
            <i class="fa fa-fw fa-file-text-o"></i>
            <h3 class="box-title">পরিশোধ ফরম</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="form-group">
              {{-- {!! Form::label('amount', 'পরিমাণ (৳)') !!} --}}
              {!! Form::text('amount', null, array('class' => 'form-control', 'id' => 'amount', 'placeholder' => 'মোট টাকার পরিমাণ লিখুন (৫০০ এর গুণিতকে)', 'required', 'data-parsley-type' => 'number','data-parsley-type-message' => 'সংখ্যায় লিখুন')) !!}
            </div>
            <div class="form-group">
              {{-- {!! Form::label('bank', 'ব্যাংকের নাম') !!} --}}
              {!! Form::text('bank', 'ডাচ বাংলা ব্যাংক', array('class' => 'form-control', 'id' => 'bank', 'placeholder' => 'ব্যাংকের নাম লিখুন', 'required' => '', 'data-parsley-required-message' => 'ব্যাংকের নামটি লিখুন')) !!}
            </div>
            <div class="form-group">
              {{-- {!! Form::label('branch', 'ব্রাঞ্চের নাম') !!} --}}
              {!! Form::text('branch', null, array('class' => 'form-control', 'id' => 'branch', 'placeholder' => 'ব্রাঞ্চের নাম লিখুন', 'required' => '')) !!}
            </div>
            <div class="form-group">
              {{-- {!! Form::label('pay_slip', 'ব্রাঞ্চের নাম') !!} --}}
              {!! Form::text('pay_slip', null, array('class' => 'form-control', 'id' => 'pay_slip', 'placeholder' => 'পে স্লিপ নম্বর লিখুন', 'required' => '')) !!}
            </div>
            <label>রিসিটের ছবি (সর্বোচ্চ ৩টি, ৫০০ কিলোবাইট এর মধ্যে প্রতিটি)</label>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="image1" name="image1" required="">
                            </span>
                        </span>
                        <input type="text" class="form-control text-blue" readonly>
                    </div>
                    <center>
                      <img src="{{ asset('images/800x500.png')}}" id='img-upload1' style="height: 100px; width: auto; padding: 5px;" />
                    </center>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="image2" name="image2">
                            </span>
                        </span>
                        <input type="text" class="form-control text-blue" readonly>
                    </div>
                    <center>
                      <img src="{{ asset('images/800x500.png')}}" id='img-upload2' style="height: 100px; width: auto; padding: 5px;" />
                    </center>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="image3" name="image3">
                            </span>
                        </span>
                        <input type="text" class="form-control text-blue" readonly>
                    </div>
                    <center>
                      <img src="{{ asset('images/800x500.png')}}" id='img-upload3' style="height: 100px; width: auto; padding: 5px;" />
                    </center>
                </div>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#previewFormModal" data-backdrop="static" id="previewFormButton"><i class="fa fa-arrow-right"></i> পরবর্তী পাতা</button>
              <!-- Preview Modal -->
              <!-- Preview Modal -->
              <div class="modal fade" id="previewFormModal" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Preview (প্রাকদর্শন)</h4>
                    </div>
                    <div class="modal-body" id="previewFormModalBody">
                      
                    </div>
                    <div class="modal-footer">
                          {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-primary', 'id' => 'submitBtn')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Preview Modal -->
              <!-- Preview Modal -->
              
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
      $('#amount').blur(function() {
        var value = $('#amount').val();
        if(value == '') {
          if($(window).width() > 768) {
            toastr.info('পরিমাণ ৫০০ এর গুণিতক', 'INFO').css('width', '400px');
          } else {
            toastr.info('পরিমাণ ৫০০ এর গুণিতক', 'INFO').css('width', ($(window).width()-25)+'px');
          }
          $('#submitBtn').attr('disabled', false);
        } else {
          $('#submitBtn').attr('disabled', true);
        }
        if(value % 500 != 0) {
          if($(window).width() > 768) {
            toastr.info('পরিমাণ ৫০০ এর গুণিতকে দিন', 'INFO').css('width', '400px');
          } else {
            toastr.info('পরিমাণ ৫০০ এর গুণিতকে দিন', 'INFO').css('width', ($(window).width()-25)+'px');
          }
          $('#submitBtn').attr('disabled', true);
        } else {
          $('#submitBtn').attr('disabled', false);
        }
      })
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
                      value: item.name_bangla + "|" + item.member_id + "|" + item.mobile,
                      text : item.name_bangla + "-" + item.member_id + "-(☎ " + item.mobile +")"
                  }));
              });
          }
      });
      
      $('#member_select').select2();
    }, 1000);

    $(document).ready( function() {
      $("#bulkpaymentform").submit(function(event) {
          var member_ids_before_submit = $("input[name='amountids[]']")
                  .map(function(){return $(this).val();}).get();
          if(member_ids_before_submit.length == 0) {
            toastr.warning('অন্তত একজন সদস্য নির্বাচন করুন!', 'Warning');
            event.preventDefault();
            $('#submitBtn').attr('disabled', false);
          } else {
            $('#submitBtn').attr('disabled', true);
          }
          // console.log(member_ids_before_submit);

          var add_separate_amounts = 0;
          $('.add_separate_amounts').each(function(){
              add_separate_amounts += parseFloat(this.value);
          });
          // console.log(add_separate_amounts);
          if(add_separate_amounts != $('#amount').val()) {
            toastr.warning('মোট টাকার পরিমাণ এবং সদস্যদের আলাদা করে দেওয়া টাকার পরিমাণ সমান হওয়া বাঞ্ছনীয়!', 'Warning');
            event.preventDefault();
            $('#submitBtn').attr('disabled', false);
          } else {
            $('#submitBtn').attr('disabled', true);
          }
      });
      
    });
    function addMember(member_id, member_data) {
      // console.log(member_data.mobile);
      $('#member_list').append('<div class="row" id="memberRow'+member_data.member_id+'"><div class="col-md-6" id="member_name_preview'+member_data.member_id+'">'+ member_data.name_bangla +', <small>'+ member_data.position.name +'</small><br/><small>ID: '+ member_data.member_id +', ☎ '+ member_data.mobile +'</small></div><div class="col-md-4"><input type="number" class="form-control add_separate_amounts" name="amount'+member_data.member_id+'" id="member_amount_preview'+member_data.member_id+'" placeholder="পরিমাণ" required/></div><div class="col-md-2"><button type="button" class="btn btn-danger btn-sm" title="অপসারণ করুন" onclick="removeMember(memberRow'+member_data.member_id+', amount'+member_data.member_id+', '+member_data.member_id+')"><i class="fa fa-trash"></i></button></div><div class="col-md-12"><input type="hidden" name="amountids[]" id="amountids" value="'+member_data.member_id+'"><hr/></div></div>');
      // $.ajax({
      //     url: '/dashboard/member/payment/bulk/search/single/member/api/'+'/'+member_id,
      //     type: 'GET',
      //     dataType: 'json', // added data type
      //     success: function(item) {
      //         // console.log(item.position.name);
      //         // remove item from members table
      //         // $("#member_table_td_" + member_id).remove();
      //     }
      // });
    }
    $(document).ready( function() {
      $('#add_member_btn').click(function() {
        var member_select = $('#member_select').val();
        if(member_select == null) {
          toastr.warning('সদস্য নির্বাচন করুন!', 'WARNING');
        } else {
          // add member to the box
          var member_data = member_select.split('|');
          console.log(member_data);
          $('#member_list').append('<div class="row" id="memberRow'+member_data[1]+'"><div class="col-md-5" id="member_name_preview'+member_data[1]+'">'+ member_data[0] +'</div><div class="col-md-5"><input type="number" class="form-control add_separate_amounts" name="amount'+member_data[1]+'" id="member_amount_preview'+member_data[1]+'" placeholder="পরিমাণ" required/></div><div class="col-md-2"><button type="button" class="btn btn-danger btn-sm" title="অপসারণ করুন" onclick="removeMember(memberRow'+member_data[1]+', amount'+member_data[1]+', '+member_data[1]+')"><i class="fa fa-trash"></i></button></div><div class="col-md-12"><input type="hidden" name="amountids[]" id="amountids" value="'+member_data[1]+'"><hr/></div></div>');
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
          $("#member_select option[value='"+$('#member_select').val()+"']").remove();
        }
      });

      
    });

    function removeMember(idofmemberrow, idofmemberamount, member_id) {
      $(idofmemberrow).remove();
      $(idofmemberamount).removeAttr('required');

      // remove from amountids field, it automatically does actually from the array amountids

      // append the amountids field
      // $.ajax({
      //     url: '{{ url('/dashboard/member/payment/bulk/search/single/member/api/') }}'+'/'+member_id,
      //     type: 'GET',
      //     dataType: 'json', // added data type
      //     success: function(item) {
      //         // console.log(item);
      //         $('#member_select').append($('<option>', { 
      //             value: item.name_bangla + "|" + item.member_id + "|" + item.mobile,
      //             text : item.name_bangla + "-" + item.member_id + "-(☎ " + item.mobile +")"
      //         }));
      //     }
      // });
      
    }

    $(document).ready(function() {
      $('#previewFormButton').click(function() {
        var preview_html = '';
        preview_html += '<div class="table-responsive">';
        preview_html += ' <table class="table">';
        preview_html += '   <thead><tr>';
        preview_html += '     <th>জমাদানকারী</th>';
        preview_html += '     <th>মোট টাকার পরিমাণ (৳)</th>';
        preview_html += '     <th>ব্যাংক</th>';
        preview_html += '     <th>ব্রাঞ্চ/শাখা</th>';
        preview_html += '     <th>পে স্লিপ নম্বর</th>';
        preview_html += '   </tr></thead>';
        preview_html += '   <tbody><tr>';
        preview_html += '     <td>{{ Auth::user()->name_bangla }}</td>';
        preview_html += '     <td>৳ '+ $('#amount').val() +'</td>';
        preview_html += '     <td>'+ $('#bank').val() +'</td>';
        preview_html += '     <td>'+ $('#branch').val() +'</td>';
        preview_html += '     <td>'+ $('#pay_slip').val() +'</td>';
        preview_html += '   </tr></tbody>';
        preview_html += '  </table>';
        preview_html += '</div>';

        

        var selected_members_preview = $("input[name='amountids[]']").map(function(){return $(this).val();}).get();

        if(selected_members_preview.length > 0) {
          preview_html += '<div class="table-responsive">';
          preview_html += ' <table class="table">';
          preview_html += '   <thead><tr>';
          preview_html += '     <th>সদস্য</th>';
          preview_html += '     <th>টাকার পরিমাণ (৳)</th>';
          preview_html += '   </tr></thead><tbody>';
          
          selected_members_preview.forEach(function(item) {
              preview_html += '   <tr>';
              preview_html += '     <td>' + $('#member_name_preview'+item).text() + '</td>';
              preview_html += '     <td>৳ ' + $('#member_amount_preview'+item).val() + '</td>';
              preview_html += '   </tr>';
          });

          preview_html += '  </tbody></table>';
          preview_html += '</div>';
        }
        

        if(!$('#img-upload1').attr('src').includes('images/800x500.png')) {
          preview_html += '<br/><img class="img-responsive" src="' +$('#img-upload1').attr('src')+ '">';
        }
        if(!$('#img-upload2').attr('src').includes('images/800x500.png')) {
          preview_html += '<br/><img class="img-responsive" src="' +$('#img-upload2').attr('src')+ '">';
        }
        if(!$('#img-upload3').attr('src').includes('images/800x500.png')) {
          preview_html += '<br/><img class="img-responsive" src="' +$('#img-upload3').attr('src')+ '">';
        }

        document.getElementById('previewFormModalBody').innerHTML = preview_html;

      })
    })
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
      function readURL1(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload1').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image1").change(function(){
          readURL1(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 500) {
            $("#image1").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload1").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
      function readURL2(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload2').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image2").change(function(){
          readURL2(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 500) {
            $("#image2").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload2").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
      function readURL3(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#img-upload3').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#image3").change(function(){
          readURL3(this);
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 500) {
            $("#image3").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload3").attr('src', '{{ asset('images/800x500.png') }}');
              }, 1000);
          }
      });
    });
  </script>
@stop