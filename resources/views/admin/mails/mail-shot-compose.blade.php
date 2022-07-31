@extends('admin.layout.app')
@section('title', 'Voting Mail')
@section('pagename', 'Voting Mail')
@section('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
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

        .fileinput-upload-button {
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
            $('#compose-textarea').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font-style', ['bold', 'italic', 'underline', 'strikethrough', 'superscript',
                        'subscript', 'clear'
                    ]],
                    ['font', ['fontname', 'fontsize', 'color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'help']],

                ],
            });

        });
    </script>
    <script>
        $(function() {
            $('.select2').select2()
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
                        <form action="{{ route('admin.mails.mailshot.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="form-group">
                                    <select class="select2" id="to" name="recipients[]" multiple="multiple"
                                        data-placeholder="To:" style="width: 100%;">
                                        <option value="0"> Sent to All </option>
                                        @foreach ($to as $data)
                                            <option value="{{ $data->email }}">{{ $data->email }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('recipients'))
                                        <span class="text-danger">{{ $errors->first('recipients') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="subject" value="{{ old('subject') }}" placeholder="Subject:">
                                    @if ($errors->has('subject'))
                                        <span class="text-danger">{{ $errors->first('subject') }}</span>
                                    @endif
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-right">
                                    {{-- <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button> --}}
                                    <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i>
                                        Send</button>
                                </div>
                                <button type="reset" class="btn btn-default"
                                    onclick="window.location='{{ route('admin.mails.index') }}'"><i
                                        class="fas fa-times"></i> Discard</button>
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
