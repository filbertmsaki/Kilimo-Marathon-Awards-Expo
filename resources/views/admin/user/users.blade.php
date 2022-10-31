@extends("admin.layout.app")
@section("title",'Users Page')
@section("pagename",'Users')
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
    /*  When user click add user button */
    $('#create-new-user').click(function () {
        $('#btn-save').val("create-user");
        document.getElementById('usersForm').reset();
        // $('#userCrudModal').html("Add New User");
        $('#role_checkbox').empty();
        $('#permission_checkbox').empty();
        $.get("{{ url('admin/account/roles-permissions')}}",
            function (data) {
              //Get All roles
                $.each(data.roles, function(key,role) {
                  $('#role_checkbox').append('<label style="margin-right:5px;" class="checkbox-inline"><input type="checkbox" id="role_id" name="role_id" class="role_id" value="'+role.id+'" > '+role.name+'</label>');
                });
              //Get All Permisions
              $.each(data.permissions, function(key,permission) {
                $('#permission_checkbox').append('<label style="margin-right:5px;" class="checkbox-inline"><input type="checkbox" id="permission_id" name="permission_id" class="permission_id" value="'+permission.id+'"  > '+permission.name+'</label>');
                });

        });
        $('#ajax-crud-modal').modal('show');
    });

    //Edit User
        $('body').on('click', '#edit-user', function () {
          var user_id = $(this).data('id');
          $.get('/admin/account/users/' + user_id +'/edit',
            function (data) {
                $('#role_checkbox').empty();
                $('#permission_checkbox').empty();
                $('#userCrudModal').empty();
                $('#btn-save').val("edit-user");
                $('#ajax-crud-modal').modal('show');
                $.each(data.users, function(key,user) {
                    $('#userCrudModal').html('Edit User'+' '+user.name);
                    $('#user_id').val(user.id);
                    $('#first_name').val(user.first_name);
                    $('#last_name').val(user.last_name);
                    $('#mobile').val(user.mobile);
                    $('#email').val(user.email);
                    //Roles
                      $.each(data.roles, function(key,user_role) {
                              var status_role ='';
                              $.each(user.roles, function(key,user_rol) {
                                if(user_rol.pivot.role_id == user_role.id){
                                  status_role =  "checked";
                                }
                              });
                              $('#role_checkbox').append('<label style="margin-right:5px;" class="checkbox-inline"><input type="checkbox" id="role_id" name="role_id" class="role_id" value="'+user_role.id+'" '+status_role+' > '+user_role.name+'</label>');
                      });
                    //permissions
                      $.each(data.permissions, function(key,user_permission) {
                          var id_per ='';
                          $.each(user.permissions, function(key,user_per) {
                            if(user_per.pivot.permission_id == user_permission.id){
                              id_per =  "checked";
                            }
                          });
                          $('#permission_checkbox').append('<label style="margin-right:5px;" class="checkbox-inline"><input type="checkbox" id="permission_id" name="permission_id" class="permission_id" value="'+user_permission.id+'" '+id_per+' > '+user_permission.name+'</label>');
                      });
            });
          })
        });




    //DataTable Values
    
        const date = new Date();
        const month = date.getMonth() + 1;
        const today= (month.toString().length > 1 ? month : "0" + month) + "_" + date.getDate() + "_" + date.getFullYear()+ "_" +date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();
        var table = $('#empTable').DataTable({

          ajax: {
            url: "{{ url('admin/account/user')}}",
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
                title: 'Users_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'excel',
                text:      '<i class="fa fa-files-o"></i> Excel',
                titleAttr: 'Excel',
                title: 'Users_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'pdf',
                text:      '<i class="fa fa-file-pdf-o"></i> PDF',
                titleAttr: 'PDF',
                title: 'Users_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                  extend:    'print',
                  text:      '<i class="fa fa-print"></i> Print',
                  titleAttr: 'Print',
                  title: 'Users_lists_'+today,
                  className: 'btn btn-default btn-sm',
                  exportOptions: {
                      columns: ':not(:first,:last)'
                  }
                },
            ],
          createdRow: function (row, data, dataIndex) {
                $(row).addClass('user_id_'+ data.id + '');
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
                  { data: null,
                    render: function (data) {
                        var fullname = '';
                            fullname = data.first_name+' '+data.last_name ;
                        return fullname;
                    }
                  },
                  { data: 'name' },
                  { data: 'mobile' },
                  { data: 'email' },
                  { data: null,
                    render: function (data) {
                        var role ='';
                        $.each(data.roles, function(key,rol) {
                          role = rol;
                      });
                        return role.name;
                    }
                  },
                  { data: 'created_at',
                    render: function (data) {
                        var date = new Date(data);
                        var month = date.getMonth() + 1;
                        return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear();
                    }
                  },
                  {data: null,
                    render: function (data, row, full) {
                      var dataItem = JSON.stringify(data);
                       return '@can('edit-users')<a href="javascript:void(0)" id="edit-user" style="margin-right: 5px;" class="fa fa-edit " data-id="'+ data.id + '" data-toggle="tooltip" data-placement="top" title="Edit" ></a>@endcan @can('delete-users')<a href="javascript:void(0)" id="delete-user" class=" delete-user fa fa-trash " data-id="'+ data.id + '" data-toggle="tooltip" data-placement="top" title="Delete"></a>@endcan';
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
              var user_id = $("input[id='user_id']").val();
              var first_name = $("input[id='first_name']").val();
              var last_name = $("input[id='last_name']").val();
              var mobile = $("input[id='mobile']").val();
              var email = $("input[id='email']").val();
              var role_id = $("input[name='role_id']:checked").val();
              // var permission_id = $("input[name='permission_id[]']:checked").val();
              var password = $("input[id='password']").val();
              var password_confirmation = $("input[id='password_confirmation']").val();

              var permission_id = [];
              $('.permission_id').each(function() {
                  if ($(this).is(":checked")) {
                      permission_id.push($(this).val());
                  }
              });
              permission_id = permission_id;

              $.ajax({
                url: "{{ route('admin.user_store') }}",
                type:'POST',
                data: {
                "_token": "{{ csrf_token() }}",
                user_id:user_id,
                first_name:first_name,
                last_name:last_name,
                mobile:mobile,
                email:email,
                role_id:role_id,
                permission_id:permission_id,
                password:password,
                password_confirmation:password_confirmation
                },
                success: function(data) {
                  // window.location.href = data;
                  document.getElementById("usersForm").reset();
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

    //delete Single User
        $('body').on('click', '.delete-user', function () {
            var user_id = $(this).data("id");
            $.ajax({
                type: "DELETE",
                url: "{{ url('admin/account/users')}}"+'/'+user_id,
                success: function (data) {
                    $(".user_id_" + user_id).remove();
                    $('#empTable').DataTable().ajax.reload()
                    $(document).Toasts('create', {
                      class: 'bg-success',
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

    //multiple delete-user
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
                        url: "{{ url('admin/account/users-delete-all')}}",
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
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('myproductsDeleteAll') }}">Delete All Selected User</button>
                @can('add-users')
                <button type="button" class="btn btn-secondary bg-dark" id="create-new-user" data-toggle="modal" data-target="#add-user" style="float: right">
                  Add User
                </button>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="empTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="20px"><input type="checkbox" id="master"></th>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Since</th>
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
              <h4 class="modal-title" id="userCrudModal"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
              <form id="usersForm" class="usersForm" name="usersForm">
                @csrf
                <input type="hidden" name="user_id" id="user_id">

                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="First Name"  required autocomplete="first_name" autofocus>
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-user"></span>
                          </div>
                        </div>
                        @error('first_name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last Name"  required autocomplete="last_name" autofocus>
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-user"></span>
                          </div>
                        </div>
                        @error('last_name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>add
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="User Email"  required autocomplete="email" autofocus>
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
                  <div class="input-group mb-3">
                    <input type="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" placeholder="User Mobile"  required autocomplete="mobile" autofocus>
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
                  <div class="input-group mb-3" id="role_checkbox">
                  </div>
                  <div class="input-group mb-3" id="permission_checkbox">
                  </div>

                  <div class="row">
                    <div class="form-group col-md-6">
                      <input id="password" type="password" class="form-control" id="password" placeholder="Password" name="password" autocomplete="password" required>
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6">
                      <input id="password_confirmation" type="password" placeholder="Confirm Password" id="password_confirmation" class="form-control" name="password_confirmation" autocomplete="password_confirmation">

                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                @can('edit-users')
                  <button type="submit" name="user_data" value=""   class="btn btn-outline-light btn-save">Save changes</button>
                @endcan
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
