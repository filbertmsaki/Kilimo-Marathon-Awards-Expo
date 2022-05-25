@extends("admin.layout.app")
@section("title",'New Mail')
@section("pagename",'New Mail')
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
    <link rel="stylesheet" href="{{ asset('css/fileinput.css') }}">

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
        .fileinput-upload-button{
          display: none;
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
<script src="{{ asset('js/fileinput.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
  $(document).ready(function() {
          //Initialize Select2 Elements
          $('.select2').select2();
                //Add text editor
      // $('#compose-textarea').summernote();

      $('#compose-textarea').summernote({
        toolbar: [
  ['style', ['style']],
  ['font-style', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
  ['font', ['fontname','fontsize','color']],
  ['para', ['ul', 'ol', 'paragraph','height']],
  ['table', ['table']],
  ['insert', ['link', 'picture', 'video', 'hr']],
  ['misc', ['fullscreen', 'codeview','undo', 'redo', 'help']],

],
});

  });
 
  </script>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <a href="{{ route('admin.mails.index') }}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>
  
            @include('admin.mails.aside')
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">New Mail</h3>
            </div>
            <form action="{{ route('admin.mails.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                        <select class="select2"  class="form-control" name="recipients[]" multiple="multiple" data-placeholder="To:" style="width: 100%;">
                            @foreach ($users as $user )
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('recipients'))
                        <span class="text-danger">{{ $errors->first('recipients') }}</span>
                        @endif
                  </div>
                  <div class="form-group">
                    <select class="select2"  class="form-control" name="cc[]" multiple="multiple" data-placeholder="Cc:" style="width: 100%;">
                        @foreach ($users as $user )
                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('cc'))
                    <span class="text-danger">{{ $errors->first('cc') }}</span>
                    @endif
                  </div>
                  <div class="form-group">
                    <select class="select2"  class="form-control" name="bcc[]" multiple="multiple" data-placeholder="Bcc:" style="width: 100%;">
                        @foreach ($users as $user )
                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('bcc'))
                    <span class="text-danger">{{ $errors->first('bcc') }}</span>
                    @endif
                  </div>
               
                <div class="form-group">
                  <input class="form-control" name="subject" placeholder="Subject:">
                  @if ($errors->has('subject'))
                    <span class="text-danger">{{ $errors->first('subject') }}</span>
                  @endif
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea" name="body" class="form-control" style="height: 500px">
                     
                    </textarea>
                    @if ($errors->has('body'))
                    <span class="text-danger">{{ $errors->first('body') }}</span>
                  @endif
                </div>
       

                <div class="form-group">
                  <label class="col-sm-9 control-label">
                      Attachment(s)
                  </label>
                  <div class="col-sm-12">
                      <span class="btn btn-default btn-file">
                          <input id="input-2" name="attachments[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true">
                          @if ($errors->has('attachments'))
                          <span class="text-danger">{{ $errors->first('attachments') }}</span>
                        @endif
                        </span>
                  </div>
                </div>
          
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  {{-- <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button> --}}
                  <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                </div>
                <button type="reset" class="btn btn-default" onclick="window.location='{{ route('admin.mails.index') }}'"><i class="fas fa-times"></i> Discard</button>
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