<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Pet Centre Animal Clinic</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
  
    <link rel="stylesheet" href="/css/app.css">
    <link rel="manifest" href="/manifest.json">

</head>
<body class="hold-transition sidebar-mini">
  
<div class="wrapper" id="app">

  <!-- Navbar -->

  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>

    </ul>
   
    <!-- SEARCH FORM -->
  {{--     <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div> --}}

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:#1f2d3d;">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
     {{--  <img src="./img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">Pet Centre Animal <v-progress-linear value=" " color="primary" background-color="primary"></v-progress-linear></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        {{-- <div class="image">
          <img src="./img/profile.png" class="img-circle elevation-2" alt="User Image">
        </div> --}}
        <div class="info">
          <a href="#" class="d-block">
              {{Auth::user()->name}}
              <p>{{Auth::user()->type}}</p>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

         

            @can('isAdmin')
               <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                Dashboard

                </p>
            </router-link>
            </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Management
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Users</p>
                </router-link>
              </li>

            </ul>
          </li>

        {{--   <li class="nav-item">
                <router-link to="/developer" class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Developer
                    </p>
                </router-link>
         </li> --}}
          <li class="nav-item">
                <router-link to="/post" class="nav-link">
                    <i class="nav-icon fas fa-clipboard"></i>
                    <p>
                       Post
                    </p>
                </router-link>
         </li>

                 <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                List of Appointment
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/pending" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Pending</p>
                </router-link>
                 <router-link to="/approved" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Approved</p>
                </router-link>
              </li>

            </ul>
          </li>

          
          <li class="nav-item">
             <router-link to="/qrcode" class="nav-link">
                    <i class="nav-icon fas fa-qrcode"></i>
                    <p>
                        QR CODE
                    </p>
                </router-link>
         </li>
         @endcan
          @can('isUser')
           <li class="nav-item">
            <router-link to="/home" class="nav-link">
                <i class="nav-icon fas fa-home  "></i>
                <p>
                Home

                </p>
            </router-link>
            </li>
            <li class="nav-item">
            <router-link to="/pets" class="nav-link">
                <i class="nav-icon fas fa-paw "></i>
                <p>
                Pet

                </p>
            </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/reservation" class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Appointment
                    </p>
                </router-link>
         </li>
           </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/myqr" class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        My Qr
                    </p>
                </router-link>
         </li>
         <li class="nav-item">
            <router-link to="/maps" class="nav-link">
                <i class="nav-icon fas fa-map-marker-alt  "></i>
                <p>
                Map

                </p>
            </router-link>
            </li>
         @endcan
        {{--   <li class="nav-item">
                <router-link to="/profile" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Profile
                    </p>
                </router-link>
         </li> --}}

          <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    <i class="nav-icon fa fa-power-off "></i>
                    <p>
                        {{ __('Logout') }}
                    </p>
                 </a>

             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
             </form>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view>

        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2019 <a href="https://adminlte.io">Pet Centre Animal Clinic</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

@auth
<script>
    window.user = @json(auth()->user())
</script>
@endauth

<script src="/js/app.js"></script>
</body>
</html>
