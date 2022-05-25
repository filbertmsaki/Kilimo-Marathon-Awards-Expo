@extends("admin.layout.app")
@section("title",'Marathon Settings')
@section("pagename",'Marathon Settings')
@section('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

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
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>





<script>
    $(function () {

      //Date and time picker
      $('#reservationdatetime').datetimepicker({ 
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: { time: 'far fa-clock' } 
        });
          //Date and time picker
          $('#reservationdatetime1').datetimepicker({ 
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: { time: 'far fa-clock' } 
        });
              //Date and time picker
      $('#reservationdatetime2').datetimepicker({ 
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: { time: 'far fa-clock' } 
        });
  
    })
    
  </script>
@endsection

@section('content')
<section class="content" style="margin-bottom: 20px;">
    <form method="POST" action="{{ route('admin.marathon_settings_store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="general_settings_id" name="general_settings_id" value="@if($marathon_settings !==null){{ $marathon_settings->first()->id }}@endif">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Marathon Registration </h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="marathon_registration">Registration Period</label>
                        <select  class="form-control" id="marathon_registration" name="marathon_registration"  style="width: 100%;">
                            @if($marathon_settings->first()->marathon_registration =='1' )
                            <option value="{{ $marathon_settings->first()->marathon_registration }}" selected>Active</option>
                            <option value="0">END</option>
                            @elseif ($marathon_settings->first()->marathon_registration =='0' )
                            <option value="1">Active</option>
                            <option value="{{ $marathon_settings->first()->marathon_registration }}" selected>END</option>
                            @endif
                           
                        </select>
                        @if ($errors->has('marathon_registration'))
                        <span class="text-danger">{{ $errors->first('marathon_registration') }}</span>
                        @endif
                    </div>
                  <!-- Date and time -->
                <div class="form-group">
                    <label>Registration End On</label>
                      <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" name="marathon_registration_time_remain"  data-target="#reservationdatetime" value="<?php echo $marathon_settings->first()->marathon_registration_time_remain;?>"  />
                          <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                          @if ($errors->has('marathon_registration_time_remain'))
                          <span class="text-danger">{{ $errors->first('marathon_registration_time_remain') }}</span>
                       @endif
                      </div>
                  </div>
                  <!-- /.form group -->
                    
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