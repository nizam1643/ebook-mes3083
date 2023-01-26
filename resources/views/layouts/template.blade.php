<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ strtoupper(Request::segment(2)) }} | {{ env('APP_NAME') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('dash-template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dash-template/dist/css/adminlte.min.css') }}">
    @yield('style')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa fa-exclamation-triangle"></i><span><b>LOGOUT</b></span>
        </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link d-flex justify-content-center">
      <img src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Ebook Maker</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
        <div class="image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('author.dashboard') }}" class="nav-link {{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
              <i class="nav-icon fas fa fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @if (Auth::user()->role == 'author')
            <li class="nav-item">
              <a href="{{ !auth()->user()->authorProfile ? route('author.createForm') : route('author.editForm') }}" class="nav-link {{ Request::segment(2) == 'createForm' ? 'active' : '' }} {{ Request::segment(2) == 'editForm' ? 'active' : '' }}">
                <i class="nav-icon fas fa fa-user"></i>
                <p>
                  Profile
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('author.paymentHistory') }}" class="nav-link {{ Request::segment(2) == 'paymentHistory' ? 'active' : '' }}">
                <i class="nav-icon fas fa fa-credit-card"></i>
                <p>
                  Payment History
                </p>
              </a>
            </li>
          @endif
          @if (Auth::user()->role == 'admin')
          <li class="nav-item">
            <a href="{{ route('admin.package.index') }}" class="nav-link {{ Request::segment(2) == 'package' ? 'active' : '' }}">
              <i class="nav-icon fas fa fa-shopping-basket"></i>
              <p>
                Author Package
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.income.index') }}" class="nav-link {{ Request::segment(2) == 'income' ? 'active' : '' }}">
              <i class="nav-icon fas fa fa-credit-card"></i>
              <p>
                Author Income
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.author.index') }}" class="nav-link {{ Request::segment(2) == 'author' ? 'active' : '' }}">
              <i class="nav-icon fas fa fa-user"></i>
              <p>
                Author Profile
              </p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @yield('header')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          @yield('content')
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      v3.1.7
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('dash-template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('dash-template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dash-template/dist/js/adminlte.min.js') }}"></script>
@yield('script')
</body>
</html>
