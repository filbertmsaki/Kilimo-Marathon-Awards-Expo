@extends("admin.layout.app")
@section("title",'Award Category Add')
@section("pagename",'Award Category Add')
@section('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
      .select2-container--default .select2-selection--multiple {
            background-color: transparent;
            border: 1px solid #6c757d;

        }
      .select2-container--default .select2-selection--multiple .select2-selection__choice {
          background-color: #1e2124;
        }
    </style>
@endsection
@section('script')
<!-- jQuery -->
<!-- Bootstrap -->
<!-- overlayScrollbars -->
<!-- AdminLTE App -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
  $(document).ready(function() {
          //Initialize Select2 Elements
          $('.select2').select2()
                //Add text editor
      $('#compose-textarea').summernote()
  });
 
  </script>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
     
        <!-- /.col -->
        <div class="col">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Award Category Add</h3>
            </div>
            <form method="POST" action="{{ route('admin.award_category_add') }}" enctype="multipart/form-data">
              @csrf
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                    <input class="form-control" name="name" placeholder="Category Name">
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                  </div>
               
                <div class="form-group">
                  <input class="form-control" name="name_in_swahili" placeholder="Category Name In Swahili">
                  @if ($errors->has('name_in_swahili'))
                    <span class="text-danger">{{ $errors->first('name_in_swahili') }}</span>
                  @endif
                </div>
                <div class="form-group">
                    <label>Category Description</label>
                    <textarea id="compose-textarea" name="category_description" class="form-control" style="height: 500px">
                     
                    </textarea>
                    @if ($errors->has('category_description'))
                    <span class="text-danger">{{ $errors->first('category_description') }}</span>
                  @endif
                </div>
          
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  {{-- <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button> --}}
                  <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Save</button>
                </div>
                <button type="reset" class="btn btn-default" onclick="window.location='{{ route('admin.award_category') }}'"><i class="fas fa-times"></i> Cancel</button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
@endsection