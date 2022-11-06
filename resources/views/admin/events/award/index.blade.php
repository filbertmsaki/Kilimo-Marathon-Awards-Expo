<x-admin.layout.app-layout>
    @section('title', 'Award Nominees')
    @section('pagename', 'Award Nominees')
    @section('css')
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                /*  When user click add user button */
                $('body').on('click', '#add-new-nominee-btn', function() {
                    $('#add-nominee-form').trigger("reset");
                    $('#add-nominee-title').html("Add New Nominee");
                    $('#add-nominee-modal').modal('show');
                });
                /* When click edit user */
                $('body').on('click', '#edit-nominee-btn', function() {
                    var data = $(this).data('id');
                    if (isJSON(data)) {
                        $('#edit-nominee-title').html("Edit Nominee");
                        $('#edit-nominee-modal').modal('show');
                        $('#ed_nominee_id').val(data.slug);
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
                        $('#ed_category_id').select2('destroy');
                        $('#ed_category_id').val(data.category_id).select2();
                        $('#ed_verified').select2('destroy');
                        $('#ed_verified').val(data.verified).select2();
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
                    <form method="POST">
                        @csrf
                        @method('delete')
                        <div class="card">
                            <div class="card-header">
                                <button style="margin-bottom: 10px" type="submit" class="btn btn-primary delete_all"
                                    formaction="{{ route('admin.award.destroy.all') }}">Delete Selected
                                    Nominee</button>
                                <button type="button" class="btn btn-secondary bg-dark add-new-nominee-btn"
                                    id="add-new-nominee-btn" data-toggle="modal" style="float: right">
                                    Add Nominee
                                </button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered table-striped" data-id="Nominee List">
                                    <thead>
                                        <tr>
                                            <th width="20px"><input type="checkbox" id="master"></th>
                                            <th>Company/ Business Name</th>
                                            <th>Contact Phone</th>
                                            <th>Contact Email</th>
                                            <th>Category</th>
                                            <th>Entry</th>
                                            <th>Status</th>
                                            <th>Votes</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nominees as $nominee)
                                            <tr id="nominee_id_{{ $nominee->id }}">
                                                <td><input type="checkbox" name="award_id[]"
                                                        value="{{ $nominee->id }}" id="sub_chk_{{ $nominee->id }}"
                                                        class="sub_chk"></td>
                                                <td>{{ $nominee->company_name }}</td>
                                                <td>{{ $nominee->contact_person_phone }}</td>
                                                <td>{{ $nominee->contact_person_email }}</td>
                                                <td>{{ $nominee->awardcategory->name }}</td>
                                                <td>
                                                    @if ($nominee->entry == 1)
                                                        <span class="right badge badge-info">Individual</span>
                                                    @elseif ($nominee->entry == 2)
                                                        <span class="right badge badge-success">Company</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($nominee->verified == 1)
                                                        <span class="right badge badge-success">Verified</span>
                                                    @elseif ($nominee->verified == 0)
                                                        <span class="right badge badge-warning">Not Verified</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ $nominee->vote ?? '0' }}
                                                </td>
                                                <td class="">
                                                    <a href="javascript:void(0)" id="edit-nominee-btn"
                                                        class="btn btn-outline-primary  btn-sm edit-nominee-btn"
                                                        data-id="{{ $nominee }}"><i class="fa fa-bell"></i>
                                                        Edit</a>
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
        <!--Edit Model -->
        <div class="modal fade" id="edit-nominee-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-nominee-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-nominee-form" name="edit-nominee-form" method="POST"
                            action="{{ route('admin.award.update', 'update') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="nominee_id" id="ed_nominee_id">
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
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="ed_category_id" name="category_id"
                                            style="width: 100%;" required>
                                            <option value="">-- Award Category --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (old('category_id') == $category->id) selected @endif>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="ed_verified" name="verified"
                                            style="width: 100%;" required>
                                            <option value="1" @if (old('verified') == '1') selected @endif>
                                                Verified</option>
                                            <option value="0" @if (old('verified') == '0') selected @endif>
                                                Not Verified</option>
                                        </select>
                                        @if ($errors->has('verified'))
                                            <span class="text-danger">{{ $errors->first('verified') }}</span>
                                        @endif
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
                                <button type="submit" class="btn btn-outline-light">Save
                                    changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Add Model -->
        <div class="modal fade" id="add-nominee-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-nominee-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form name="add-nominee-form" id="add-nominee-form" method="POST"
                            action="{{ route('admin.award.store') }}" enctype="multipart/form-data">
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
                                    <div class="input-group mb-3 col-md-6 company_nameDiv" id="">
                                        <input type="text"
                                            class="form-control company_name @error('company_name') is-invalid @enderror"
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
                                            class="form-control company_phone @error('company_phone') is-invalid @enderror"
                                            id="company_phone" name="company_phone" placeholder="Company Phone"
                                            value="{{ old('company_phone') }}" autocomplete="company_phone"
                                            autofocus>
                                        @error('company_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6 company_emailDiv" id=""
                                        style="display: none">
                                        <input type="email"
                                            class="form-control company_email @error('company_email') is-invalid @enderror"
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
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="category_id" name="category_id"
                                            style="width: 100%;" required>
                                            <option value="">-- Award Category --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (old('category_id') == $category->id) selected @endif>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" id="verified" name="verified"
                                            style="width: 100%;" required>
                                            <option value="1" @if (old('verified') == '1') selected @endif>
                                                Verified</option>
                                            <option value="0" @if (old('verified') == '0') selected @endif>
                                                Not Verified</option>
                                        </select>
                                        @if ($errors->has('verified'))
                                            <span class="text-danger">{{ $errors->first('verified') }}</span>
                                        @endif
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
