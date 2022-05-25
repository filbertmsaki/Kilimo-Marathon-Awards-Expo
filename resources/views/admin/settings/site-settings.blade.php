@extends("admin.layout.app")
@section("title",'Site Settings')
@section("pagename",'Site Settings')
@section('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
@endsection
@section('script')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
@endsection

@section('content')
<section class="content" style="margin-bottom: 20px;">
    <form method="POST" action="{{ route('admin.site_settings_store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="general_settings_id" name="general_settings_id" value="@if($site_settings !==null){{ $site_settings->first()->id }}@endif">

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Site Identity</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="site_name">Site Name</label>
                        <input type="text" id="site_name" name="site_name" class="form-control" value="@if($site_settings !==null){{ $site_settings->first()->site_name }}@endif">
                        @if ($errors->has('site_name'))
                           <span class="text-danger">{{ $errors->first('site_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="site_tagline">Site Tagline</label>
                        <textarea id="site_tagline" class="form-control" name="site_tagline" rows="4">@if($site_settings !==null){{ $site_settings->first()->site_tagline}}@endif</textarea>
                        @if ($errors->has('site_tagline'))
                           <span class="text-danger">{{ $errors->first('site_tagline') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="site_url">Site Url</label>
                        <input type="text" id="site_url" name="site_url" class="form-control" value="@if($site_settings !==null){{ $site_settings->first()->site_url }}@endif">
                        @if ($errors->has('site_url'))
                           <span class="text-danger">{{ $errors->first('site_url') }}</span>
                        @endif
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                
            </div>
            <div class="col-md-6">
                <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Site Image</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="site_logo">Site Logo</label>
                        @if($site_settings !==null)
                            @if($site_settings->first()->site_logo !== null)
                                <div class="" style="margin-bottom: 10px;">
                                    <img class="img-fluid" src="{{ asset('image').'/'.$site_settings->first()->site_logo }}" alt="Site_logo">
                                </div>
                            @endif
                        @endif

                        <input type="file" id="site_logo" name="site_logo" class="form-control" >
                        @if ($errors->has('site_logo'))
                           <span class="text-danger">{{ $errors->first('site_logo') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="site_icon">Site Icon <i style="font-size: 12px;"> Site Icons should be square and at least 512 × 512 pixels.</i></label>

                            @if($site_settings !==null)
                                @if($site_settings->first()->site_icon !== null)
                                    <div class=""  style="margin-bottom: 10px;">
                                        <img class="img-fluid" style="width:150px;" src="{{ asset('image').'/'.$site_settings->first()->site_icon }}" alt="Site_logo">
                                    </div>
                                @endif
                            @endif
                        <input type="file" id="site_icon" name="site_icon" class="form-control" >
                        @if ($errors->has('site_icon'))
                           <span class="text-danger">{{ $errors->first('site_icon') }}</span>
                        @endif
                    </div>
                
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <input type="submit" value="Save Changes" class="btn btn-success float-right">
            </div>
        </div>
    </form>
  </section>
  
@endsection