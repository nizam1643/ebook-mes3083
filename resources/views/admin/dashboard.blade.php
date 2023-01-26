@extends('layouts.template')

@section('style')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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

<script>
    var xValues = {!! json_encode($labelIncome) !!};
    var yValues = {!! json_encode($dataIncome) !!};
    var barColors = [
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
        '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', 
        '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#000000',
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
        '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', 
        '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#000000',
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
        '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', 
        '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#000000',
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
        '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', 
        '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#000000',
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
    ];
    
    new Chart("myChart1", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        title: {
          display: false,
          text: "World Wide Wine Production 2018"
        }
      }
    });
</script>

<script>
    var xValues = {!! json_encode($labelPayment) !!};
    var yValues = {!! json_encode($dataPayment) !!};
    var barColors = [
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
        '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', 
        '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#000000',
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
        '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', 
        '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#000000',
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
        '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', 
        '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#000000',
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
        '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', 
        '#FF5722', '#795548', '#9E9E9E', '#607D8B', '#000000',
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', 
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', 
    ];
    
    new Chart("myChart2", {
      type: "pie",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        title: {
          display: false,
          text: "World Wide Wine Production 2018"
        }
      }
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
    <h5 class="mb-2">Mini Info</h5>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fa fa-users" aria-hidden="true"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL AUTHOR</span>
              <span class="info-box-number">{{ $totalAuthors ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-4 col-sm-4 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-tasks" aria-hidden="true"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL PACKAGE</span>
              <span class="info-box-number">{{ $totalPackage ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL PURCHASE</span>
              <span class="info-box-number">{{ $totalPurchase ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL GROSS PROFIT</span>
              <span class="info-box-number">RM {{ $totalProfit ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
</div>

<div class="col-lg-6">
    <h5 class="mb-2">Author Household Income</h5>
    <div class="card">
        <div class="card-body">
            <div class="chart">
                <canvas id="myChart1" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6">
    <h5 class="mb-2">Author Payment Status</h5>
    <div class="card">
        <div class="card-body">
            <div class="chart">
                <canvas id="myChart2" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
  <h5 class="mb-2">Gross Profit Status</h5>
  <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table id="" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>Package</th>
                  <th>Total Profit</th>
                </tr>
              </thead>
              <tbody>
                 @forelse ($packages as $package)
                  <tr class="text-center">
                      <td>{{ $package->name }}</td>
                      <td>RM {{ $totalprofitperpackages[$loop->index] ?? 0 }}</td>
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