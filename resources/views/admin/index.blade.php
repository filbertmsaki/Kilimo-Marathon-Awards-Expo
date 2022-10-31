<x-admin.layout.app-layout>
    @section("title",'Dashboard ')
    @section("pagename",'Dashboard')
    @section('css')
    @endsection
    @section('script')
    @endsection
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Award Categories</span>
                            <span class="info-box-number">

                                {{ $categories_count }}

                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-award"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Award Nominees</span>
                            <span class="info-box-number"> {{ $nominees_count }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i
                                class="fas fa-running"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Marathon Runners</span>
                            <span class="info-box-number">{{ $runners_count }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bell"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Subscribes</span>
                            <span class="info-box-number">{{ $subscribers_count }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </section>
</x-admin.layout.app-layout>
