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
      <h1 class="m-0">Author Dashboard</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Author Dashboard</li>
      </ol>
    </div><!-- /.col -->
</div>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <h5 class="m-0">Payment History Form</h5>
          </div>
          <div class="col-6">
            <div class="float-right">

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
                        <th>Package</th>
                        <th>Task</th>
                        <th>Payment Bill</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($payments as $payment)
                        <tr class="text-center">
                          <td>{{ $payment->user->name }}</td>
                          <td>{{ $payment->authorPackage->name }}</td>
                          <td>{{ $payment->authorPackage->task }}</td>
                          <td>{{ $payment->payment_id }}</td>
                          <td>
                            @if ($payment->status == 'pending')
                              <span class="badge badge-warning">Pending</span>
                            @elseif($payment->status == 'success')
                              <span class="badge badge-success">Success</span>
                            @else
                              <span class="badge badge-danger">Failed</span>
                            @endif
                          </td>
                          <td>{{ $payment->created_at->format('d M Y') }}</td>
                        </tr>
                      @endforeach
                    </tbody>

                </table>
            </div>
      </div>
    </div>
</div>
<!-- /.col-md-6 -->
@endsection