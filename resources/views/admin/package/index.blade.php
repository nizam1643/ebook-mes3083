@extends('layouts.template')

@section('style')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
      <h1 class="m-0">Admin Dashboard</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Admin Dashboard</li>
      </ol>
    </div><!-- /.col -->
</div>
@endsection

@section('content')
<!-- /.col-md-6 -->
<div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <h5 class="m-0">Author Package Form</h5>
          </div>
          <div class="col-6">
            <div class="float-right">
                <a href="{{ route('admin.package.create') }}" class="btn btn-sm btn-primary">Create Package</a>
          </div>
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

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="text-center">
                        <th>Name</th>
                        <th>Price</th>
                        <th>Task</th>
                        <th>Total Purchase</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($totalPackages as $totalPackage)
                            <tr class="text-center">
                                <td>{{ $totalPackage->name }}</td>
                                <td>{{ $totalPackage->price }}</td>
                                <td>{{ $totalPackage->task }}</td>
                                <td>{{ $totalPackage->payments->where('author_package_id', $totalPackage->id)->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.package.edit', $totalPackage->id) }}" class="btn btn-sm btn-success">Edit</a>
                                    <form action="{{ route('admin.package.destroy', $totalPackage->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        @if ($totalPackage->payments->where('author_package_id', $totalPackage->id)->count() == 0)
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        @endif
                                    </form>
                                </td> 
                            </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
            </div>
      </div>
    </div>
</div>
<!-- /.col-md-6 -->
@endsection