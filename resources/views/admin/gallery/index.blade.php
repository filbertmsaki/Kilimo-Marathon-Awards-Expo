@extends("admin.layout.app")
@section("title",'Gallery')
@section("pagename",'Gallery')
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
{{-- <script type="text/javascript">
    $(document).ready(function(){
      result = ['db1','db2','db3']
      for(i=0;i<result.length;i++){
        $("#project").append(new Option(result[i],result[i]));
      }
  
    })
  </script> --}}
<script>
    $(function () {

        const date = new Date();
        const month = date.getMonth() + 1;
        const today = (month.toString().length > 1 ? month : "0" + month) + "_" + date.getDate() + "_" + date
            .getFullYear() + "_" + date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();

        var table = $('#gallery').DataTable({
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
                    title: 'gallery_lists_' + today,
                    className: 'btn btn-default btn-sm',
                    exportOptions: {
                        columns: ':not(:first,:last)'
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-files-o"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'gallery_lists_' + today,
                    className: 'btn btn-default btn-sm',
                    exportOptions: {
                        columns: ':not(:first,:last)'
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    titleAttr: 'PDF',
                    title: 'gallery_lists_' + today,
                    className: 'btn btn-default btn-sm',
                    exportOptions: {
                        columns: ':not(:first,:last)'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    titleAttr: 'Print',
                    title: 'gallery_lists_' + today,
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
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /*  When user click add user button */
        $('#upload-image').click(function () {
            $('#btn-save').val("create-award-category");
            $('#galleryForm').trigger("reset");
            $('#addgalleryHeader').html("Add New gallery");
            $('#add-gallery').modal('show');
        });

        /* When click edit user */
        $('body').on('click', '.edit-gallery', function () {
            var gallery_id = $(this).data('id');


            $.get('/admin/gallery/' + gallery_id + '/edit',
                function (data) {
                    $('#editcrudModal').on('hidden.bs.modal', function (e) {
                        $(this).removeData();
                    });

                    $('#editcrudModal').html("Edit gallery");
                    $('#btn-save').val("edit-gallery");
                    $('#ajax-crud-modal').modal('show');
                    $('#gallery_id').val(data.id);
                    $('#name').val(data.name);
                    $('#short_description').val(data.short_description);
                    $('#price').val(data.price);
                    $('#discount').val(data.discount);
                    $('#quantity').val(data.quantity);
                    $("#imageData").attr("src", "{{ url('gallery')}}" + '/' + data.image);

                    $.each(data.gallery_category, function (index, element) {
                            $( '#project' ).append(new Option('element.name', 'element.id'));
                         })
                })
        });
        $("#master").click(function () {
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
                                formaction="{{ route('admin.gallery.delete_all') }}">Delete Selected Image</button>

                            <button type="button" class="btn btn-secondary bg-dark" id="upload-image"
                                data-toggle="modal" data-target="#add-image" style="float: right">
                               Upload Image
                            </button>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="gallery" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="20px"><input type="checkbox" id="master"></th>
                                        <th>S/N</th>
                                        <th>Image Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gallery as $gallery )
                                    <tr id="gallery_id_{{ $gallery->id }}">
                                        <td><input type="checkbox" name="gallery_id[]" value="{{ $gallery->id }}"
                                                id="sub_chk_{{ $gallery->id }}" class="sub_chk"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gallery->alt_text}}</td>
                                        <td>
                                            <div class="" style="margin-bottom: 10px;">
                                                <img width="100" class="img-fluid"
                                                    src="{{ asset($gallery->path).'/'.$gallery->image }}" alt="Site_logo">
                                            </div>

                                        </td>
                                        <td class="">
                                            {{-- <a href="javascript:void(0)" id="edit-gallery" style="margin-right: 5px;"
                                                class="fa fa-edit edit-gallery" data-id="{{ $gallery->id }}"
                                                data-toggle="tooltip" data-placement="top" title="Edit"></a> --}}
                                            <a href="{{ route('admin.gallery.delete',$gallery->id) }}"
                                                id="delete-gallery" class=" delete-gallery fa fa-trash "
                                                data-toggle="tooltip" data-placement="top" title="Delete"></a>

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
                    <h4 class="modal-title" id="editcrudModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="gallery_id" id="gallery_id">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">gallery Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                            name="name" placeholder=" Name" required autocomplete="name" autofocus>
        
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="short_description">Short Description</label>
                                        <textarea id="short_description" class="form-control" id="short_description" name="short_description"
                                            rows="4"></textarea>
                                        @if ($errors->has('short_description'))
                                        <span class="text-danger">{{ $errors->first('short_description') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" class="form-control" id="description" name="description"
                                            rows="4"></textarea>
                                        @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="price">gallery Price</label>
                                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                                            name="price" placeholder=" Price" required autocomplete="price" autofocus>
        
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="discount">gallery Discount</label>
                                        <input type="text" class="form-control @error('discount') is-invalid @enderror" id="discount"
                                            name="discount" placeholder=" Discount" required autocomplete="discount" autofocus>
        
                                        @error('discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="quantity">gallery Quantity</label>
                                        <input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                            name="quantity" placeholder=" Name" required autocomplete="quantity" autofocus>
                                        @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="category_id">gallery Category</label>
                                      
                                            <select id="project" name="category_id" placeholder=" category_id" required autocomplete="category_id" autofocus class="form-control @error('category_id') is-invalid @enderror">
                                                <option value="">select database</option>
                                        </select>
                                       
                                        @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                            
                            <div class="form-group">
                                <label for="image">gallery Image</label>
                                <div style="margin-bottom: 10px;" class="" id="galleryImage"></div>

                                <div class="" style="margin-bottom: 10px;">
                                    <img width="300" class="img-fluid" id="imageData" alt="Site_logo">
                                </div>


                                <input type="file" id="image" name="image" class="form-control">
                                @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>




                        </div>
                        <!-- /.card-body -->
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" name="award-gallery" value=""
                                class="btn btn-outline-light btn-save">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="add-gallery" ria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h4 class="modal-title" id="addgalleryHeader"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <form method="POST" action="{{ route('admin.gallery.add') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="alt_text">Image Name/ Short Description</label>
                                        <input type="text" id="alt_text" name="alt_text" class="form-control" value="">
                                        @if ($errors->has('alt_text'))
                                        <span class="text-danger">{{ $errors->first('alt_text') }}</span>
                                        @endif
                                    </div>
                                </div>
                               
                             
                               
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="event">Event</label>
                                        <select class="form-control" id="event" name="event"
                                            style="width: 100%;" required>
                                            <option>... SelectEvent ...</option>
                                            <option value="marathon">Marathon</option>
                                            <option value="awards">Awards</option>
                                            <option value="expo">Exhibition</option>
                                        </select>
                                        @if ($errors->has('event'))
                                        <span class="text-danger">{{ $errors->first('event') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="image">gallery Image</label>
                                        <input type="file" id="image" name="image" class="form-control">
                                        @if ($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">

                                </div>
                                <div class="col-6">

                                </div>
                            </div>





                        </div>
                        <!-- /.card-body -->
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="submit" name="award-gallery" value=""
                                class="btn btn-outline-light btn-save">Save changes</button>
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
