@extends("admin.layout.app")
@section("title",'Roles Page')
@section("pagename",'Roles')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">

 <!-- Google Font: Source Sans Pro -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
@endsection
@section('script')
<!-- jQuery -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
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
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- Page specific script -->

<script>
  $(document).ready(function () {
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /*  When user click add role button */
    $('#create-new-role').click(function () {
        $('#btn-save').val("create-role");
        document.getElementById('rolesForm').reset();
        $('#roleCrudModal').html("Add New Role");
        $('#ajax-crud-modal').modal('show');
    });

    //Edit User
        $('body').on('click', '#edit-role', function () {
          var role_id = $(this).data('id');
          $.get('/admin/account/role/' + role_id +'/edit',
            function (data) {
                $('#roleCrudModal').empty();
                $('#btn-save').val("edit-role");
                $('#ajax-crud-modal').modal('show');
                $.each(data.roles, function(key,role) {
                    $('#roleCrudModal').html('Edit Role'+' '+role.name);
                    $('#role_id').val(role.id);
                    $('#name').val(role.name);

            });
          })
        });
      


          
    //DataTable Values
        const date = new Date();
        const month = date.getMonth() + 1;
        const today= (month.toString().length > 1 ? month : "0" + month) + "_" + date.getDate() + "_" + date.getFullYear()+ "_" +date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();
        var table = $('#empTable').DataTable({
          
          ajax: {
            url: "{{ url('admin/account/roles')}}",          
            dataSrc: ''
          },
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
          pageLength: 10,
          responsive: true, "lengthChange": true, "autoWidth": false,
          dom:"<'ui grid'"+
              "<'row'"+
                  "<'left col-md-4'l>"+
                  "<'center col-md-4'B>"+
                  "<'right col-md-4'f>"+
              ">"+
              
              ">",
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
                title: 'Roles_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'excel',
                text:      '<i class="fa fa-files-o"></i> Excel',
                titleAttr: 'Excel',
                title: 'Roles_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'pdf',
                text:      '<i class="fa fa-file-pdf-o"></i> PDF',
                titleAttr: 'PDF',
                title: 'Roles_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },               
                {
                  extend:    'print',
                  text:      '<i class="fa fa-print"></i> Print',
                  titleAttr: 'Print',
                  title: 'Roles_lists_'+today,
                  className: 'btn btn-default btn-sm',
                  exportOptions: {
                      columns: ':not(:first,:last)'
                  }
                },  
            ],
          createdRow: function (row, data, dataIndex) {
                $(row).addClass('role_id_'+ data.id + '');
            },
            
          columns: [
                  { data: null  ,
                    render: function (data, row, full) {
                      return '<input type="checkbox" class="sub_chk" data-id="'+ data.id + '">';
                    },
                  },
                  { data: null,    
                  render: function (data, type, row, meta) {
                        return meta.row+1; // This contains the row index
                      } 
                  },
                  { data: 'name' },
                  {data: null,
                    render: function (data, row, full) {
                      var dataItem = JSON.stringify(data);
                       return '<a href="javascript:void(0)" id="edit-role" style="margin-right: 5px;" class="fa fa-edit " data-id="'+ data.id + '" data-toggle="tooltip" data-placement="top" title="Edit" ></a><a href="javascript:void(0)" id="delete-role" class=" delete-role fa fa-trash " data-id="'+ data.id + '" data-toggle="tooltip" data-placement="top" title="Delete"></a>';
                    },
                  }
          ],
          
        });
       
    //Save data into database  

        $(".btn-save").click(function(e){
              e.preventDefault();
              // var table = $('#empTable').DataTable();
              // table.ajax.reload();

              var _token = $("input[name='_token']").val();
              var name = $("input[id='name']").val();
              var role_id = $("input[name='role_id']").val();
              $.ajax({
                url: "{{ route('admin.role_store') }}",
                type:'POST',
                data: { 
                "_token": "{{ csrf_token() }}",
                role_id:role_id,
                name:name,
                },
                success: function(data) {
                  // window.location.href = data;
                  document.getElementById("rolesForm").reset();
                  $('#ajax-crud-modal').modal('hide');
                  $('#empTable').DataTable().ajax.reload()
                  
                  $(document).Toasts('create', {
                    class: 'bg-success',
                    title:data[1],
                  })
                  },
                  error: function(data, status, error){
                        $.each(data.responseJSON.errors, function (key, item){
                          $(document).Toasts('create', {
                                  class: 'bg-danger',
                                  title:item,
                          })
                        });
                      }
              });
        }); 

    //delete Single role 
        $('body').on('click', '.delete-role', function () {
            var role_id = $(this).data("id");
            $.ajax({
                type: "DELETE",
                url: "{{ url('admin/account/role')}}"+'/'+role_id,
                success: function (data) {
                    $(".role_id_" + role_id).remove();
                    $('#empTable').DataTable().ajax.reload()
                    $(document).Toasts('create', {
                      class: 'bg-danger',
                      title:data[1],
                    })
                    
                },
                error: function (data) { 
                      $(document).Toasts('create', {
                      class: 'bg-danger',
                      title: 'Error Occur',
                      body: 'Error:', data
                    })
                }
            });
        }); 
    
    //multiple delete-role
        $('#master').on('click', function(e) {
              if($(this).is(':checked',true))  
              {
                $(".sub_chk").prop('checked', true);  
              } else {  
                $(".sub_chk").prop('checked',false);  
              }  
        });
        $('.delete_all').on('click', function(e) {
            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  
            if(allVals.length <=0)  {  
                alert("Please select row.");  
            } 
            else {  
                var check = confirm("Are you sure you want to delete this row?");  
                if(check == true){  
                    var join_selected_values = allVals.join(","); 
                    $.ajax({
                        url: "{{ url('admin/account/role-delete-all')}}",
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                          $('#empTable').DataTable().ajax.reload()
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
                    $.each(allVals, function( index, value ) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });

                }  
            }  

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

            <div class="card">
              <div class="card-header">
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('myproductsDeleteAll') }}">Delete All Selected Role</button>
                <button type="button" class="btn btn-secondary bg-dark" id="create-new-role" data-toggle="modal" data-target="#add-role" style="float: right">
                  Add Role
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="empTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="20px"><input type="checkbox" id="master"></th>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Action(s)</th>
                  </tr>
                  </thead>

             
                </table>
              </div>
              <!-- /.card-body -->
            </div>
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
              <h4 class="modal-title" id="roleCrudModal"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
              <form id="rolesForm" class="rolesForm" name="rolesForm">
                @csrf
                <input type="hidden" name="role_id" id="role_id">
    
                <div class="card-body">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Role Name"  required autocomplete="name" autofocus>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user-check"></span>
                      </div>
                    </div>
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
              



                </div>
                <!-- /.card-body -->               
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
               
                  <button type="submit" name="role_data" value=""   class="btn btn-outline-light btn-save">Save changes</button>
               
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