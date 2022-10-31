<!DOCTYPE html>
<html lang="en">


<x-admin.layout.head />

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <x-admin.layout.header />
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
     <x-admin.layout.aside />
        <!--End of Main Sidebar Container -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!--Content Header (Page breadcrumb) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('pagename')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">@yield('pagename')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!--End of Content Header (Page breadcrumb) -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" id="success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong></strong> {{ session('success') }}.
                        </div>
                    @endif
                    @if (session('danger'))
                        <div class="alert alert-danger alert-dismissible" id="danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong></strong> {{ session('danger') }}.
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible" id="warning" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong></strong> {{ session('warning') }}.
                        </div>
                    @endif
                </div>
            </section>
            {{--  --}}
            {{ $slot }}
            {{--  --}}
            <!-- End of Main content -->
        </div>
        <!-- End of Content Wrapper -->
        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021-{{ now()->year }} <a href="{{ config('app.url') }}"
                    target="_blank">{{ config('app.name') }}</a></strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->
<x-admin.layout.scripts />
</body>

</html>
