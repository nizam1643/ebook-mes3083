@extends('layouts.template')

@section('style')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

  <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@endsection

@section('script')
<!-- DataTables  & Plugins -->
<script src="{{ asset('dash-template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('dash-template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('dash-template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Page specific script -->
<script type="text/javascript">
  CKEDITOR.replace('content', {
      filebrowserUploadUrl: "{{route('author.book.importImage', ['_token' => csrf_token() ])}}",
      filebrowserUploadMethod: 'form'
  });
</script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": false, 
        "lengthChange": false, 
        "autoWidth": false,
        "lengthChange": true,
        "buttons": ["csv", "excel", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": false,
      });
    });
  </script>
@endsection

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Starter Page</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Starter Page</li>
      </ol>
    </div><!-- /.col -->
</div>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6"><h5 class="m-0">Edit Book Form</h5></div>
          <div class="col-6"> 
            <a href="{{ route('author.book.draftPdf', $book->id) }}" class="btn btn-warning btn-sm m-1 float-right">Generate Draft Book</a>
            @if ($message = Session::get('pdf'))
                  <a href="{{ asset('files'.'/'.Auth::user()->id.'/'.$message) }}" target="_blank" class="btn btn-info btn-sm m-1 float-right">View Draft Book</a>
            @endif
          </div>
        </div>
      </div>
      <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <form action="{{ route('author.book.updateBook', $book->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="title">Title *</label> 
                  <input id="title" name="title" type="text" class="form-control" required="required" aria-describedby="titleHelpBlock" value="{{ $book->title }}"> 
                  @error('title')
                    <span id="titleHelpBlock" class="form-text text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="context">Context *</label> 
                  <textarea id="context" name="context" cols="40" rows="5" class="form-control" required="required">{{ $book->context }}</textarea>
                    @error('context')
                        <span id="contextHelpBlock" class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                  <label for="content">Content</label> 
                  <textarea id="content" name="content" cols="40" rows="5" class="form-control">{{ $book->content }}</textarea>
                  @error('content')
                      <span id="contentHelpBlock" class="form-text text-danger">{{ $message }}</span>
                  @enderror
                </div> 
                <div class="form-group">
                  <button name="submit" type="submit" class="btn btn-success m-1 float-right">Save Draft</button>
                  <a href="{{ route('author.dashboard') }}" class="btn btn-danger m-1 float-right">Cancel</a>
                </div>
            </form>
      </div>
    </div>
</div>
<!-- /.col-md-6 -->
@endsection