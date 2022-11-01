<x-admin.layout.app-layout>
    @section('title', 'Marathon Expo List')
    @section('pagename', 'Marathon Expo List')
    @section('css')
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                /*  When user click add user button */
                $('body').on('click', '#create-new-expo-btn', function() {
                    $('#expoForm').trigger("reset");
                    $('#new-expo-title').html("Add New Expo");
                    $('#new-expo-modal').modal('show');
                });
                /* When click edit user */
                $('body').on('click', '.edit-expo-btn', function() {
                    var data = $(this).data('id');
                    if (isJSON(data)) {
                        $('#edit-expo-title').html("Edit Expo");
                        $('#expo-edit-modal').modal('show');
                        $('#ed_expo_id').val(data.id);
                        $('#ed_entry').select2('destroy');
                        $('#ed_entry').val(data.entry).select2();
                        $('#ed_phonecode').select2('destroy');
                        $('#ed_phonecode').val(data.phonecode).select2();
                        $('#ed_company_name').val(data.company_name);
                        $('#ed_service_name').val(data.service_name);
                        $('#ed_company_phone').val(data.company_phone);
                        $('#ed_company_email').val(data.company_email);
                        $('#ed_contact_person_name').val(data.contact_person_name);
                        $('#ed_contact_person_phone').val(data.contact_person_phone);
                        $('#ed_contact_person_email').val(data.contact_person_email);
                        $('#ed_address').val(data.address);
                        $('#ed_company_details').val(data.company_details);
                        var entry = $('#ed_entry').val();
                        if (entry == '1') {
                            $('.company_phoneDiv').hide();
                            $('.company_emailDiv').hide();
                            $('.company_name').attr('placeholder', 'Enter Service/ Business Name')
                            $('.company_phone').prop('required', false);
                            $('.company_email').prop('required', false);

                        } else {
                            $('.company_phoneDiv').show();
                            $('.company_emailDiv').show();
                            $('.company_name').attr('placeholder', 'Enter Company Name')
                            $('.company_phone').prop('required', false);
                            $('.company_email').prop('required', false);

                        }
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

                            <button type="button" class="btn btn-secondary bg-dark" id="create-new-expo-btn"
                                data-toggle="modal" data-target="#add-category" style="float: right">
                                Add Expo
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped" data-id="Expo">
                                <thead>
                                    <tr>
                                        <th width="20px"><input type="checkbox" id="master"></th>
                                        <th>S/N</th>
                                        <th>Company Name</th>
                                        <th>Service/ Business Name</th>
                                        <th>Contact Person</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Businness Deals</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expoModels as $expo)
                                        <tr id="expo_tr_id_{{ $expo->id }}">
                                            <td><input type="checkbox" name="expo_id[]" value="{{ $expo->id }}"
                                                    id="sub_chk_{{ $expo->id }}" class="sub_chk"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $expo->company_name }}</td>
                                            <td>{{ $expo->service_name }}</td>
                                            <td>{{ $expo->contact_person_name }}</td>
                                            <td>{{ $expo->contact_person_phone }}</td>
                                            <td>{{ $expo->contact_person_email }}</td>
                                            <td>{{ $expo->company_details }}</td>
                                            <td class="">
                                                <a href="javascript:void(0)" id="edit-expo-btn"
                                                    style="margin-right: 5px;" class="fa fa-edit edit-expo-btn"
                                                    data-id="{{ $expo }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"></a>
                                                <a href="{{ route('admin.expo.destroy', 'delete') }}"
                                                    onclick="event.preventDefault();
                                                        document.getElementById('expo_delete{{ $loop->iteration }}').submit();"
                                                    id="" class=" fa fa-trash " data-toggle="tooltip"
                                                    data-placement="top" title="Delete"></a>
                                                <form class="d-none m-0 p-0" id="expo_delete{{ $loop->iteration }}"
                                                    action="{{ route('admin.expo.destroy', 'delete') }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $expo->id }}">
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
        <div class="modal fade" id="expo-edit-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-expo-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form method="POST" action="{{ route('admin.expo.update', 'update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="expo_id" id="ed_expo_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2 entry" id="ed_entry" name="entry"
                                            style="width: 100%;" required>
                                            <option value="">-- Award Entry--</option>
                                            <option value="1" @if (old('entry') == '1') selected @endif>
                                                Individual
                                            </option>
                                            <option value="2" @if (old('entry') == '2') selected @endif>
                                                Company
                                            </option>
                                        </select>
                                        @if ($errors->has('entry'))
                                            <span class="text-danger">{{ $errors->first('entry') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="ed_phonecode" name="phonecode"
                                            style="width: 100%;" required>
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
                                    <div class="input-group mb-3 col-md-6 company_nameDiv">
                                        <input type="text"
                                            class="form-control @error('company_name') is-invalid @enderror"
                                            id="ed_company_name" name="company_name"
                                            placeholder="Company/ Business Name" required autocomplete="company_name"
                                            value="{{ old('company_name') }}" autofocus>
                                        @error('company_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <input type="text"
                                            class="form-control @error('service_name') is-invalid @enderror"
                                            id="ed_service_name" name="service_name"
                                            placeholder="Business / Service you provide" required
                                            autocomplete="service_name" value="{{ old('service_name') }}" autofocus>
                                        @error('service_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6 company_phoneDiv" id=""
                                        style="display: none">
                                        <input type="tel"
                                            class="form-control @error('company_phone') is-invalid @enderror"
                                            id="ed_company_phone" name="company_phone" placeholder="Company Phone"
                                            value="{{ old('company_phone') }}" autocomplete="company_phone"
                                            autofocus>
                                        @error('company_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6 company_emailDiv" style="display: none">
                                        <input type="email"
                                            class="form-control @error('company_email') is-invalid @enderror"
                                            id="ed_company_email" name="company_email" placeholder="Company Email"
                                            value="{{ old('company_email') }}" autocomplete="company_email"
                                            autofocus>
                                        @error('company_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('contact_person_name') is-invalid @enderror"
                                            id="ed_contact_person_name" name="contact_person_name"
                                            placeholder="Contact Person Name" autocomplete="contact_person_name"
                                            value="{{ old('contact_person_name') }}" autofocus>
                                        @error('contact_person_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="tel"
                                            class="form-control @error('contact_person_phone') is-invalid @enderror"
                                            id="ed_contact_person_phone" name="contact_person_phone"
                                            placeholder="Contact Person Phone" autocomplete="contact_person_phone"
                                            value="{{ old('contact_person_phone') }}" autofocus>
                                        @error('contact_person_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="email"
                                            class="form-control @error('contact_person_email') is-invalid @enderror"
                                            id="ed_contact_person_email" name="contact_person_email"
                                            placeholder="Contact Person email" autocomplete="contact_person_email"
                                            value="{{ old('contact_person_email') }}" autofocus>
                                        @error('contact_person_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('address') is-invalid @enderror"
                                            id="ed_address" name="address" placeholder="Address Location"
                                            autocomplete="address" value="{{ old('address') }}" autofocus>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-12 mb-3">
                                        <textarea name="company_details" id="ed_company_details" value="{{ old('company_details') }}" rows="5"
                                            class="form-control @error('company_details') is-invalid @enderror"
                                            placeholder="Short description about your company, business or service"></textarea>
                                        @error('company_details')
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
        <div class="modal fade" id="new-expo-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="new-expo-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form method="POST" action="{{ route('admin.expo.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2 entry" id="entry" name="entry"
                                            style="width: 100%;" required>
                                            <option value="">-- Award Entry--</option>
                                            <option value="1" @if (old('entry') == '1') selected @endif>
                                                Individual
                                            </option>
                                            <option value="2" @if (old('entry') == '2') selected @endif>
                                                Company
                                            </option>
                                        </select>
                                        @if ($errors->has('entry'))
                                            <span class="text-danger">{{ $errors->first('entry') }}</span>
                                        @endif
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
                                    <div class="input-group mb-3 col-md-6 company_nameDiv">
                                        <input type="text"
                                            class="form-control @error('company_name') is-invalid @enderror"
                                            id="company_name" name="company_name"
                                            placeholder="Company/ Business Name" required autocomplete="company_name"
                                            value="{{ old('company_name') }}" autofocus>
                                        @error('company_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <input type="text"
                                            class="form-control @error('service_name') is-invalid @enderror"
                                            id="service_name" name="service_name"
                                            placeholder="Business / Service you provide" required
                                            autocomplete="service_name" value="{{ old('service_name') }}" autofocus>
                                        @error('service_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6 company_phoneDiv" id=""
                                        style="display: none">
                                        <input type="tel"
                                            class="form-control @error('company_phone') is-invalid @enderror"
                                            id="company_phone" name="company_phone" placeholder="Company Phone"
                                            value="{{ old('company_phone') }}" autocomplete="company_phone"
                                            autofocus>
                                        @error('company_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6 company_emailDiv" style="display: none">
                                        <input type="email"
                                            class="form-control @error('company_email') is-invalid @enderror"
                                            id="company_email" name="company_email" placeholder="Company Email"
                                            value="{{ old('company_email') }}" autocomplete="company_email"
                                            autofocus>
                                        @error('company_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('contact_person_name') is-invalid @enderror"
                                            id="contact_person_name" name="contact_person_name"
                                            placeholder="Contact Person Name" autocomplete="contact_person_name"
                                            value="{{ old('contact_person_name') }}" autofocus>
                                        @error('contact_person_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="tel"
                                            class="form-control @error('contact_person_phone') is-invalid @enderror"
                                            id="contact_person_phone" name="contact_person_phone"
                                            placeholder="Contact Person Phone" autocomplete="contact_person_phone"
                                            value="{{ old('contact_person_phone') }}" autofocus>
                                        @error('contact_person_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="email"
                                            class="form-control @error('contact_person_email') is-invalid @enderror"
                                            id="contact_person_email" name="contact_person_email"
                                            placeholder="Contact Person email" autocomplete="contact_person_email"
                                            value="{{ old('contact_person_email') }}" autofocus>
                                        @error('contact_person_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-md-6 mb-3">
                                        <input type="text"
                                            class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address" placeholder="Address Location"
                                            autocomplete="address" value="{{ old('address') }}" autofocus>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group col-12 mb-3">
                                        <textarea name="company_details" id="company_details" value="{{ old('company_details') }}" rows="5"
                                            class="form-control @error('company_details') is-invalid @enderror"
                                            placeholder="Short description about your company, business or service"></textarea>
                                        @error('company_details')
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
