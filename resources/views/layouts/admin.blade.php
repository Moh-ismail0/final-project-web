<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Task Manager | @yield('title')</title>

  <!-- Google Font -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('cms/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link">
          <i class="fas fa-user mr-1"></i> {{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : Auth::user()->name }}
        </span>
      </li>
      <li class="nav-item">
@if(Auth::guard('admin')->check())
    <a href="{{ route('admin.logout') }}" class="nav-link">
        <i class="fas fa-sign-out-alt mr-1"></i>Logout
    </a>
@else
    <a href="{{ route('logout') }}" class="nav-link">
        <i class="fas fa-sign-out-alt mr-1"></i>Logout
    </a>
@endif
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <i class="fas fa-tasks brand-image" style="font-size:24px; margin:8px 10px;"></i>
      <span class="brand-text font-weight-light">Task Manager</span>
    </a>

    <div class="sidebar">
      <div class="form-inline" style="margin-top:15px; margin-bottom:5px;">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          {{-- Dashboard --}}
<a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
  <i class="nav-icon fas fa-home"></i>
  <p>Dashboard</p>
</a>

          <li class="nav-header">Content Management</li>

          {{-- Tasks --}}
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Tasks
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('tasks.index') }}" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>All Tasks</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tasks.create') }}" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Add Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tasks.trashed') }}" class="nav-link">
                  <i class="fas fa-trash nav-icon"></i>
                  <p>Trashed Tasks</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Categories --}}
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Categories
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>All Categories</p>
                </a>
              </li>
            </ul>
          </li>
          {{-- Admins --}}
<li class="nav-item">
    <a href="{{ route('admins.index') }}" class="nav-link {{ request()->routeIs('admins.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>Admins</p>
    </a>
</li>

          <li class="nav-header">Settings</li>

          {{-- Logout --}}
          <li class="nav-item">
@if(Auth::guard('admin')->check())
    <a href="{{ route('admin.logout') }}" class="nav-link">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
@else
    <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
@endif
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('main-title')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">@yield('sub-title')</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    @yield('content')
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy;{{ now()->year }} <a href="#">Task Manager</a>.</strong> All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>{{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : Auth::user()->name }}</b>
    </div>
  </footer>

</div>

<!-- jQuery -->
<script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('cms/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('cms/dist/js/adminlte.js') }}"></script>
<!-- Axios -->
<script src="{{ asset('js/axios.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<!-- CRUD JS -->
<script src="{{ asset('js/crud.js') }}"></script>
@yield('scripts')
</body>
</html>
