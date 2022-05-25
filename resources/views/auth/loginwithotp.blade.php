<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{config('app.name')}} | Log in </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-body">
      <p class="login-box-msg">Sign in with OTP to start your session</p>

      <form method="POST" action="{{ route('loginWithOtp') }}">
        @csrf

     
        <div class="input-group mb-3">
            <input type="tel" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Eg:25562650393" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
            @error('mobile')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
           @enderror
           
          </div>





        <div class="input-group mb-3 otp">
            <input type="tel" id="otp" name="otp" class="form-control @error('otp') is-invalid @enderror" placeholder="Eg:2234" value="{{ old('otp') }}" required autocomplete="otp" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-keyboard"></span>
              </div>
            </div>
            @error('otp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
           @enderror
          </div>

        


        <div class="form-group row mb-0 otp">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

            </div>
        </div>
    </form>
    <div class="form-group row send-otp">
        <div class="col-md-8 offset-md-4">
            <button class="btn btn-success" onclick="sendOtp()">Send OTP</button>
        </div>
    </div>

    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<script>
    $('.otp').hide();
    function sendOtp() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // alert($('#mobile').val());
        $.ajax( {
            url:'sendOtp',
            type:'post',
            data: {'mobile': $('#mobile').val()},
            success:function(data) {
                // alert(data);
                if(data != 0){
                    $('.otp').show();
                    $('.send-otp').hide();
                }else{
                    alert('Mobile No not found');
                }

            },
            error:function () {
                console.log('error');
            }
        });
    }
</script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
