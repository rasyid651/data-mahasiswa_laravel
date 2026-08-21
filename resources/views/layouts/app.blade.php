<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    {{-- CSS AdminLTE & Plugins --}}
    <link rel="stylesheet" href="{{ asset('assets-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets-template/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets-template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-template/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-template/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets-template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-template/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-template/plugins/summernote/summernote-bs4.min.css') }}">

    <script src="{{ asset('assets-template/plugins/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    @stack('styles') {{-- Tempat menaruh CSS khusus halaman tertentu --}}
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        {{-- Preloader --}}
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets-template/dist/img/AdminLTELogo.png') }}"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        {{-- Navbar --}}
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a></li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" data-widget="fullscreen" href="#" role="button"><i
                            class="fas fa-expand-arrows-alt"></i></a></li>
                <li class="nav-item"><a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true"
                        href="#" role="button"><i class="fas fa-th-large"></i></a></li>
            </ul>
        </nav>

        {{-- Main Sidebar --}}
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('assets-template/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets-template/dist/img/user2-160x160.jpg') }}"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        {{-- Mengganti $_SESSION['nama'] dengan Auth Laravel --}}
                        <a href="#" class="d-block">{{ Auth::check() ? Auth::user()->nama : 'Guest' }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-header">Daftar Menu</li>

                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}"
                                class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-box"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.index') }}"
                                class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>Data Mahasiswa</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ Route::has('pegawai.index') ? route('pegawai.index') : '#' }}"
                                class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Data Pegawai</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('email.index') }}"
                                class="nav-link {{ request()->routeIs('email.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Kirim Email</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('akun.index') }}"
                                class="nav-link {{ request()->routeIs('akun.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Data Akun</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link bg-danger w-100 text-left border-0"
                                    style="cursor: pointer;">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>Logout</p>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        {{-- CONTENT WRAPPER (Tempat halaman seperti index/create/edit akan dimuat) --}}
        <div class="content-wrapper pt-2">
            @yield('content')
        </div>

        {{-- Footer --}}
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0-rc
            </div>
        </footer>

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    {{-- JS AdminLTE & Plugins --}}
    <script src="{{ asset('assets-template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('assets-template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <script src="{{ asset('assets-template/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets-template/dist/js/adminlte.min.js') }}"></script>

    {{-- DataTables --}}
    <script src="{{ asset('assets-template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets-template/dist/js/demo.js') }}"></script>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

    {{-- Script Inisialisasi (Diberi pengecekan if agar tidak error di halaman yg tidak butuh) --}}
    <script>
        $(function() {
            if ($("#example").length) $("#example").DataTable();
        });
    </script>

    <!-- datatable serverside -->
    @push('scripts')


        @stack('scripts') {{-- Tempat menaruh JS khusus halaman tertentu --}}
    </body>

    </html>
