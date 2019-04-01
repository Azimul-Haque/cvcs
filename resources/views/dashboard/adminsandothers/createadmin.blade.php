@extends('adminlte::page')

@section('title', 'CVCS | অ্যাডমিন নির্ধারণ')

@section('css')

@stop

@section('content_header')
    <h1>
      অ্যাডমিন নির্ধারণ
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role_type == 'admin')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-key"></i>
          <h3 class="box-title">অ্যাডমিন সিলেক্ট করুন</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route' => 'dashboard.addadmin', 'method' => 'POST']) !!}
            <div class="form-group">
              <label for="member_id">সদস্য নির্বাচন করুন</label>
              <select class="form-control" name="member_id" id="member_id" data-placeholder="সদস্য নির্বাচন করুন" required>
                <option value="0" disabled="" selected="">মেম্বার আইডি/নাম/মোবাইল নম্বর</option>
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-success" type="submit"><i class="fa fa-user-secret"></i> অ্যাডমিন নিয়োগ দিন</button>
            </div>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>

  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')
  <script type="text/javascript">
    setTimeout(function() {
      $.ajax({
          url: '{{ url('/dashboard/admins/search') }}',
          type: 'GET',
          dataType: 'json', // added data type
          success: function(items) {
              // console.log(items);
              $.each(items, function (i, item) {
                  $('#member_id').append($('<option>', { 
                      value: item.member_id,
                      text : item.name_bangla + "-" + item.member_id + "-(☎ " + item.mobile +")"
                  }));
              });
          }
      });

      $('#member_id').select2();
    }, 1000);

  </script>
@stop