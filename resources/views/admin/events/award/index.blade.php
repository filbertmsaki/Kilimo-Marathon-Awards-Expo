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
                        $('#ed_full_name').val(data.full_name);
                        $('#ed_address').val(data.address);
                        $('#ed_mobile').val(data.mobile);
                        $('#ed_email').val(data.email);
                        $('#ed_phonecode').select2('destroy');
                        $('#ed_phonecode').val(data.phonecode).select2();
                        $('#company_individual').select2('destroy');
                        $('#company_individual').val(data.company_individual).select2();
                        $('#category_id').select2('destroy');
                        $('#category_id').val(data.category_id).select2();
                        $('#verified').select2('destroy');
                        $('#verified').val(data.verified).select2();
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
                                            <th>Nominee Name</th>
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
                                                <td><input type="checkbox" name="category_id[]"
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
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror"
                                                id="ed_full_name" name="full_name" placeholder="Nominee Name" required
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
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                id="ed_address" name="address" placeholder="Address Name"
                                                autocomplete="address" autofocus>

                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="phonecode" id="ed_phonecode"
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
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('mobile') is-invalid @enderror"
                                                id="ed_mobile" name="mobile" placeholder="Nominee Mobile"
                                                autocomplete="mobile" autofocus>
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
                                                id="ed_email" name="email" placeholder="Nominee Email"
                                                autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <select class="form-control select2 ed_individual" id="ed_individual"
                                                name="company_individual" style="width: 100%;">
                                                <option value="">-- Award Entry--</option>
                                                <option value="1"
                                                    @if (old('entry') == '1') selected @endif>
                                                    Individual
                                                </option>
                                                <option value="2"
                                                    @if (old('entry') == '2') selected @endif>
                                                    Company
                                                </option>
                                            </select>
                                            @if ($errors->has('company_individual'))
                                                <span
                                                    class="text-danger">{{ $errors->first('company_individual') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <select class="form-control select2 category_id" id="category_id"
                                                name="category_id" style="width: 100%;">
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if (old('category_id') == $item->id) selected @endif>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category_id'))
                                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <select class="form-control select2 verified" id="verified"
                                                name="verified" style="width: 100%;">
                                                <option value="1"
                                                    @if (old('verified') == '1') selected @endif>Verified
                                                </option>
                                                <option value="0"
                                                    @if (old('verified') == '0') selected @endif>Not Verified
                                                </option>
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
                                    <div class="form-group col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror"
                                                id="full_name" name="full_name" placeholder="Nominee Name" required
                                                autocomplete="full_name" value="{{ old('full_name') }}" autofocus>

                                            @error('full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            name="email" placeholder="Nominee Email" value="{{ old('email') }}"
                                            autocomplete="email" autofocus>

                                        <span class="help-block"><strong></strong></span>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="phonecode" id="phonecode"
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
                                    <div class="input-group mb-3 col-md-6">
                                        <input type="mobile"
                                            class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                                            name="mobile" placeholder="Nominee Mobile" value="{{ old('mobile') }}"
                                            autocomplete="mobile" autofocus>

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
                                                class="form-control @error('address') is-invalid @enderror"
                                                id="address" name="address" placeholder="Nominee Address"
                                                autocomplete="address" value="{{ old('address') }}" autofocus>

                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="category_id" style="width: 100%;">
                                            <option value="">----Select Category ----</option>
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
                                        <select class="form-control select2" name="company_individual"
                                            data-placeholder="To:" style="width: 100%;">
                                            <option value="Individual"
                                                @if (old('company_individual') == 'Individual') selected @endif>Individual</option>
                                            <option value="Company"
                                                @if (old('company_individual') == 'Company') selected @endif>Company</option>
                                        </select>
                                        @if ($errors->has('company_individual'))
                                            <span
                                                class="text-danger">{{ $errors->first('company_individual') }}</span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-md-6">
                                        <select class="form-control select2" name="verified" style="width: 100%;">
                                            <option value="1" @if (old('verified') == '1') selected @endif>
                                                Verified</option>
                                            <option value="0" @if (old('verified') == '0') selected @endif>
                                                Not Verified</option>
                                        </select>
                                        @if ($errors->has('verified'))
                                            <span class="text-danger">{{ $errors->first('verified') }}</span>
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
