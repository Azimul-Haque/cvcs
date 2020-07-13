@extends('adminlte::page')

@section('title', 'CVCS | তথ্য হালনাগাদ অনুরোধস্সমূহ')

@section('css')

@stop

@section('content_header')
    <h1>
        তথ্য হালনাগাদ অনুরোধসমূহ ({{ bangla($tempmemdatas->count()) }}টি)
        <div class="pull-right">

        </div>
    </h1>
@stop

@section('content')
    {{-- <div class="row">
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
    </div> --}}

    <div class="table-responsive">
        <table class="table table-bordered" id="mainTable">
            <thead>
            <tr>
                <th>নাম</th>
                <th>অফিস তথ্য</th>
                <th>ছবি</th>
                <th width="10%">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tempmemdatas as $tempmemdata)
                <tr>
                    <td>
                        {{ $tempmemdata->user->name_bangla }}<br/>{{ $tempmemdata->user->name }}
                    </td>
                    <td>{{ $tempmemdata->user->branch->name }}<br/>{{ $tempmemdata->user->profession }}
                        ({{ $tempmemdata->user->position->name }})
                    </td>
                    <td>
                        @if($tempmemdata->user->image != null)
                            <img src="{{ asset('images/users/'.$tempmemdata->user->image)}}"
                                 style="height: 50px; width: auto;"/>
                        @else
                            <img src="{{ asset('images/user.png')}}" style="height: 50px; width: auto;"/>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#approveData{{ $tempmemdata->id }}" data-backdrop="static"
                                title="তথ্য যাচাই ও অনুমোদন করুন"><i class="fa fa-check"></i></button>
                        <!-- Approve Data Modal -->
                        <!-- Approve Data Modal -->
                        <div class="modal fade" id="approveData{{ $tempmemdata->id }}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header modal-header-primary">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><i class="fa fa-pencil"></i> পরিবর্তনের জন্য আবেদিত
                                            তথ্যসমূহ</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>পুর্বের তথ্য</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>পদবিঃ {{ $tempmemdata->user->position->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>দপ্তরঃ {{ $tempmemdata->user->branch->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>মোবাইলঃ {{ $tempmemdata->user->mobile }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ইমেইলঃ {{ $tempmemdata->user->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>বর্তমান
                                                                ঠিকানাঃ {{ $tempmemdata->user->present_address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                ছবিঃ
                                                                @if($tempmemdata->user->image)
                                                                    <img src="{{ asset('images/users/'. $tempmemdata->user->image)}}"
                                                                         style="height: 120px; width: auto; padding: 5px;"/>
                                                                @else
                                                                    <span class="text-muted">অপরিবর্তিত</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>পরিবর্তনের জন্য দাখিলকৃত তথ্য</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>পদবিঃ
                                                                @if($tempmemdata->position->name != $tempmemdata->user->position->name)
                                                                    {{ $tempmemdata->position->name }}
                                                                @else
                                                                    <span class="text-muted">অপরিবর্তিত</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>দপ্তরঃ
                                                                @if($tempmemdata->branch->name != $tempmemdata->user->branch->name)
                                                                    {{ $tempmemdata->branch->name }}
                                                                @else
                                                                    <span class="text-muted">অপরিবর্তিত</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @if($tempmemdata->start_time && ($tempmemdata->position->name != $tempmemdata->user->position->name || $tempmemdata->branch->name != $tempmemdata->user->branch->name))
                                                            <tr>
                                                                <td>নতুন পদবি/দপ্তর এ যোগদানের তারিখ:
                                                                    {{ $tempmemdata->start_time }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td>মোবাইলঃ
                                                                @if($tempmemdata->mobile != $tempmemdata->user->mobile)
                                                                    {{ $tempmemdata->mobile }}
                                                                @else
                                                                    <span class="text-muted">অপরিবর্তিত</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>ইমেইলঃ
                                                                @if($tempmemdata->email != $tempmemdata->user->email)
                                                                    {{ $tempmemdata->email }}
                                                                @else
                                                                    <span class="text-muted">অপরিবর্তিত</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>বর্তমান ঠিকানাঃ
                                                                @if($tempmemdata->present_address != $tempmemdata->user->present_address)
                                                                    {{ $tempmemdata->present_address }}
                                                                @else
                                                                    <span class="text-muted">অপরিবর্তিত</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                ছবিঃ
                                                                @if($tempmemdata->image)
                                                                    <img src="{{ asset('images/users/'. $tempmemdata->image)}}"
                                                                         style="height: 120px; width: auto; padding: 5px;"/>
                                                                @else
                                                                    <span class="text-muted">অপরিবর্তিত</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::open(['route' => ['dashboard.approveupdaterequest'], 'method' => 'POST', 'class' => 'form-default', 'enctype' => 'multipart/form-data', 'data-parsley-validate' => '']) !!}
                                        {!! Form::hidden('tempmemdata_id', $tempmemdata->id) !!}
                                        {!! Form::hidden('user_id', $tempmemdata->user_id) !!}
                                        {!! Form::submit('হালনাগাদ করুন', array('class' => 'btn btn-primary')) !!}
                                        <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Approve Data Modal -->
                        <!-- Approve Data Modal -->
                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#deleteTempMemData{{ $tempmemdata->id }}" data-backdrop="static"
                                title="অনুরোধটি ডিলেট করুন"><i class="fa fa-trash-o"></i></button>
                        <!-- Delete Message Modal -->
                        <!-- Delete Message Modal -->
                        <div class="modal fade" id="deleteTempMemData{{ $tempmemdata->id }}" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header modal-header-danger">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">অনুরোধটি ডিলেট করুন</h4>
                                    </div>
                                    <div class="modal-body">
                                        আপনি কী নিশ্চিতভাবে এই অনুরোধটি ডিলেট করতে চান?</b>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::model($tempmemdata, ['route' => ['dashboard.deleteupdaterequest', $tempmemdata->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                                        {!! Form::submit('ডিলেট', array('class' => 'btn btn-danger')) !!}
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Message Modal -->
                        <!-- Delete Message Modal -->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="mainLink">
        {{ $tempmemdatas->links() }}
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#searchTable').hide();

            function searchMember(query = '') {
                $.ajax({
                    url: "{{ route('dashboard.applicationsearchapi') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        $('#searchtbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                if (query.length == 0) {
                    $('#searchTable').hide();
                    $('#total_records').hide();
                    $('#mainTable').show();
                    $('#mainLink').show();
                } else {
                    if (query.length < 5) {

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
