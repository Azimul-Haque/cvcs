@extends('adminlte::page')

@section('title', 'CVCS | আবেদনসমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
      আবেদনসমূহ ({{ bangla($applicationscount) }}টি)
      <div class="pull-right">
        <a class="btn btn-success" href="{{ route('index.application') }}" target="_blank"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> সদস্য যোগ করুন</a>
      </div>
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <input type="text" id="search" class="form-control" placeholder="&#xF002; খুঁজুন (কমপক্ষে ৫ টি সংখ্যা বা অক্ষর লিখুন)" style="font-family:Arial, FontAwesome"><br/>
    </div>
    <div class="col-md-6">
      <span style="color: #008D4C;" id="total_records"></span>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered" id="searchTable">
      <thead>
        <tr>
          <th>নাম</th>
          <th>যোগাযোগের নম্বর ও ইমেইল এড্রেস</th>
          <th>অফিস তথ্য</th>
          <th>পরিশোধ তথ্য</th>
          <th>ছবি</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
     <tbody id="searchtbody">

     </tbody>
    </table>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered" id="mainTable">
      <thead>
        <tr>
          <th>নাম</th>
          <th>যোগাযোগের নম্বর ও ইমেইল এড্রেস</th>
          <th>অফিস তথ্য</th>
          <th>পরিশোধ তথ্য</th>
          <th>ছবি</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($applications as $application)
        <tr>
          <td>
            <a href="{{ route('dashboard.singleapplication', $application->unique_key) }}" title="আবেদনটি দেখুন">
              {{ $application->name_bangla }}<br/>{{ $application->name }}
            </a>
          </td>
          <td>{{ $application->mobile }}<br/>{{ $application->email }}</td>
          <td>{{ $application->office }}<br/>{{ $application->profession }} ({{ $application->designation }})</td>
          <td>৳ {{ $application->application_payment_amount }}<br/>{{ $application->application_payment_bank }} ({{ $application->application_payment_branch }})</td>
          <td>
            @if($application->image != null)
              <img src="{{ asset('images/users/'.$application->image)}}" style="height: 50px; width: auto;" />
            @else
              <img src="{{ asset('images/user.png')}}" style="height: 50px; width: auto;" />
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-success" href="{{ route('dashboard.singleapplication', $application->unique_key) }}" title="আবেদনটি দেখুন"><i class="fa fa-eye"></i></a>
            <a class="btn btn-sm btn-primary" href="{{ route('dashboard.singleapplicationedit', $application->unique_key) }}" title="আবেদনটি সম্পাদনা করুণ"><i class="fa fa-edit"></i></a>
            {{-- <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $application->id }}" data-backdrop="static"><i class="fa fa-trash-o"></i></button> --}}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div id="mainLink">
    {{ $applications->links() }}
  </div>
@stop

@section('js')
  <script>
    $(document).ready(function(){
     $('#searchTable').hide();
     function searchMember(query = '')
     {
      $.ajax({
       url:"{{ route('dashboard.applicationsearchapi') }}",
       method:'GET',
       data:{query:query},
       dataType:'json',
       success:function(data)
       {
        $('#searchtbody').html(data.table_data);
        $('#total_records').text(data.total_data);
       }
      })
     }

     $(document).on('keyup', '#search', function(){
      var query = $(this).val();
      if(query.length == 0) {
        $('#searchTable').hide();
        $('#total_records').hide();
        $('#mainTable').show();
        $('#mainLink').show();
      } else {
        if(query.length < 5) {

        } else {
          $('#mainTable').hide();
          $('#mainLink').hide();
          $('#searchTable').show();
          $('#total_records').show();
          searchMember(query);
        }
      }
      
     });
    });
  </script>
@stop