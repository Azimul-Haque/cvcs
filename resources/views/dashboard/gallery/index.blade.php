@extends('adminlte::page')

@section('title', 'CVCS | Gallery')

@section('css')

@stop

@section('content_header')
    <h1>
      <i class="fa fa-fw fa-picture-o" aria-hidden="true"></i> Gallery | Albums
      <div class="pull-right">
        <a class="btn btn-success" href="{{ route('dashboard.creategallery') }}"><i class="fa fa-fw fa-plus" aria-hidden="true"></i> Create Album</a>
      </div>
    </h1>
@stop

@section('content')
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Thumbnail</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($albums as $album)
        <tr>
          <td>{{ $album->name }}</td>
          <td>{{ $album->description }}</td>
          <td>
            <img src="{{ asset('images/gallery/'.$album->thumbnail) }}" class="img-responsive" style="max-height: 80px;">
          </td>
          <td>
            <a href="{{ route('dashboard.editgallery', $album->id) }}" class="btn btn-sm btn-primary" title="অ্যালবাম সম্পাদনা করুন"><i class="fa fa-pencil"></i></a>
            

            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAlbumModal{{ $album->id }}" data-backdrop="static" title="অ্যালবাম ডিলিট করুন"><i class="fa fa-trash-o"></i></button>
            <!-- Delete Member Modal -->
            <!-- Delete Member Modal -->
            <div class="modal fade" id="deleteAlbumModal{{ $album->id }}" role="dialog">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Album</h4>
                  </div>
                  <div class="modal-body">
                    Confirm Delete the whole album <b>{{ $album->name }}</b>?<br/><br/><br/>

                    <small class="text-red"><b><i class="fa fa-info-circle"></i> All of the images under this Album will be lost.</b></small>
                  </div>
                  <div class="modal-footer">
                    {!! Form::model($album, ['route' => ['dashboard.deletealbum', $album->id], 'method' => 'DELETE', 'class' => 'form-default', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::submit('Delete Album', array('class' => 'btn btn-danger')) !!}
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

@stop

@section('js')
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
     $('button[title]').tooltip();
    });
  </script>
@stop