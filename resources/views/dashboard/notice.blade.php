@extends('adminlte::page')

@section('title', 'CVCS | Notice')

@section('css')

@stop

@section('content_header')
    <h1>
      নোটিশ
      <div class="pull-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#addNoticeModal" data-backdrop="static"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> নোটিশ যোগ করুন</button>
      </div>
    </h1>
@stop

@section('content')
  <div class="table-responsive">
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th>শিরোনাম</th>
          <th width="30%">Attachment</th>
          <th width="15%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($notices as $notice)
        <tr>
          <td>{{ limit_text($notice->name, 100) }}</td>
          <td>
            <a href="{{ asset('files/'. $notice->attachment) }}" download=""><i class="fa fa-paperclip"></i> Attachment</a>
          </td>
          <td>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editNoticeModal{{ $notice->id }}" data-backdrop="static" title="Edit Notice"><i class="fa fa-pencil"></i></button>
            <!-- Edit Notice Modal -->
            <!-- Edit Notice Modal -->
            <div class="modal fade" id="editNoticeModal{{ $notice->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">নোটিশ হালনাগাদ করুন</h4>
                  </div>
                  <div class="modal-body">
                  {!! Form::model($notice, ['route' => ['dashboard.updatenotice', $notice->id], 'method' => 'PUT', 'class' => 'form-default', 'enctype' => 'multipart/form-data', 'id' => 'editNoticeForm'.$notice->id ]) !!}
                    <div class="form-group">
                      {!! Form::label('name', 'শিরোনাম') !!}
                      {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'শিরোনাম লিখুন', 'required')) !!}
                    </div>
                  
                    <div class="form-group">
                        <label>Attachment (.doc, .docx, .ppt, .pptx, .pdf, .jpg, .png)</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse <input type="file" id="attachment{{ $notice->id }}" name="attachment">
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                        {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
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
                
                $("#attachment{{ $notice->id }}").change(function(){
                    var filesize = parseInt((this.files[0].size)/1024);
                    if(filesize > 10000) {
                      $("#attachment{{ $notice->id }}").val('');
                      toastr.warning('File size is: '+filesize+' Kb. try uploading less than 10MB', 'WARNING').css('width', '400px;');
                    }
                });

                $('#editNoticeForm{{ $notice->id }}').submit(function(){
                    $('input[type=submit]').addClass("disabled");
                    $('input[type=submit]').val("ফাইল আপলোড হচ্ছে, অপেক্ষা করুন...");
                });
              });
            </script>
            <!-- Edit Notice Modal -->
            <!-- Edit Notice Modal -->

            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteNoticeModal{{ $notice->id }}" data-backdrop="static" title="Delete Notice"><i class="fa fa-trash-o"></i></button>
            <!-- Delete Notice Modal -->
            <!-- Delete Notice Modal -->
            <div class="modal fade" id="deleteNoticeModal{{ $notice->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">নোটিশ ডিলেট</h4>
                  </div>
                  <div class="modal-body">
                    আপনি কি নিশ্চিতভাবে নোটিশটি ডিলেট করতে চান?</b>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($notice, ['route' => ['dashboard.deletenotice', $notice->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('নিশ্চিত করুন', array('class' => 'btn btn-danger')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
            <!-- Delete Notice Modal -->
            <!-- Delete Notice Modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $notices->links() }}


  <!-- Add Notice Modal -->
  <!-- Add Notice Modal -->
  <div class="modal fade" id="addNoticeModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header modal-header-success">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">নতুন নোটিশ যোগ করুন</h4>
        </div>
        <div class="modal-body">
          {!! Form::open(['route' => 'dashboard.storenotice', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'addNoticeForm']) !!}
              <div class="form-group">
                {!! Form::label('name', 'শিরোনাম') !!}
                {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Write Notice Title', 'required')) !!}
              </div>
              <div class="form-group">
                  <label>Attachment (.doc, .docx, .ppt, .pptx, .pdf, .jpg, .png)</label>
                  <div class="input-group">
                      <span class="input-group-btn">
                          <span class="btn btn-default btn-file">
                              Browse <input type="file" id="attachment" name="attachment" required="">
                          </span>
                      </span>
                      <input type="text" class="form-control" readonly>
                  </div>
              </div>
        </div>
        <div class="modal-footer">
              {!! Form::submit('দাখিল করুন', array('class' => 'btn btn-success')) !!}
              <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- Add Notice Modal -->
  <!-- Add Notice Modal -->
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
      $("#attachment").change(function(){
          var filesize = parseInt((this.files[0].size)/1024);
          if(filesize > 10000) {
            $("#attachment").val('');
            toastr.warning('File size is: '+filesize+' Kb. try uploading less than 10MB', 'WARNING').css('width', '400px;');
          }
      });

      $('#addNoticeForm').submit(function(){
          $('input[type=submit]').addClass("disabled");
          $('input[type=submit]').val("ফাইল আপলোড হচ্ছে, অপেক্ষা করুন...");
      });
    });
  </script>
@stop