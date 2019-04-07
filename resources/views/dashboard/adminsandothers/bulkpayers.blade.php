@extends('adminlte::page')

@section('title', 'CVCS | একাধিক পরিশোধকারীগণ')

@section('css')

@stop

@section('content_header')
    <h1>
      একাধিক পরিশোধকারীগণ
      <div class="pull-right">
        @if(Auth::user()->role_type == 'admin')
        <a class="btn btn-success" href="{{ route('dashboard.createbulkpayer') }}" title="একাধিক পরিশোধকারী যোগ করুন"><i class="fa fa-fw fa-plus" aria-hidden="true"></i></a>
        @endif
      </div>
    </h1>
@stop

@section('content')
  @if(Auth::user()->role_type == 'admin')
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
        @foreach($bulkpayers as $bulkpayer)
        <tr>
          <td>
            <a href="{{ route('dashboard.singlemember', $bulkpayer->unique_key) }}" title="সদস্য তথ্য দেখুন">
              {{ $bulkpayer->name_bangla }}<br/>{{ $bulkpayer->name }}
            </a>
          </td>
          <td><big><b>{{ $bulkpayer->member_id }}</b></big></td>
          <td>{{ $bulkpayer->mobile }}<br/>{{ $bulkpayer->email }}</td>
          <td>{{ $bulkpayer->office }}<br/>{{ $bulkpayer->profession }} ({{ $bulkpayer->designation }})</td>
          <td>
            @if($bulkpayer->image != null)
              <img src="{{ asset('images/users/'.$bulkpayer->image)}}" style="height: 50px; width: auto;" />
            @else
              <img src="{{ asset('images/user.png')}}" style="height: 50px; width: auto;" />
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-success" href="{{ route('dashboard.singlemember', $bulkpayer->unique_key) }}" title="সদস্য তথ্য দেখুন"><i class="fa fa-eye"></i></a>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeBulkPayer{{ $bulkpayer->id }}" data-backdrop="static" title="একাধিক পরিশোধকারী থেকে অব্যহতি দিন"><i class="fa fa-trash-o"></i></button>
            <!-- Remove BulK Payer Modal -->
            <!-- Remove BulK Payer Modal -->
            <div class="modal fade" id="removeBulkPayer{{ $bulkpayer->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">একাধিক পরিশোধকারী থেকে অব্যহতি দিন</h4>
                  </div>
                  <div class="modal-body">
                    আপনি কি নিশ্চিতভাবে <b>{{ $bulkpayer->name_bangla }}</b>-কে একাধিক পরিশোধকারী থেকে অব্যহতি দিতে চান?
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($bulkpayer, ['route' => ['dashboard.removebulkpayer', $bulkpayer->id], 'method' => 'PATCH', 'class' => 'form-default']) !!}
                        {!! Form::submit('অব্যহতি দিন', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Remove BulK Payer Modal -->
            <!-- Remove BulK Payer Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $bulkpayers->links() }}

  @else
    <span class="text-red"><i class="fa fa-exclamation-triangle"></i> দুঃখিত, আপনার এই পাতাটি দেখবার অনুমতি নেই!</span>
  @endif
@stop

@section('js')

@stop