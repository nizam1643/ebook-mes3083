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
<!-- /.col-md-6 -->
<div class="col-lg-12">
    <h5 class="mb-2">Task Info</h5>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-warning"><x-far-folder-open />
            </span>

            <div class="info-box-content">
              <span class="info-box-text">TASKS ALLOTTED</span>
              <span class="info-box-number">{{ $tasks->task_allotted ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-4 col-sm-4 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><x-fas-chart-pie />
            </span>

            <div class="info-box-content">
              <span class="info-box-text">TASKS CONSUMED</span>
              <span class="info-box-number">{{ $tasks->task_consumed ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><x-fas-book-reader />
            </span>

            <div class="info-box-content">
              <span class="info-box-text">TASKS REMAINING</span>
              <span class="info-box-number">{{ $tasks->task_remaining ?? 0 }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
</div>
<div class="col-lg-12">
  <h5 class="mb-2">Book Info</h5>
  <div class="row">
      <div class="col-md-6 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><x-fas-book />
          </span>

          <div class="info-box-content">
            <span class="info-box-text">COMPLETE BOOK</span>
            <span class="info-box-number">{{ $books->book_complete ?? 0 }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <div class="col-md-6 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><x-fas-book-bookmark />
          </span>

          <div class="info-box-content">
            <span class="info-box-text">INCOMPLETE BOOK</span>
            <span class="info-box-number">{{ $books->book_incomplete ?? 0 }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
  </div>
</div>
<div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <h5 class="m-0">Book Form</h5>
          </div>
          <div class="col-6">
            <div class="float-right">
              @if ($tasks->task_remaining ?? 0 != 0)
                @if ($firstBook == null)
                  <a href="{{ route('author.book.createBook') }}" class="btn btn-primary btn-sm">Add First Book</a>
                @endif
                @if ($firstBook != null && $statusBook['book_complete'] >= 1 && $statusBook['book_incomplete'] < 3)
                  <a href="{{ route('author.book.createBook') }}" class="btn btn-primary btn-sm">Add New Book </a>
                @endif
              @endif
              @if ($firstProfile != null)
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Buy Task</button>
    
                <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Prepaid Task Package</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @forelse ($listPrices as $price)
                                  <div class="col-lg-4 col-md-12 mb-4">
                                    <div class="card h-100 shadow-lg">
                                        <div class="card-body">
                                        <div class="text-center p-3">
                                            <h5 class="card-title">{{ $price->name }}</h5>
                                            <small>{{ $price->sub_name }}</small>
                                            <br><br>
                                            <span class="h2">RM{{ $price->price - ($price->price * $income->discount)  }}</span>/{{ $price->task }} Task
                                        </div>
                                        </div>
                                        <div class="card-body text-center">
                                        <a href="{{ route('author.payment', $price->id) }}" class="btn btn-outline-primary btn-lg" style="border-radius:30px">Buy Now</a>
                                        </div>
                                    </div>
                                  </div>
                                @empty
                                    
                                @endforelse
                            </div>
                        </div>
                    </div>
                    </div>
                </div>  
              @endif
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
                        <th>Title</th>
                        <th>Context</th>
                        <th>No of Page</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @forelse ($listBooks as $book)
                      <tr class="text-center">
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->context }}</td>
                        <td>
                          {{ $book->count_pages }}
                        </td>
                        <td>
                          @if ($book->status == 'complete')
                            <span class="badge badge-success">Complete</span>
                          @endif
                          @if ($book->status == 'incomplete')
                            <span class="badge badge-warning">Incomplete</span>
                          @endif
                        </td>
                        <td>
                          @if ($book->status == 'incomplete')
                            <a href="{{ route('author.book.editBook', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('author.book.deleteBook', $book->id) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <form action="{{ route('author.book.publishBook', $book->id) }}" method="POST" class="d-inline">
                              @csrf
                              <button type="submit" class="btn btn-success btn-sm">Publish Epub</button>
                            </form>
                          @endif
                          @if ($book->status == 'complete')
                            <a href="{{ route('author.book.downloadEpub', $book->id) }}" class="btn btn-success btn-sm">Download Epub</a>
                          @endif
                        </td>
                      </tr>
                    @empty
                        
                    @endforelse
                </table>
            </div>
      </div>
    </div>
</div>
<!-- /.col-md-6 -->
@endsection