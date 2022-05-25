@extends("admin.layout.app")
@section("title",'User Profile Page')
@section("pagename",'Profile')
@section('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
 
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <style>
    @media (min-width: 576px) {
  /* CSS that should be displayed if width is equal to or less than 800px goes here */
        .modal-dialog {
          max-width: 900px;
          margin: 1.75rem auto;
      }
  }
  </style>
@endsection
@section('script')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
      @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
      
      <div class="row">
        
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                @if ( auth()->user()->photo )
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ asset('image/').'/'.auth()->user()->photo}}"
                     alt="{{ auth()->user()->name }}">
                @else
                <img class="profile-user-img img-fluid img-circle"
                src="{{ asset('img/avatar.png') }}"
                alt="User profile picture">
                @endif
                
              </div>
                @if (auth()->user()->first_name || auth()->user()->last_name)
              <h3 class="profile-username text-center">{{ auth()->user()->first_name .' '.auth()->user()->last_name }}<br>  <i style="font-size: 13px;">~ {{ auth()->user()->name  }}</i></h3>
                @else    
              <h3 class="profile-username text-center">{{ auth()->user()->name  }}</h3>

                @endif
                @if ($profile !== null)
                <p class="text-muted text-center">{{ $profile->job_title  }}</p>

                @endif
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-9">
                <!-- About Me Box -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Education</strong>
      
                    <p class="text-muted">@if ($profile !== null){{ $profile->education  }} @endif
                      </p>
      
                    <hr>
      
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
      
                    <p class="text-muted">@if ($profile !== null){{ auth()->user()->address  }} @endif</p>
      
                    <hr>
      
                    <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
      
                    <p class="text-muted">
                      @if ($profile !== null){{ $profile->skills  }} @endif
                    </p>
      
                    <hr>
      
                    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
      
                    <p class="text-muted">@if ($profile !== null){{ $profile->notes  }} @endif</p>
                    
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-sm-4">
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#user-profile-data">
                          Edit Profile
                        </button>
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#user-profile-data-info">
                          Edit Profile Info
                        </button>
                      </div>
                   
                    </div>
                  </div>
                  
                </div>
                <!-- /.card --> 
          <!-- /.card -->
          <div class="modal fade" id="user-profile-data">
            <div class="modal-dialog">
              <div class="modal-content bg-dark">
                <div class="modal-header">
                  <h4 class="modal-title">Edit User Profile</h4>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="POST" action="{{ route('admin.profile_update') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="first_name">First name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ auth()->user()->first_name }}" id="first_name" placeholder="First Name">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ auth()->user()->last_name }}" id="last_name" placeholder="Last Name">
                      </div>

                    </div>
                    <div class="row">
                    <div class="form-group col-md-6">
                      <label for="email">Email address</label>
                      <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" id="email" placeholder="Enter email" disabled>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="mobileNo">Mobile Number</label>
                      <input type="tel" name="mobile" class="form-control" value="{{ auth()->user()->mobile }}" id="mobileNo" placeholder="Eg:+255**********">
                    </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <input type="tel" name="address" class="form-control" value="{{ auth()->user()->address }}" id="address" placeholder="Enter Address">
                      </div>
                      <div class="form-group col-md-6">
                        <div class="form-group">
                          <label for="exampleInputFile">Profile Photo <i style="font-size: 14px; color:red;">Dimension:ratio 1/1 ie:Square</i></label>
                          <div class="">
                            <div class="custom-file">
                              <input name="photo" type="file" class="custom-file-input" id="exampleInputFile">
                              <label class="custom-file-label" for="exampleInputFile">Choose file </label>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <label for="current_password">Option to change Password</label>

                    <div class="row">
                      <div class="form-group col-md-4">
                        <label for="current_password">Current Password</label>
                        <input id="current_password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                        @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <div class="form-group col-md-4">
                        <label for="password">New Password</label>
                        <input id="password" type="password" class="form-control" name="password" autocomplete="password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <div class="form-group col-md-4">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" autocomplete="password_confirmation">
                      
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->               
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                  <button type="submit" name="user_data"  class="btn btn-outline-light">Save changes</button>
                </div>
              </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <div class="modal fade" id="user-profile-data-info">
            <div class="modal-dialog" style="max-width: 900px;">
              <div class="modal-content bg-dark">
                <div class="modal-header">
                  <h4 class="modal-title">Edit User Profile Info</h4>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="POST" action="{{ route('admin.profile_update') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="education">Education</label>
                        <input type="text" name="education" class="form-control" value="@if ($profile !== null){{ $profile->education  }}@endif" id="first_name" placeholder="Education Background">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="job_title">Job Title</label>
                        <input type="text" name="job_title" class="form-control" value="@if ($profile !== null){{ $profile->job_title  }}@endif" id="job_title" placeholder="Eg:Software Engineer">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                    <div class="form-group">
                      <label for="skills">Skills</label>
                      <input type="text" name="skills" class="form-control" value="@if ($profile !== null){{ $profile->skills  }}@endif" id="skills" placeholder="Skills" >
                    </div>
                      </div>

                    </div>
                  
                 

                    <div class="form-group">
                      <label for="notes"> Notes</label>
                      <textarea name="notes" class="form-control" rows="3" placeholder="Enter ...">@if ($profile !== null){{ $profile->notes  }}@endif</textarea>
                    </div>
                  </div>
                  <!-- /.card-body -->               
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                  <button type="submit" name="user_data_info"  class="btn btn-outline-light">Save changes</button>
                </div>
              </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
        </div>
        <!-- /.col -->
      </div>
    

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  
@endsection