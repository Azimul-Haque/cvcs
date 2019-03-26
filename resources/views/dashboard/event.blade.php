@extends('adminlte::page')

@section('title', 'CVCS | Events')

@section('css')

@stop

@section('content_header')
    <h1>
      Events
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#addEventModal" data-backdrop="static"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Create Event</button>
      </div>
    </h1>
@stop

@section('content')
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th>Title</th>
          <th width="40%">Description</th>
          <th width="15%">Image</th>
          <th width="15%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($events as $event)
        <tr>
          <td>{{ $event->name }}</td>
          <td>{{ $event->description }}</td>
          <td>
            @if($event->image != null)
            <img src="{{ asset('images/events/'.$event->image)}}" style="height: 50px; width: auto;" />
            @else
            <img src="{{ asset('images/events/default_event.jpg')}}" style="height: 50px; width: auto;" />
            @endif
          </td>
          <td>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editEventModal{{ $event->id }}" data-backdrop="static" title="Edit Event"><i class="fa fa-pencil"></i></button>
            <!-- Edit Event Modal -->
            <!-- Edit Event Modal -->
            <div class="modal fade" id="editEventModal{{ $event->id }}" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Event</h4>
                  </div>
                  <div class="modal-body">
                  {!! Form::model($event, ['route' => ['dashboard.updateevent', $event->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                      {!! Form::label('name', 'Event Title:') !!}
                      {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write Event Title', 'required')) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('description', 'Description:') !!}
                      {!! Form::textarea('description', null, array('class' => 'form-control textarea', 'placeholder' => 'Write Description', 'required')) !!}
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Photo (300 X 300 &amp; 250Kb Max):</label>
                              <div class="input-group">
                                  <span class="input-group-btn">
                                      <span class="btn btn-default btn-file">
                                          Browse <input type="file" id="image{{ $event->id }}" name="image">
                                      </span>
                                  </span>
                                  <input type="text" class="form-control" readonly>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <center>
                          @if($event->image != null)
                            <img src="{{ asset('images/events/'.$event->image)}}" id='img-update{{ $event->id }}' style="height: 150px; width: auto; padding: 5px;" />
                          @else
                            <img src="{{ asset('images/events/default_event.jpg')}}" id='img-update{{ $event->id }}' style="height: 150px; width: auto; padding: 5px;" />
                          @endif
                        </center>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                        {!! Form::submit('Submit', array('class' => 'btn btn-success')) !!}
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
                            $('#img-update{{ $event->id }}').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("#image{{ $event->id }}").change(function(){
                    readURL(this);
                    var filesize = parseInt((this.files[0].size)/1024);
                    if(filesize > 250) {
                      $("#image{{ $event->id }}").val('');
                      toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
                        setTimeout(function() {
                          $("#img-update{{ $event->id }}").attr('src', '{{ asset('images/user.png') }}');
                        }, 1000);
                    }
                });
              });
            </script>
            <!-- Edit Event Modal -->
            <!-- Edit Event Modal -->

            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteEventModal{{ $event->id }}" data-backdrop="static" title="Delete Event"><i class="fa fa-trash-o"></i></button>
            <!-- Delete Event Modal -->
            <!-- Delete Event Modal -->
            <div class="modal fade" id="deleteEventModal{{ $event->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Event</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete <b>{{ $event->name }}</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($event, ['route' => ['dashboard.deleteevent', $event->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete Event', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Event Modal -->
            <!-- Delete Event Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>


    <!-- Add Event Modal -->
    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header modal-header-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create New Event</h4>
          </div>
          <div class="modal-body">
            {!! Form::open(['route' => 'dashboard.storeevent', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="form-group">
                  {!! Form::label('name', 'Event Title:') !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write Event Title', 'required')) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('description', 'Event Description:') !!}
                  {!! Form::textarea('description', null, array('class' => 'form-control textarea', 'placeholder' => 'Write Event Description', 'required')) !!}
                </div>
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Photo (8:5 &amp; 500Kb Max):</label>
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
                      <img src="{{ asset('images/800x500.png')}}" id='img-upload' style="height: 150px; width: auto; padding: 5px;" />
                    </center>
                  </div>
                </div>
          </div>
          <div class="modal-footer">
                {!! Form::submit('Submit', array('class' => 'btn btn-success')) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Add Event Modal -->
    <!-- Add Event Modal -->
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
          if(filesize > 500) {
            $("#image").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 500Kb', 'WARNING').css('width', '400px;');
              setTimeout(function() {
                $("#img-upload").attr('src', '{{ asset('images/user.png') }}');
              }, 1000);
          }
      });
    });
  </script>
@stop