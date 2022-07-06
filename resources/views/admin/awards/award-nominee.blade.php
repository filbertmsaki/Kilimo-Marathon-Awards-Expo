@extends('admin.layout.app')
@section('title', 'Award Nominee List')
@section('pagename', 'Award Nominee List')
@section('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .select2-container--bootstrap4 .select2-selection {
            width: 100%;
            background-color: transparent;
            border: 1px solid #6c757d;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            color: #fff;
        }

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
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>


    <script>
        $(function() {

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
    <style>
        select {
            /* for Firefox */
            -moz-appearance: none;
            /* for Chrome */
            -webkit-appearance: none;
        }

        /* For IE10 */
        select::-ms-expand {
            display: none;
        }
    </style>
    <script>
        $(function() {

            const date = new Date();
            const month = date.getMonth() + 1;
            const today = (month.toString().length > 1 ? month : "0" + month) + "_" + date.getDate() + "_" + date
                .getFullYear() + "_" + date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();

            var table = $('#award_nominee').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                pageLength: 10,
                responsive: true,
                "lengthChange": true,
                "autoWidth": false,
                processing: true,
                dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fa fa-files-o"></i> Copy',
                        titleAttr: 'Copy',
                        className: 'btn btn-default btn-sm'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa fa-files-o"></i> CSV',
                        titleAttr: 'CSV',
                        title: 'nominees_lists_' + today,
                        className: 'btn btn-default btn-sm',
                        exportOptions: {
                            columns: ':not(:first,:last)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-files-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'nominees_lists_' + today,
                        className: 'btn btn-default btn-sm',
                        exportOptions: {
                            columns: ':not(:first,:last)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        titleAttr: 'PDF',
                        title: 'nominees_lists_' + today,
                        className: 'btn btn-default btn-sm',
                        exportOptions: {
                            columns: ':not(:first,:last)'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        titleAttr: 'Print',
                        title: 'nominees_lists_' + today,
                        className: 'btn btn-default btn-sm',
                        exportOptions: {
                            columns: ':not(:first,:last)'
                        }
                    },
                ],

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /*  When user click add user button */
            $('#create-new-award-nominee').click(function() {
                $('#btn-save').val("create-award-category");
                $('#nomineeForm').trigger("reset");
                $('#nomineeEvent').html("Add New Nominee");
                $('#add-nominee').modal('show');
            });

            /* When click edit user */
            $('body').on('click', '.edit-nominee', function() {
                var award_nominee_id = $(this).data('id');
                $.get('/admin/awards/nominee/' + award_nominee_id + '/edit',
                    function(data) {
                        $('#userCrudModal').html("Edit Award Nominee");
                        $('#btn-save').val("edit-nominee");
                        $('#ajax-crud-modal').modal('show');
                        $('#award_nominee_id').val(data.id);

                        $('.verified').val(data.verified);
                        $('#nominee_full_name').val(data.full_name);
                        $('#nominee_mobile').val(data.mobile);
                        $('#nominee_email').val(data.email);
                        $('#nominee_address').val(data.address);
                        $('#nominee_company').val(data.company_individual);
                    })
            });
            $("#master").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });
    </script>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- /.card -->
                    <form method="POST">
                        @csrf
                        @method('delete')
                        <div class="card">
                            <div class="card-header">
                                <button style="margin-bottom: 10px" type="submit" class="btn btn-primary delete_all"
                                    formaction="{{ route('admin.awards_nominees_delete') }}">Delete Selected
                                    Nominee</button>

                                <button type="button" class="btn btn-secondary bg-dark" id="create-new-award-nominee"
                                    data-toggle="modal" data-target="#add-category" style="float: right">
                                    Add Nominee
                                </button>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="award_nominee" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="20px"><input type="checkbox" id="master"></th>
                                            <th>S/N</th>
                                            <th>Nominee Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Category</th>
                                            <th>Verified</th>
                                            <th>Votes</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($award_nominees as $nominee)
                                            <tr id="award_nominee_id_{{ $nominee->id }}">
                                                <td><input type="checkbox" name="category_id[]"
                                                        value="{{ $nominee->id }}" id="sub_chk_{{ $nominee->id }}"
                                                        class="sub_chk"></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $nominee->full_name }}</td>
                                                <td>{{ $nominee->mobile }}</td>
                                                <td>{{ $nominee->email }}</td>
                                                <td>{{ $nominee->awardcategory->name }}</td>
                                                <td>
                                                    @if ($nominee->verified == 1)
                                                        Verified
                                                    @else
                                                        Not Verified
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ $nominee->vote ?? '0' }}
                                                </td>
                                                <td class="">
                                                    <a href="javascript:void(0)" id="edit-nominee"
                                                        class="btn btn-outline-primary  btn-sm edit-nominee"
                                                        data-id="{{ $nominee->id }}"><i class="fa fa-bell"></i> Edit</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>


                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </form>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

        <div class="modal fade" id="ajax-crud-modal" ria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="userCrudModal"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="nomineeForm" name="nomineeForm" method="POST"
                            action="{{ route('admin.award_nominee_store') }}">
                            @csrf
                            <input type="hidden" name="award_nominee_id" id="award_nominee_id">

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror"
                                                id="nominee_full_name" name="full_name" placeholder="Nominee Name" required
                                                autocomplete="full_name" autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                            @error('full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                id="nominee_address" name="address" placeholder="address Name"
                                                autocomplete="address" autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-map-marked-alt"></span>
                                                </div>
                                            </div>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('mobile') is-invalid @enderror"
                                                id="nominee_mobile" name="mobile" placeholder="Nominee Mobile"
                                                autocomplete="mobile" autofocus>
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
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="nominee_email" name="email" placeholder="Nominee Email"
                                                autocomplete="email" autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('company_individual') is-invalid @enderror"
                                                id="nominee_company" name="company_individual"
                                                placeholder="Company/Individual" autocomplete="company_individual"
                                                autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                            @error('company_individual')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">



                                            <select class="form-control select2bs4" class="form-control verified"
                                                name="verified" style="width: 100%;">
                                                <option value="1">Verified</option>
                                                <option value="0">Not Verified</option>

                                            </select>
                                            @if ($errors->has('verified'))
                                                <span class="text-danger">{{ $errors->first('verified') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                <button type="submit" name="award-nominee" class="btn btn-outline-light">Save
                                    changes</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="add-nominee" ria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="nomineeEvent"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form method="POST" action="{{ route('admin.awards_nominees_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror"
                                                id="full_name" name="full_name" placeholder="Nominee Name" required
                                                autocomplete="full_name" autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                            @error('full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Nominee Email" required
                                            autocomplete="email" autofocus>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                        <span class="help-block"><strong></strong></span>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <input type="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                            id="mobile" name="mobile" placeholder="Nominee Mobile" required
                                            autocomplete="mobile" autofocus>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-phone"></span>
                                            </div>
                                        </div>
                                        <span class="help-block"><strong></strong></span>
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror" id="address"
                                                name="address" placeholder="Nominee Address" required
                                                autocomplete="address" autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-map-marked-alt"></span>
                                                </div>
                                            </div>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">


                                        <select class="form-control select2bs4" name="category_id" data-placeholder="To:"
                                            style="width: 100%;">
                                            <option>----Select Category ----</option>
                                            @foreach ($award_category as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2bs4" name="company_individual"
                                            data-placeholder="To:" style="width: 100%;">
                                            <option value="Individual">Individual</option>
                                            <option value="Company">Company</option>

                                        </select>
                                        @if ($errors->has('company_individual'))
                                            <span class="text-danger">{{ $errors->first('company_individual') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2bs4" class="form-control" name="verified"
                                            style="width: 100%;">
                                            <option value="1">Verified</option>
                                            <option value="0">Not Verified</option>

                                        </select>
                                        @if ($errors->has('verified'))
                                            <span class="text-danger">{{ $errors->first('verified') }}</span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                <button type="submit" name="award-nominee" value=""
                                    class="btn btn-outline-light btn-save">Save
                                    changes</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


    </section>
@endsection
