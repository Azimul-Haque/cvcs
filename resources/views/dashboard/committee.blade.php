@extends('adminlte::page')

@section('title', 'CVCS | Committee')

@section('css')

@stop

@section('content_header')
    <h1>
      Committees
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#addMemberModal" data-backdrop="static"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Add Member</button>
      </div>
    </h1>
@stop

@section('content')
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Designation</th>
          <th>Photo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $addmodalflag = 0; $editmodalflag = 0; @endphp
        @foreach($adhocmembers as $adhocmember)
        <tr>
          <td>{{ $adhocmember->name }}</td>
          <td>{{ $adhocmember->email }}</td>
          <td>{{ $adhocmember->phone }}</td>
          <td>{{ $adhocmember->designation }}</td>
          <td>
            @if($adhocmember->image != null)
            <img src="{{ asset('images/committee/adhoc/'.$adhocmember->image)}}" style="height: 40px; width: auto;" />
            @else
            <img src="{{ asset('images/user.png')}}" style="height: 40px; width: auto;" />
            @endif
          </td>
          <td>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMemberModal{{ $adhocmember->id }}" data-backdrop="static"><i class="fa fa-pencil"></i></button>
            <!-- Edit Member Modal -->
            <!-- Edit Member Modal -->
            <div class="modal fade" id="editMemberModal{{ $adhocmember->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Member</h4>
                  </div>
                  <div class="modal-body">
                    {!! Form::model($adhocmember, ['route' => ['dashboard.updatecommittee', $adhocmember->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              {!! Form::label('name', 'Name:') !!}
                              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write Name', 'required')) !!}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              {!! Form::label('designation', 'Designation:') !!}
                              {!! Form::text('designation', null, array('class' => 'form-control', 'placeholder' => 'Write Designation', 'required')) !!}
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              {!! Form::label('email', 'Email:') !!}
                              {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Write Email', 'required')) !!}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              {!! Form::label('phone', 'Phone:') !!}
                              {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Write Phone Number', 'required')) !!}
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              {!! Form::label('fb', 'FB Url: (optional)') !!}
                              {!! Form::text('fb', null, array('class' => 'form-control', 'placeholder' => 'Facebook Url')) !!}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              {!! Form::label('twitter', 'Twitter Url: (optional)') !!}
                              {!! Form::text('twitter', null, array('class' => 'form-control', 'placeholder' => 'Twitter Url')) !!}
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              {!! Form::label('gplus', 'G. Plus Url: (optional)') !!}
                              {!! Form::text('gplus', null, array('class' => 'form-control', 'placeholder' => 'G. Plus Url')) !!}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              {!! Form::label('linkedin', 'Linkedin Url: (optional)') !!}
                              {!! Form::text('linkedin', null, array('class' => 'form-control', 'placeholder' => 'Linkedin Url')) !!}
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>Photo (300 X 300 &amp; 250Kb Max):</label>
                                  <div class="input-group">
                                      <span class="input-group-btn">
                                          <span class="btn btn-default btn-file">
                                              Browse <input type="file" id="image{{ $adhocmember->id }}" name="image">
                                          </span>
                                      </span>
                                      <input type="text" class="form-control" readonly>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <center>
                              <img src="{{ asset('images/user.png')}}" id='img-update{{ $adhocmember->id }}' style="height: 100px; width: auto; padding: 5px;" />
                            </center>
                          </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                        {!! Form::submit('Add Member', array('class' => 'btn btn-success')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
            <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
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
                            $('#img-update{{ $adhocmember->id }}').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("#image{{ $adhocmember->id }}").change(function(){
                    readURL(this);
                    var filesize = parseInt((this.files[0].size)/1024);
                    if(filesize > 250) {
                      $("#image{{ $adhocmember->id }}").val('');
                      toastr.warning('File size is: '+filesize+' Kb. try uploading less than 250Kb', 'WARNING').css('width', '400px;');
                        setTimeout(function() {
                          $("#img-update{{ $adhocmember->id }}").attr('src', '{{ asset('images/user.png') }}');
                        }, 1000);
                    }
                });

                @if ((count($errors) > 0) && ($editmodalflag == 0))
                  $('#editMemberModal{{ $adhocmember->id }}').modal({backdrop: "static"});
                  @php $editmodalflag = 1; @endphp
                @endif
              });
            </script>
            <!-- Edit Member Modal -->
            <!-- Edit Member Modal -->

            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteMemberModal{{ $adhocmember->id }}" data-backdrop="static"><i class="fa fa-trash-o"></i></button>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
            <div class="modal fade" id="deleteMemberModal{{ $adhocmember->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Member</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete <b>{{ $adhocmember->name }}</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($adhocmember, ['route' => ['dashboard.deletecommittee', $adhocmember->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete Member', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>


    <!-- Add Member Modal -->
    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header modal-header-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add New Member</h4>
          </div>
          <div class="modal-body">
            {!! Form::open(['route' => 'dashboard.storecommittee', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('name', 'Name:') !!}
                      {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write Name', 'required')) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('designation', 'Designation:') !!}
                      {!! Form::text('designation', null, array('class' => 'form-control', 'placeholder' => 'Write Designation', 'required')) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('email', 'Email:') !!}
                      {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Write Email', 'required')) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('phone', 'Phone:') !!}
                      {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Write Phone Number', 'required')) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('fb', 'FB Url: (optional)') !!}
                      {!! Form::text('fb', null, array('class' => 'form-control', 'placeholder' => 'Facebook Url')) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('twitter', 'Twitter Url: (optional)') !!}
                      {!! Form::text('twitter', null, array('class' => 'form-control', 'placeholder' => 'Twitter Url')) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('gplus', 'G. Plus Url: (optional)') !!}
                      {!! Form::text('gplus', null, array('class' => 'form-control', 'placeholder' => 'G. Plus Url')) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      {!! Form::label('linkedin', 'Linkedin Url: (optional)') !!}
                      {!! Form::text('linkedin', null, array('class' => 'form-control', 'placeholder' => 'Linkedin Url')) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Photo (300 X 300 &amp; 250Kb Max):</label>
                          <div class="input-group">
                              <span class="input-group-btn">
                                  <span class="btn btn-default btn-file">
                                      Browse <input type="file" id="image" name="image">
                                  </span>
                              </span>
                              <input type="text" class="form-control" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <center>
                      <img src="{{ asset('images/user.png')}}" id='img-upload' style="height: 100px; width: auto; padding: 5px;" />
                    </center>
                  </div>
                </div>
          </div>
          <div class="modal-footer">
                {!! Form::submit('Add Member', array('class' => 'btn btn-success')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Add Member Modal -->
    <!-- Add Member Modal -->
@stop

@section('js')
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
          if(filesize > 250) {
            $("#image").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 250Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
          }
      });

      @if (count($errors) > 0 && $addmodalflag = 0)
        $('#addMemberModal').modal({backdrop: "static"});
        @php $addmodalflag = 1; @endphp
      @endif
    });
  </script>
@stop