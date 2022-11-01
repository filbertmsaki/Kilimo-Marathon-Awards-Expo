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
                        $('#ed_first_name').val(data.first_name);
                        $('#ed_last_name').val(data.last_name);
                        $('#ed_gender').select2('destroy');
                        $('#ed_gender').val(data.gender).select2();
                        $('#ed_age').val(data.age);
                        $('#ed_phonecode').select2('destroy');
                        $('#ed_phonecode').val(data.phonecode).select2();
                        $('#ed_phone').val(data.phone);
                        $('#ed_email').val(data.email);
                        $('#ed_event').select2('destroy');
                        $('#ed_event').val(data.event).select2();
                        $('#ed_t_shirt_size').select2('destroy');
                        $('#ed_t_shirt_size').val(data.t_shirt_size).select2();
                        $('#ed_address').val(data.address);

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

                    <div class="card">
                        <div class="card-header">

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
                                        <th>Runner Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Phone Number</th>
                                        <th>Email Address</th>
                                        <th>Distance</th>
                                        <th>T Shirt Size</th>
                                        <th>Region</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($runners as $runner)
                                        <tr id="marathon_runner_id_{{ $runner->id }}">
                                            <td><input type="checkbox" name="runner_id[]" value="{{ $runner->id }}"
                                                    id="sub_chk_{{ $runner->id }}" class="sub_chk"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $runner->name }}</td>
                                            <td>
                                                @if ($runner->gender == 'M')
                                                    <span class="right badge badge-success">Male</span>
                                                @elseif ($runner->gender == 'F')
                                                    <span class="right badge badge-info">Femele</span>
                                                @else
                                                    <span class="right badge badge-warning">Other</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($runner->age)
                                                    <span class="right badge badge-light ">{{ $runner->age }}</span>
                                                @else
                                                    <span class="right badge badge-light ">Not Specified </span>
                                                @endif
                                            </td>
                                            <td>{{ $runner->phone }}</td>
                                            <td>{{ $runner->email }}</td>
                                            <td>
                                                @if ($runner->event == '5')
                                                    <span class="right badge badge-light ">5 KM</span>
                                                @elseif ($runner->event == '10')
                                                    <span class="right badge badge-success">10 KM</span>
                                                @elseif ($runner->event == '21')
                                                    <span class="right badge badge-danger">21 KM</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($runner->t_shirt_size == 'S')
                                                    <span class="badge badge-light ">Small</span>
                                                @elseif ($runner->t_shirt_size == 'M')
                                                    <span class="badge badge-success">Medium</span>
                                                @elseif ($runner->t_shirt_size == 'L')
                                                    <span class="badge badge-info">Large</span>
                                                @elseif ($runner->t_shirt_size == 'XL')
                                                    <span class="badge badge-warning">Extra Large</span>
                                                @elseif ($runner->t_shirt_size == 'XXL')
                                                    <span class="badge badge-danger">Double Extra Large</span>
                                                @else
                                                    <span class="badge badge-secondary">No Size</span>
                                                @endif
                                            </td>
                                            <td>{{ $runner->address }}</td>
                                            <td class="">
                                                <a href="javascript:void(0)" id="edit-runner-btn"
                                                    style="margin-right: 5px;" class="fa fa-edit edit-runner-btn"
                                                    data-id="{{ $runner }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"></a>
                                                <a href="{{ route('admin.marathon.destroy', 'delete') }}"
                                                    onclick="event.preventDefault();
                                                        document.getElementById('runner_delete{{ $loop->iteration }}').submit();"
                                                    id="delete-runner{{ $loop->iteration }}"
                                                    class=" delete-runner fa fa-trash " data-toggle="tooltip"
                                                    data-placement="top" title="Delete"></a>
                                                <form class="d-none m-0 p-0" id="runner_delete{{ $loop->iteration }}"
                                                    action="{{ route('admin.marathon.destroy', 'delete') }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $runner->id }}">
                                                </form>
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

        <div class="modal fade" id="new-runner-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
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
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            id="first_name" name="first_name" placeholder="First Name" required
                                            autocomplete="first_name" autofocus value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                            name="last_name" placeholder="Last Name" required autocomplete="last_name"
                                            autofocus value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2 entry" id="gender" name="gender"
                                            style="width: 100%;" required>
                                            <option value="">-- Select Gender--</option>
                                            <option value="F" @if (old('gender') == 'F') selected @endif>
                                                Female
                                            </option>
                                            <option value="M" @if (old('gender') == 'M') selected @endif>
                                                Male
                                            </option>
                                        </select>
                                        @if ($errors->has('entry'))
                                            <span class="text-danger">{{ $errors->first('entry') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="number" class="form-control @error('age') is-invalid @enderror"
                                            id="age" name="age" placeholder="Enter Age" required
                                            autocomplete="age" autofocus value="{{ old('age') }}">
                                        @error('age')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="phonecode" name="phonecode"
                                            id="phonecode" style="width: 100%;" required>
                                            <option value="">-- Select Country--</option>
                                            <option value="254" @if (old('phonecode') == '254') selected @endif>
                                                Kenya</option>
                                            <option value="255" @if (old('phonecode') == '255') selected @endif>
                                                Tanzania</option>
                                            <option value="256" @if (old('phonecode') == '256') selected @endif>
                                                Uganda</option>
                                        </select>
                                        @if ($errors->has('phonecode'))
                                            <span class="text-danger">{{ $errors->first('phonecode') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="tel"
                                            class="form-control @error('phone') is-invalid @enderror" id="phone"
                                            name="phone" placeholder="Eg: 0*********" required autocomplete="phone"
                                            autofocus value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            name="email" placeholder="Enter Email" required autocomplete="email"
                                            autofocus value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="event" style="width: 100%;">
                                            <option value="">-- Select Event --</option>
                                            <option value="5" @if (old('event') == '5') selected @endif>
                                                5 Km
                                            </option>
                                            <option value="10" @if (old('event') == '10') selected @endif>
                                                10 Km
                                            </option>
                                            <option value="21" @if (old('event') == '21') selected @endif>
                                                21 Km
                                            </option>
                                        </select>
                                        @if ($errors->has('event'))
                                            <span class="text-danger">{{ $errors->first('event') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="t_shirt_size"
                                            style="width: 100%;">
                                            <option value="">-- T-Shirt Size --</option>
                                            <option value="S" @if (old('t_shirt_size') == 'S') selected @endif>
                                                S Size
                                            </option>
                                            <option value="M" @if (old('t_shirt_size') == 'M') selected @endif>
                                                M Size
                                            </option>
                                            <option value="L" @if (old('t_shirt_size') == 'L') selected @endif>
                                                L Size
                                            </option>
                                            <option value="XL" @if (old('t_shirt_size') == 'XL') selected @endif>
                                                XL Size
                                            </option>
                                            <option value="XXL" @if (old('t_shirt_size') == 'XXL') selected @endif>
                                                XXL Size
                                            </option>
                                        </select>
                                        @if ($errors->has('t_shirt_size'))
                                            <span class="text-danger">{{ $errors->first('t_shirt_size') }}</span>
                                        @endif
                                    </div>

                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address" placeholder="Address Location" required
                                            autocomplete="address" autofocus value="{{ old('address') }}">
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
        <div class="modal fade" id="runner-edit-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
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
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            id="ed_first_name" name="first_name" placeholder="First Name" required
                                            autocomplete="first_name" autofocus value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            id="ed_last_name" name="last_name" placeholder="Last Name" required
                                            autocomplete="last_name" autofocus value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2 entry" id="ed_gender" name="gender"
                                            style="width: 100%;" required>
                                            <option value="">-- Select Gender--</option>
                                            <option value="F" @if (old('gender') == 'F') selected @endif>
                                                Female
                                            </option>
                                            <option value="M" @if (old('gender') == 'M') selected @endif>
                                                Male
                                            </option>
                                        </select>
                                        @if ($errors->has('entry'))
                                            <span class="text-danger">{{ $errors->first('entry') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="number" class="form-control @error('age') is-invalid @enderror"
                                            id="ed_age" name="age" placeholder="Enter Age" required
                                            autocomplete="age" autofocus value="{{ old('age') }}">
                                        @error('age')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="ed_phonecode" name="phonecode"
                                            style="width: 100%;">
                                            <option value="">-- Select Country--</option>
                                            <option value="254" @if (old('phonecode') == '254') selected @endif>
                                                Kenya</option>
                                            <option value="255" @if (old('phonecode') == '255') selected @endif>
                                                Tanzania</option>
                                            <option value="256" @if (old('phonecode') == '256') selected @endif>
                                                Uganda</option>
                                        </select>
                                        @if ($errors->has('phonecode'))
                                            <span class="text-danger">{{ $errors->first('phonecode') }}</span>
                                        @endif
                                    </div>

                                    <div class="input-group col-md-6 mb-3">
                                        <input type="tel"
                                            class="form-control @error('phone') is-invalid @enderror" id="ed_phone"
                                            name="phone" placeholder="Eg: 0*********" required autocomplete="phone"
                                            autofocus value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror" id="ed_email"
                                            name="email" placeholder="Enter Email" required autocomplete="email"
                                            autofocus value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="ed_event" name="event"
                                            style="width: 100%;">
                                            <option value="">-- Select Event --</option>
                                            <option value="5" @if (old('event') == '5') selected @endif>
                                                5 Km
                                            </option>
                                            <option value="10" @if (old('event') == '10') selected @endif>
                                                10 Km
                                            </option>
                                            <option value="21" @if (old('event') == '21') selected @endif>
                                                21 Km
                                            </option>
                                        </select>
                                        @if ($errors->has('event'))
                                            <span class="text-danger">{{ $errors->first('event') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="ed_t_shirt_size" name="t_shirt_size"
                                            style="width: 100%;">
                                            <option value="">-- T-Shirt Size --</option>
                                            <option value="S" @if (old('t_shirt_size') == 'S') selected @endif>
                                                S Size
                                            </option>
                                            <option value="M" @if (old('t_shirt_size') == 'M') selected @endif>
                                                M Size
                                            </option>
                                            <option value="L" @if (old('t_shirt_size') == 'L') selected @endif>
                                                L Size
                                            </option>
                                            <option value="XL" @if (old('t_shirt_size') == 'XL') selected @endif>
                                                XL Size
                                            </option>
                                            <option value="XXL" @if (old('t_shirt_size') == 'XXL') selected @endif>
                                                XXL Size
                                            </option>
                                        </select>
                                        @if ($errors->has('t_shirt_size'))
                                            <span class="text-danger">{{ $errors->first('t_shirt_size') }}</span>
                                        @endif
                                    </div>

                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('address') is-invalid @enderror"
                                            id="ed_address" name="address" placeholder="Address Location" required
                                            autocomplete="address" autofocus value="{{ old('address') }}">
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
