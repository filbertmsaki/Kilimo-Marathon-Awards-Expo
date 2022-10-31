<x-admin.layout.app-layout>
    @section('title', 'User List')
    @section('pagename', 'User List')
    @section('css')
    @endsection
    @section('script')

        <script>
            $(document).ready(function() {
                /*  When user click add user button */
                $('body').on('click', '#add-new-user-btn', function() {
                    $('#add-new-user-form').trigger("reset");
                    $('#add-new-user-title').html("Add New runner");
                    $('#add-new-user-modal').modal('show');
                });
                /* When click edit user */

                $('body').on('click', '#edit-user-btn', function() {
                    var userData = $(this).data('id');
                    var formData = {};
                    var type = "GET";
                    var todo_id = jQuery('#todo_id').val();
                    var ajaxurl = '{{ route('admin.users.role.permision') }}';
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            if (isJSON(userData)) {
                                $('#role_checkbox').empty();
                                $('#permission_checkbox').empty();
                                $('#edit-user-title').empty();
                                $('#edit-user-modal').modal('show');
                                $('#edit-user-title').html('Edit User' + ' ' + userData.name);
                                $('#user_id').val(userData.id);
                                $('#first_name').val(userData.first_name);
                                $('#last_name').val(userData.last_name);
                                $('#mobile').val(userData.mobile);
                                $('#email').val(userData.email);
                                //Roles
                                var i = 1
                                $.each(data.roles, function(key, role) {
                                    var status_role = '';
                                    $.each(userData.roles, function(key, user_role) {
                                        if (user_role.pivot.role_id == role
                                            .id) {
                                            status_role = "checked";
                                        }
                                    });
                                    $('#role_checkbox').append(
                                        '<label style="margin-right:5px;" class="checkbox-inline"><input type="checkbox" id="role_id' +
                                        i + '" name="role_id[]" class="role_id" value="' +
                                        role.id + '" ' + status_role + ' > ' +
                                        role.name + '</label>');
                                    i++;
                                });

                                //permissions
                                $.each(data.permissions, function(key, permission) {
                                    var id_per = '';
                                    $.each(userData.permissions, function(key,
                                        user_permission) {
                                        if (user_permission.pivot.permission_id ==
                                            permission.id) {
                                            id_per = "checked";
                                        }
                                    });
                                    $('#permission_checkbox').append(
                                        '<label style="margin-right:5px;" class="checkbox-inline"><input type="checkbox" id="permission_id' +
                                        i +
                                        '" name="permission_id[]" class="permission_id" value="' +
                                        permission.id + '" ' + id_per + ' > ' +
                                        permission.name + '</label>');

                                    i++;
                                });
                            };
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                });
            });
        </script>
    @endsection
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <button style="margin-bottom: 10px" class="btn btn-primary delete_all"
                                data-url="{{ url('myproductsDeleteAll') }}">Delete All Selected User</button>
                            @can('add-users')
                                <button type="button" class="btn btn-secondary bg-dark" id="create-new-user"
                                    data-toggle="modal" data-target="#add-user" style="float: right">
                                    Add User
                                </button>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped" data-id="Users List">
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
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr id="award_category_id_{{ $user->id }}">
                                            <td><input type="checkbox" name="category_id[]" value="{{ $user->id }}"
                                                    id="sub_chk_{{ $user->id }}" class="sub_chk"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->mobile }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    {{ $role->name }}
                                                @endforeach
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                            <td class="">
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" id="edit-user-btn"
                                                        class="btn btn-primary btn-sm" data-id="{{ $user }}"
                                                        data-toggle="tooltip" data-placement="top" title="View"> <i
                                                            class="fa fa-eye "></i> View</a>
                                                    <a href="javascript:void(0)" id="delete-btn"
                                                        class="btn btn-danger btn-sm" data-id="{{ $user }}"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"> <i
                                                            class="fa fa-trash "></i> Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
        <div class="modal fade" id="edit-user-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-user-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form action="{{ route('admin.users.update', 'update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                id="first_name" name="first_name" placeholder="First Name"
                                                autocomplete="first_name" autofocus>
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
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                id="last_name" name="last_name" placeholder="Last Name"
                                                autocomplete="last_name" autofocus>
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
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="User Email"
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
                                        <input type="mobile"
                                            class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                                            name="mobile" placeholder="User Mobile" autocomplete="mobile" autofocus>
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
                                </div>

                                <div class="input-group mb-3" id="role_checkbox">
                                </div>
                                <div class="input-group mb-3" id="permission_checkbox">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input id="password" type="password" class="form-control" id="password"
                                            placeholder="Password" name="password" autocomplete="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input id="password_confirmation" type="password"
                                            placeholder="Confirm Password" id="password_confirmation"
                                            class="form-control" name="password_confirmation"
                                            autocomplete="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light"
                                    data-dismiss="modal">Close</button>
                                @can('edit-users')
                                    <button type="submit" class="btn btn-outline-light btn-save">Save changes</button>
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
</x-admin.layout.app-layout>
