@extends("admin.layout.app")
@section("title",'Award category List')
@section("pagename",'Award category List')
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
<script>
  $(function () {
     
        const date = new Date();
        const month = date.getMonth() + 1;
        const today= (month.toString().length > 1 ? month : "0" + month) + "_" + date.getDate() + "_" + date.getFullYear()+ "_" +date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();
        
        var table = $('#award_category').DataTable({
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
          pageLength: 10,
          responsive: true, "lengthChange": true, "autoWidth": false,
          processing: true,
          dom:"<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          buttons: [
                {
                extend:    'copy',
                text:      '<i class="fa fa-files-o"></i> Copy',
                titleAttr: 'Copy',
                className: 'btn btn-default btn-sm'
                },
                {
                extend:    'csv',
                text:      '<i class="fa fa-files-o"></i> CSV',
                titleAttr: 'CSV',
                title: 'categories_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'excel',
                text:      '<i class="fa fa-files-o"></i> Excel',
                titleAttr: 'Excel',
                title: 'categories_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'pdf',
                text:      '<i class="fa fa-file-pdf-o"></i> PDF',
                titleAttr: 'PDF',
                title: 'categories_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },               
                {
                  extend:    'print',
                  text:      '<i class="fa fa-print"></i> Print',
                  titleAttr: 'Print',
                  title: 'categories_lists_'+today,
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
    /*  When category click add category button */
    $('#create-new-category').click(function () {
        $('#btn-save').val("create-category");
        document.getElementById('addform').reset();
        $('#addcategoryCrudModal').html("Add New Category");
        $('#add-crud-modal').modal('show');
    });

    //Edit category
        $('body').on('click', '#edit-category', function () {
          var award_category_id = $(this).data('id');
          $.get('/admin/awards/category/' + award_category_id +'/edit',
            function (data) {
                $('#role_checkbox').empty();
                $('#permission_checkbox').empty();
                $('#categoryCrudModal').empty();
                $('#btn-save').val("edit-category");
                $('#ajax-crud-modal').modal('show');
                $('#categoryCrudModal').html('Edit Award Category');
                $('#award_category_id').val(data.id);
                $('.name').val(data.name);
                $('.name_in_swahili').val(data.name_in_swahili);
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
                formaction="{{ route('admin.award_category_destroy_all') }}">Delete Selected category</button>

              {{-- <button type="button" class="btn btn-secondary bg-dark create-new-category" id="create-new-category"
                data-toggle="modal" data-target="#add-category" style="float: right">
                Add category
              </button> --}}
              <button type="button" class="btn btn-secondary bg-dark create-new-category"
              onclick="window.location.href='{{ route('admin.award_category_add_index') }}'" style="float: right">
              Add category
            </button>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="award_category" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="20px"><input type="checkbox" id="master"></th>
                    <th>S/N</th>
                    <th>Category Name</th>
                    <th>Total Nominees Per Category</th>
                    <th>Total Vote Per Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($award_category as $category )

                  
                  <tr id="award_category_id_{{ $category->id }}">
                    <td><input type="checkbox" name="category_id[]" value="{{ $category->id }}"
                        id="sub_chk_{{ $category->id }}" class="sub_chk"></td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ count($category->current_year_nominee) }}</td>
                    <td>{{$category->current_year_nominee->sum('vote') }}</td>
                    <td class="">
                      {{-- <a href="javascript:void(0)" id="edit-category" style="margin-right: 5px;" class="fa fa-edit "
                        data-id="{{ $category->id }}" data-toggle="tooltip" data-placement="top" title="Edit"></a> --}}
                        <a href="{{ route('admin.award_category_edit',$category->slug) }}"  style="margin-right: 5px;" class="fa fa-edit "
                        data-id="{{ $category->id }}" data-toggle="tooltip" data-placement="top" title="Edit"></a>
                      <a href="{{ route('admin.award_category_destroy',$category->id) }}" id="delete-category"
                        class=" delete-category fa fa-trash " data-toggle="tooltip" data-placement="top"
                        title="Delete"></a>
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

  <div class="modal fade" id="add-crud-modal" ria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark">
        <div class="modal-header">
          <h4 class="modal-title" id="addcategoryCrudModal"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
          </div>
          <form method="POST" action="{{ route('admin.award_category_add') }}">
            @csrf
            <div class="card-body">

              <div class="form-group ">
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    placeholder="Award Category Name In English" required autocomplete="name" autofocus>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-award"></span>
                    </div>
                  </div>
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group ">
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('name_in_swahili') is-invalid @enderror"
                    name="name_in_swahili" placeholder="Award Category Name In Swahili" autocomplete="name_in_swahili"
                    autofocus>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-award"></span>
                    </div>
                  </div>
                  @error('name_in_swahili')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>

              <button type="submit" name="add_category_data" value="" class="btn btn-outline-light btn-add">Save
                changes</button>

            </div>
          </form>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="ajax-crud-modal" ria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark">
        <div class="modal-header">
          <h4 class="modal-title" id="categoryCrudModal"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
          </div>
          <form id="addform" method="POST" action="{{ route('admin.award_category_store') }}">
            @csrf
            <input type="hidden" name="award_category_id" id="award_category_id">

            <div class="card-body">

              <div class="form-group ">
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('name') is-invalid @enderror name" id="name" name="name"
                    placeholder="Award Category Name" required autocomplete="name" autofocus>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-award"></span>
                    </div>
                  </div>
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group ">
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('name_in_swahili') is-invalid @enderror name_in_swahili"
                    id="name_in_swahili" name="name_in_swahili" placeholder="Award Category Name In Swahili"
                    autocomplete="name_in_swahili" autofocus>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-award"></span>
                    </div>
                  </div>
                  @error('name_in_swahili')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>

              <button type="submit" name="category_data" value="" class="btn btn-outline-light btn-save">Save
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