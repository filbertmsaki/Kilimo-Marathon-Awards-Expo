<x-admin.layout.app-layout>
    @section('title', 'Marathon runner List')
    @section('pagename', 'Marathon runner List')
    @section('css')
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                /*  When user click add user button */
                $('body').on('click', '#create-new-runner-btn', function() {
                    $('#runnerForm').trigger("reset");
                    $('#new-runner-title').html("Add New runner");
                    $('#new-runner-modal').modal('show');
                });
                /* When click edit user */
                $('body').on('click', '.edit-runner-btn', function() {
                    var data = $(this).data('id');
                    if (isJSON(data)) {
                        $('#edit-runner-title').html("Edit Marathon runner");
                        $('#runner-edit-modal').modal('show');
                        $('#marathon_runner_id').val(data.id);
                        $('#full_name').val(data.full_name);
                        $('#phone').val(data.phone);
                        $('#email').val(data.email);
                        $('#region').val(data.region);
                        $('#phonecode').select2('destroy');
                        $('#phonecode').val(data.phonecode).select2();
                        $('#event').select2('destroy');
                        $('#event').val(data.event).select2();
                    };
                });
            });
        </script>
    @endsection

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
                                    formaction="{{ route('admin.marathon.destroy.all') }}">Delete Selected
                                    runner</button>
                                <button type="button" class="btn btn-secondary bg-dark" id="create-new-runner-btn"
                                    data-toggle="modal" data-target="#add-category" style="float: right">
                                    Add runner
                                </button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered table-striped" data-id="Marathon">
                                    <thead>
                                        <tr>
                                            <th width="20px"><input type="checkbox" id="master"></th>
                                            <th>S/N</th>
                                            <th>runner Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Distance</th>
                                            <th>Region</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($runners as $runner)
                                            <tr id="marathon_runner_id_{{ $runner->id }}">
                                                <td><input type="checkbox" name="runner_id[]"
                                                        value="{{ $runner->id }}" id="sub_chk_{{ $runner->id }}"
                                                        class="sub_chk"></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $runner->full_name }}</td>
                                                <td>{{ $runner->phone }}</td>
                                                <td>{{ $runner->email }}</td>
                                                <td>{{ $runner->event }} Km</td>
                                                <td>{{ $runner->region }}</td>
                                                <td class="">
                                                    <a href="javascript:void(0)" id="edit-runner-btn"
                                                        style="margin-right: 5px;" class="fa fa-edit edit-runner-btn"
                                                        data-id="{{ $runner }}" data-toggle="tooltip"
                                                        data-placement="top" title="Edit"></a>
                                                    <a href="{{ route('admin.marathon.destroy', 'delete') }}"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('runner_delete').submit();"
                                                        id="delete-runner" class=" delete-runner fa fa-trash "
                                                        data-toggle="tooltip" data-placement="top" title="Delete"></a>
                                                    <form class="d-none m-0 p-0" id="runner_delete"
                                                        action="{{ route('admin.marathon.destroy', 'delete') }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id"
                                                            value="{{ $runner->id }}">
                                                    </form>
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
        <div class="modal fade" id="runner-edit-modal" ria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-runner-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form method="POST" action="{{ route('admin.marathon.update', 'update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="marathon_runner_id" id="marathon_runner_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror"
                                                id="full_name" name="full_name" placeholder="Full Name" required
                                                autocomplete="full_name" autofocus>

                                            @error('full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" placeholder="Enter Email" required autocomplete="email"
                                                autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="phonecode" id="phonecode"
                                            style="width: 100%;" required>
                                            <option value="">-- Select Country--</option>
                                            <option value="254">Kenya</option>
                                            <option value="255">Tanzania</option>
                                            <option value="256">Uganda</option>
                                        </select>
                                        @if ($errors->has('phonecode'))
                                            <span class="text-danger">{{ $errors->first('phonecode') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="tel"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" placeholder="Eg: 0*********" required
                                                autocomplete="phone" autofocus>

                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control  @error('region') is-invalid @enderror"
                                                id="region" name="region" placeholder="Region Name" required
                                                autocomplete="region" autofocus>

                                            @error('region')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="event" id="event"
                                            style="width: 100%;" required>
                                            <option value="">-- Select Event--</option>
                                            <option value="21">21 Km</option>
                                            <option value="10">10 Km</option>
                                            <option value="5">5 Km</option>
                                        </select>
                                        @if ($errors->has('event'))
                                            <span class="text-danger">{{ $errors->first('event') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-light btn-save">Save
                                    changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="new-runner-modal" ria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="new-runner-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form method="POST" action="{{ route('admin.marathon.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror"
                                                id="full_name" name="full_name" placeholder="Full Name" required
                                                autocomplete="full_name" autofocus value="{{ old('full_name') }}">

                                            @error('full_name')
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
                                                id="email" name="email" placeholder="Enter Email" required
                                                autocomplete="email" autofocus value="{{ old('email') }}">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="phonecode" style="width: 100%;"
                                            required>
                                            <option value="">-- Select Country--</option>
                                            <option value="254">Kenya</option>
                                            <option value="255">Tanzania</option>
                                            <option value="256">Uganda</option>
                                        </select>
                                        @if ($errors->has('phonecode'))
                                            <span class="text-danger">{{ $errors->first('phonecode') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="tel"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" placeholder="Eg: 0*********" required
                                                autocomplete="phone" autofocus value="{{ old('phone') }}">

                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('region') is-invalid @enderror"
                                                id="region" name="region" placeholder="Region Name" required
                                                autocomplete="region" autofocus value="{{ old('region') }}">

                                            @error('region')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="event" style="width: 100%;">
                                            <option value="distance">-- Select Event--</option>
                                            <option value="21">21 Km</option>
                                            <option value="10">10 Km</option>
                                            <option value="5">5 Km</option>
                                        </select>
                                        @if ($errors->has('event'))
                                            <span class="text-danger">{{ $errors->first('event') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-light btn-save">Save
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
</x-admin.layout.app-layout>
