@extends('adminlte::page')

@section('title', 'CVCS | সদস্য খুঁজুন')

@section('css')

@stop

@section('content_header')
    <h1>
      সদস্য খুঁজুন
      <div class="pull-right">
        
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border text-blue">
          <i class="fa fa-fw fa-search"></i>
          <h3 class="box-title">সদস্য খুঁজুন</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <label for="search_member">সদস্য তথ্য দিন</label>
            <select class="form-control" name="search_member" id="search_member" data-placeholder="সদস্য নির্বাচন করুন" required>
              <option value="0" disabled="" selected="">মেম্বার আইডি/নাম/মোবাইল নম্বর</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-success" type="submit" id="submitBtn"><i class="fa fa-search"></i> প্রোফাইল দেখুন</button>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
@stop

@section('js')
  <script type="text/javascript">
    setTimeout(function() {
      $.ajax({
          url: '{{ url('/dashboard/member/search/api') }}',
          type: 'GET',
          dataType: 'json', // added data type
          success: function(items) {
              // console.log(items);
              $.each(items, function (i, item) {
                  $('#search_member').append($('<option>', { 
                      value: item.unique_key,
                      text : item.name_bangla + "-" + item.member_id + "-(☎ " + item.mobile +")"
                  }));
              });
          }
      });

      $('#search_member').select2();
    }, 1000);

    $('#submitBtn').click(function() {
      var search_member = $('#search_member').val();
      if(search_member == null || search_member == ''){
        toastr.warning('একজন সদস্য সিলেক্ট করুন!', 'WARNING').css('width', '400px;');
      } else {
        var newURL = window.location.protocol + "//" + window.location.host + "/dashboard/member/single/" + search_member;
        window.location.replace(newURL);
      }
    })

  </script>
@stop