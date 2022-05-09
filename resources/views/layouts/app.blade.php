<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TestingProject</title>
  @include('partial.head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
@if (Auth::check())

    @include('partial.top')
  <!-- Main Sidebar Container -->

  @include('partial.side-bar')
  @endif
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->  
    <!-- Main content -->    
    <!-- /.card -->
    @yield('content')           
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->  
  @include('partial.footer') 
</div>
<!-- ./wrapper -->
@include('partial.footer-script')
</body>
</html>
