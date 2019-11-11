@extends('adminlte::page')

@section('title', 'CVCS | '. $branch->name .'-এর সদস্যগণ')

@section('css')

@stop

@section('content_header')
  @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'manager') || (Auth::user()->role_type == 'bulkpayer'))
    <h1>
      <b>{{ $branch->name }}</b>-এর সদস্যগণ ({{ bangla($memberscount) }} জন)
      <div class="pull-right">
        
        {{-- <a class="btn btn-success" href="{{ route('dashboard.members.search') }}"><i class="fa fa-fw fa-search" aria-hidden="true"></i> সদস্য খুঁজুন</a> --}}
      </div>
    </h1>
  @endif
@stop

@section('content')
  @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'manager') || (Auth::user()->role_type == 'bulkpayer'))
    {{-- <div class="row">
      <div class="col-md-6">
        <input type="text" id="search" class="form-control" placeholder="&#xF002; খুঁজুন (কমপক্ষে ৫ টি সংখ্যা বা অক্ষর লিখুন)" style="font-family:Arial, FontAwesome"><br/>
      </div>
      <div class="col-md-6">
        <span style="color: #008D4C;" id="total_records"></span>
      </div>
    </div> --}}

    {{-- <div class="table-responsive">
      <table class="table table-striped table-bordered" id="searchTable">
        <thead>
          <tr>
            <th>নাম</th>
            <th>মেম্বার আইডি</th>
            <th>যোগাযোগ</th>
            <th>অফিস তথ্য</th>
            <th>ছবি</th>
            <th width="15%">Action</th>
          </tr>
        </thead>
       <tbody id="searchtbody">

       </tbody>
      </table>
    </div> --}}

    <div class="table-responsive">
      <table class="table table-bordered" id="mainTable">
        <thead>
          <tr>
            <th>নাম</th>
            <th>মেম্বার আইডি</th>
            <th>যোগাযোগ</th>
            <th>অফিস তথ্য</th>
            <th>ছবি</th>
            <th width="15%">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($members as $member)
          <tr>
            <td>
              <a href="{{ route('dashboard.singlemember', $member->unique_key) }}" title="সদস্য তথ্য দেখুন">
                {{ $member->name_bangla }}<br/>{{ $member->name }}
              </a>
            </td>
            <td><big><b>{{ $member->member_id }}</b></big></td>
            <td>{{ $member->mobile }}<br/>{{ $member->email }}</td>
            <td>{{ $member->branch->name }}<br/>{{ $member->profession }} ({{ $member->position->name }})</td>
            <td>
              @if($member->image != null)
                <img src="{{ asset('images/users/'.$member->image)}}" style="height: 50px; width: auto;" />
              @else
                <img src="{{ asset('images/user.png')}}" style="height: 50px; width: auto;" />
              @endif
            </td>
            <td>
              <a class="btn btn-sm btn-success" href="{{ route('dashboard.singlemember', $member->unique_key) }}" title="সদস্য তথ্য দেখুন"><i class="fa fa-eye"></i></a>
              {{-- <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deleteMemberModal{{ $member->id }}" data-backdrop="static"><i class="fa fa-trash-o"></i></button> --}}
              <a class="btn btn-sm btn-primary" href="{{ route('dashboard.singleapplicationedit', $member->unique_key) }}" title="সদস্য তথ্য সম্পাদনা করুণ"><i class="fa fa-edit"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div id="mainLink">
      {{ $members->links() }}
    </div>
  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')
  <script>
    // $(document).ready(function(){
    //  $('#searchTable').hide();
    //  function searchMember(query = '')
    //  {
    //   $.ajax({
    //    url:"/// see other apis if necessary",
    //    method:'GET',
    //    data:{query:query},
    //    dataType:'json',
    //    success:function(data)
    //    {
    //     $('#searchtbody').html(data.table_data);
    //     $('#total_records').text(data.total_data);
    //    }
    //   })
    //  }

    //  $(document).on('keyup', '#search', function(){
    //   var query = $(this).val();
    //   if(query.length == 0) {
    //     $('#searchTable').hide();
    //     $('#total_records').hide();
    //     $('#mainTable').show();
    //     $('#mainLink').show();
    //   } else {
    //     if(query.length < 5) {

    //     } else {
    //       $('#mainTable').hide();
    //       $('#mainLink').hide();
    //       $('#searchTable').show();
    //       $('#total_records').show();
    //       searchMember(query);
    //     }
    //   }
      
    //  });
    // });
  </script>
@stop