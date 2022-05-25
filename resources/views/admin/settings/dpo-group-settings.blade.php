@extends("admin.layout.app")
@section("title",'Dpo Settings')
@section("pagename",'Dpo Settings')
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
    <form method="POST" action="{{ route('admin.payments_settings.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="general_settings_id" name="general_settings_id" value="@if($dpo_settings !==null){{ $dpo_settings->first()->slug }}@endif">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Dpo Settings</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                            
                                    <div class="form-group">
                                        <label for="enable_dpo">Enable Dpo</label>

                                        <select  class="form-control" id="enable_dpo" name="enable_dpo"  style="width: 100%;">
                                            @if($dpo_settings->first()->enable_dpo == 'yes' )
                                            <option value="yes" selected>@if($dpo_settings !==null){{ $dpo_settings->first()->enable_dpo }}@endif</option>
                                            <option value="no">no</option>
                                            @endif
                                            @if ($dpo_settings->first()->enable_dpo == 'no' )
                                            <option value="yes">yes</option>
                                            <option value="no" selected>@if($dpo_settings !==null){{ $dpo_settings->first()->enable_dpo }}@endif</option>
                                            @endif
                                           
                                        </select>
                                        @if ($errors->has('enable_dpo'))
                                        <span class="text-danger">{{ $errors->first('enable_dpo') }}</span>
                                        @endif
                                    </div>
                                   
                              
                                <div class="form-group">
                                    <label for="dpo_sandbox">Dpo Live</label>
                                    <select  class="form-control" id="dpo_sandbox" name="dpo_sandbox"  style="width: 100%;">
                                        @if($dpo_settings->first()->dpo_sandbox =='1' )
                                        <option value="{{ $dpo_settings->first()->dpo_sandbox }}" selected>True</option>
                                        <option value="0">False</option>
                                        @elseif ($dpo_settings->first()->dpo_sandbox =='0' )
                                        <option value="1">True</option>
                                        <option value="{{ $dpo_settings->first()->dpo_sandbox }}" selected>False</option>
                                        @endif
                                       
                                    </select>
                                    @if ($errors->has('dpo_sandbox'))
                                    <span class="text-danger">{{ $errors->first('dpo_sandbox') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="dpo_base_url">Site Url</label>
                                    <input type="text" id="dpo_base_url" name="dpo_base_url" class="form-control" value="@if($dpo_settings !==null){{ $dpo_settings->first()->dpo_base_url }}@endif">
                                    @if ($errors->has('dpo_base_url'))
                                    <span class="text-danger">{{ $errors->first('dpo_base_url') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="dpo_company_token">Dpo Company Token</label>
                                    <input type="text" id="dpo_company_token" name="dpo_company_token" class="form-control" value="@if($dpo_settings !==null){{ $dpo_settings->first()->dpo_company_token }}@endif">
                                    @if ($errors->has('dpo_company_token'))
                                    <span class="text-danger">{{ $errors->first('dpo_company_token') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="dpo_default_currency">Dpo Default Currency</label>
                                    <input type="text" id="dpo_default_currency" name="dpo_default_currency" class="form-control" value="@if($dpo_settings !==null){{ $dpo_settings->first()->dpo_default_currency }}@endif">
                                    @if ($errors->has('dpo_default_currency'))
                                    <span class="text-danger">{{ $errors->first('dpo_default_currency') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="dpo_default_country">Dpo Default Country</label>
                                    <input type="text" id="dpo_default_country" name="dpo_default_country" class="form-control" value="@if($dpo_settings !==null){{ $dpo_settings->first()->dpo_default_country }}@endif">
                                    @if ($errors->has('dpo_default_country'))
                                    <span class="text-danger">{{ $errors->first('dpo_default_country') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="dpo_default_service">Dpo Default Service</label>
                                    <input type="text" id="dpo_default_service" name="dpo_default_service" class="form-control" value="@if($dpo_settings !==null){{ $dpo_settings->first()->dpo_default_service }}@endif">
                                    @if ($errors->has('dpo_default_service'))
                                    <span class="text-danger">{{ $errors->first('dpo_default_service') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="dpo_default_service_description">Dpo Default Service Description</label>
                                    <input type="text" id="dpo_default_service_description" name="dpo_default_service_description" class="form-control" value="@if($dpo_settings !==null){{ $dpo_settings->first()->dpo_default_service_description }}@endif">
                                    @if ($errors->has('dpo_default_service_description'))
                                    <span class="text-danger">{{ $errors->first('dpo_default_service_description') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
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