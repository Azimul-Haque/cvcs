@extends('adminlte::page')

@section('title', 'CVCS | সদস্যগণ')

@section('css')

@stop

@section('content_header')
  @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'manager') || (Auth::user()->role_type == 'bulkpayer'))
    <h1>
      সদস্যগণ ({{ bangla($memberscount) }} জন)
      <div class="pull-right">
        
        {{-- <a class="btn btn-success" href="{{ route('dashboard.members.search') }}"><i class="fa fa-fw fa-search" aria-hidden="true"></i> সদস্য খুঁজুন</a> --}}
      </div>
    </h1>
  @endif
@stop

@section('content')
  @if((Auth::user()->role_type == 'admin') || (Auth::user()->role_type == 'manager') || (Auth::user()->role_type == 'bulkpayer'))
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
    </div>

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
            <td>
              <a href="{{ route('dashboard.branch.members', $member->branch->id) }}" title="দপ্তরের সদস্য তালিকা দেখুন">{{ $member->branch->name }}</a>
              <br/>{{ $member->profession }} (<a href="{{ route('dashboard.designation.members', $member->position->id) }}" title="পদবির সদস্য তালিকা দেখুন">{{ $member->position->name }}</a>)
            </td>
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
              <a class="btn btn-sm btn-primary" href="{{ route('dashboard.singleapplicationedit', $member->unique_key) }}" title="সদস্য তথ্য সম্পাদনা করুন"><i class="fa fa-edit"></i></a>
              <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#transferMemberModal{{ $member->id }}" data-backdrop="static" title="সদস্যের দপ্তর পরিবর্তন করুন"><i class="fa fa-fw fa-exchange" aria-hidden="true"></i></a>
              <!-- Transfer Member Modal -->
              <!-- Transfer Member Modal -->
              <div class="modal fade" id="transferMemberModal{{ $member->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-warning">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-fw fa-exchange"></i> দপ্তর পরিবর্তন করুন</h4>
                    </div>
                    {!! Form::model($member, ['route' => ['dashboard.transfermember', $member->id], 'method' => 'POST', 'class' => 'form-default']) !!}
                    <div class="modal-body">
                      <select name="branch_id" id="branch_id" class="form-control" required="">
                          <option value="" selected="" disabled="">দপ্তরের নাম নির্ধারণ করুন</option>
                          @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" @if($branch->id == $member->branch_id) selected="" @endif>{{ $branch->name }}</option>
                          @endforeach
                      </select><br/>
                      <div class="checkbox">
                        <label><input type="checkbox" name="confirmcheckbox" value="1" required>আপনি কি নিশ্চিতভাবে দপ্তর পরিবর্তন করতে চান? (চেক বাটনে ক্লিক করুন)</label>
                      </div>
                    </div>
                    <div class="modal-footer">
                      
                          {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-warning')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                    </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
              <!-- Transfer Member Modal -->
              <!-- Transfer Member Modal -->

              <a class="btn btn-sm btn-info" data-toggle="modal" data-target="#changeDesigModal{{ $member->id }}" data-backdrop="static" title="সদস্যের পদবি পরিবর্তন করুন"><i class="fa fa-level-up" aria-hidden="true"></i></a>
              <!-- Transfer Member Modal -->
              <!-- Transfer Member Modal -->
              <div class="modal fade" id="changeDesigModal{{ $member->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-info">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-level-up"></i> পদবি পরিবর্তন করুন</h4>
                    </div>
                    {!! Form::model($member, ['route' => ['dashboard.changedesignation', $member->id], 'method' => 'POST', 'class' => 'form-default']) !!}
                    <div class="modal-body">
                      <select name="position_id" id="position_id" class="form-control" required="">
                          <option value="" selected="" disabled="">পদবির নাম নির্ধারণ করুন</option>
                          @foreach($positions as $position)
                            <option value="{{ $position->id }}" @if($position->id == $member->position_id) selected="" @endif>{{ $position->name }}</option>
                          @endforeach
                      </select><br/>
                      <div class="checkbox">
                        <label><input type="checkbox" name="confirmcheckbox" value="1" required>আপনি কি নিশ্চিতভাবে পদবি পরিবর্তন করতে চান? (চেক বাটনে ক্লিক করুন)</label>
                      </div>
                    </div>
                    <div class="modal-footer">
                      
                          {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-info')) !!}
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                    </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
              <!-- Transfer Member Modal -->
              <!-- Transfer Member Modal -->
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
    $(document).ready(function(){
     $('#searchTable').hide();
     function searchMember(query = '')
     {
      $.ajax({
       url:"{{ route('dashboard.membersearchapi2') }}",
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