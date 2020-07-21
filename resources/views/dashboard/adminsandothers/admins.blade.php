@extends('adminlte::page')

@section('title', 'CVCS | অ্যাডমিনগণ')

@section('css')

@stop

@section('content_header')
    <h1>
      অ্যাডমিনগণ
      <div class="pull-right">
        @if(Auth::user()->role_type == 'admin')
        <a class="btn btn-success" href="{{ route('dashboard.createadmin') }}" title="অ্যাডমিন যোগ করুন"><i class="fa fa-fw fa-plus" aria-hidden="true"></i></a>
        @endif
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role_type == 'admin')
  <h4>সুপার অ্যাডমিনগণ</h4>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>নাম</th>
          <th>যোগাযোগ</th>
          <th>ছবি</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($superadmins as $superadmin)
        <tr>
          <td>
            {{ $superadmin->name_bangla }}<br/>{{ $superadmin->name }}
          </td>
          <td>{{ $superadmin->mobile }}<br/>{{ $superadmin->email }}</td>
          <td>
            @if($superadmin->image != null)
              <img src="{{ asset('images/users/'.$superadmin->image)}}" style="height: 50px; width: auto;" />
            @else
              <img src="{{ asset('images/user.png')}}" style="height: 50px; width: auto;" />
            @endif
          </td>
          <td>
            <button class="btn btn-info" data-toggle="modal" data-target="#downloadAdminLogPDFModal" data-backdrop="static" title="অ্যাডমিন লগ রিপোর্ট ডাউনলোড করুন" id="downloadAdminLogPDFButton"><i class="fa fa-file-text-o"></i></button>
            <div class="modal fade" id="downloadAdminLogPDFModal" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-file-text-o"></i> অ্যাডমিন লগ রিপোর্ট ডাউনলোড</h4>
                  </div>
                  {!! Form::open(['route' => 'reports.getadminlogreport', 'method' => 'POST', 'class' => 'form-default']) !!}
                  <div class="modal-body">
                    অ্যাডমিন লগ রিপোর্টটি ডাউনলোড করুন
                    {!! Form::hidden('unique_key', $superadmin->unique_key) !!}
                    <div class="row">
                      <div class="col-md-6 form-group">
                        {!! Form::label('log_year', 'লগ-এর সময়কাল *') !!}
                        <select name="log_year" class="form-control" required="">
                          <option value="" selected="" disabled="">বছর নির্ধারণ করুন</option>
                          @for($i = date('Y'); $i >= 2020 ; $i--)
                            <option value="{{$i}}">{{$i}}</option>
                          @endfor
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-info"><i class="fa fa-download"></i> ডাউনলোড করুন</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>


  <h4>অ্যাডমিনগণ</h4>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>নাম</th>
          <th>মেম্বার আইডি</th>
          <th>যোগাযোগ</th>
          <th>অফিস তথ্য</th>
          <th>ছবি</th>
          <th width="10%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($admins as $admin)
        <tr>
          <td>
            <a href="{{ route('dashboard.singlemember', $admin->unique_key) }}" title="সদস্য তথ্য দেখুন">
              {{ $admin->name_bangla }}<br/>{{ $admin->name }}
            </a>
          </td>
          <td><big><b>{{ $admin->member_id }}</b></big></td>
          <td>{{ $admin->mobile }}<br/>{{ $admin->email }}</td>
          <td>{{ $admin->office }}<br/>{{ $admin->profession }} ({{ $admin->designation }})</td>
          <td>
            @if($admin->image != null)
              <img src="{{ asset('images/users/'.$admin->image)}}" style="height: 50px; width: auto;" />
            @else
              <img src="{{ asset('images/user.png')}}" style="height: 50px; width: auto;" />
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-success" href="{{ route('dashboard.singlemember', $admin->unique_key) }}" title="সদস্য তথ্য দেখুন"><i class="fa fa-eye"></i></a>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeAdmin{{ $admin->id }}" data-backdrop="static" title="অ্যাডমিন থেকে অব্যহতি দিন"><i class="fa fa-trash-o"></i></button>
            <!-- Remove Admin Modal -->
            <!-- Remove Admin Modal -->
            <div class="modal fade" id="removeAdmin{{ $admin->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">অ্যাডমিন থেকে অব্যহতি দিন</h4>
                  </div>
                  <div class="modal-body">
                    আপনি কি নিশ্চিতভাবে <b>{{ $admin->name_bangla }}</b>-কে অ্যাডমিন থেকে অব্যহতি দিতে চান?
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($admin, ['route' => ['dashboard.removeadmin', $admin->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                        {!! Form::submit('অব্যহতি দিন', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">দিরে যান</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Remove Admin Modal -->
            <!-- Remove Admin Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $admins->links() }}

  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')

@stop
