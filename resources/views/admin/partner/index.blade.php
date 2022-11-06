<x-admin.layout.app-layout>
    @section('title', 'Partner')
    @section('pagename', 'Partner')
    @section('script')
        <script>
            $(document).ready(function() {

                /*  When user click add user button */
                $('#add-partner-btn').click(function() {
                    $('#add-partner-form').trigger("reset");
                    $('#add-partner-title').html("Add New Partner");
                    $('#add-partner-modal').modal('show');
                });
                /* When click edit user */
                $('body').on('click', '#edit-partner-btn', function() {
                    var data = $(this).data('id');
                    if (isJSON(data)) {
                        $('#edit-partner-title').html("Edit Partner");
                        $('#edit-partner-modal').modal('show');
                        $('#ed_partner_id').val(data.slug);
                        $('#ed_name').val(data.name);
                        $('#ed_description').val(data.description);
                        $('#ed_order').val(data.order);
                        $('#ed_event').select2('destroy');
                        $('#ed_status').val(data.status).select2();
                        var url = '{{ URL::asset('/') }}' + data.image_url;
                        $("#imageData").attr("src", url);
                    };
                });

            });
        </script>
    @endsection

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button style="margin-bottom: 10px" type="submit" class="btn btn-primary delete_all">Delete
                                Selected
                                Partner</button>
                            <button type="button" class="btn btn-secondary bg-dark add-partner-btn" id="add-partner-btn"
                                data-toggle="modal" style="float: right">
                                Add Partner
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="20px"><input type="checkbox" id="master"></th>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($partners as $partner)
                                        <tr id="partner_id_{{ $partner->id }}">
                                            <td><input type="checkbox" name="partner_id[]" value="{{ $partner->id }}"
                                                    id="sub_chk_{{ $partner->id }}" class="sub_chk"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $partner->name }}</td>
                                            <td>{{ $partner->description }}</td>
                                            <td>
                                                <div class="">
                                                    <img width="100" class="img-fluid"
                                                        src="{{ asset($partner->image_url) }}" alt="Site_logo">
                                                </div>
                                            </td>
                                            <td>{{ $partner->order }}</td>

                                            <td class="">
                                                <a href="javascript:void(0)" id="edit-partner-btn"
                                                    style="margin-right: 5px;" class="fa fa-edit edit-partner-btn"
                                                    data-id="{{ $partner }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit">
                                                </a>
                                                <a href=""
                                                    onclick="event.preventDefault();
                                                    document.getElementById('partner_delete-form{{ $partner->id }}').submit();"
                                                    class="fa fa-trash " data-toggle="tooltip" data-placement="top"
                                                    title="Delete">
                                                </a>
                                                <form class="d-none m-0 p-0"
                                                    id="partner_delete-form{{ $partner->id }}"
                                                    action="{{ route('admin.partner.destroy', 'delete') }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" id="id" name="id"
                                                        value="{{ $partner->id }}" />
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-partner-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-partner-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form name="edit-partner-form" id="edit-partner-form" method="POST"
                            action="{{ route('admin.partner.update', 'update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="partner_id" id="ed_partner_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name">Partner Name</label>
                                            <input type="text" id="ed_name" name="name" class="form-control"
                                                value="{{ old('name') }}" required>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div style="margin-bottom: 10px;" class="" id="partnerImage"></div>
                                        <div class="" style="margin-bottom: 10px;">
                                            <img width="300" class="img-fluid" id="imageData" alt="Site_Image">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="image">Partner Image</label>
                                            <input type="file" id="image" name="image"
                                                class="form-control">
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control select2" id="ed_status" name="status"
                                                style="width: 100%;" required>
                                                <option value=""> Select Status </option>
                                                <option value="1"
                                                    @if (old('status') == '1') selected @endif>Active
                                                </option>
                                                <option value="0"
                                                    @if (old('status') == '0') selected @endif>Inactive
                                                </option>
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="order">Arrangement Order</label>
                                            <input type="number" id="ed_order" name="order" required class="form-control"
                                                value="{{ old('order') }}" required>
                                            @if ($errors->has('order'))
                                                <span class="text-danger">{{ $errors->first('order') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="image">Description</label>
                                            <textarea class="form-control" name="description" id="ed_description" cols="30" rows="2"
                                                value="{{ old('description') }}"></textarea>
                                            @if ($errors->has('description'))
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" name="award-partner" value=""
                                    class="btn btn-outline-light btn-save">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="add-partner-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-partner-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form name="add-partner-form" id="add-partner-form" method="POST"
                            action="{{ route('admin.partner.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="name">Partner Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ old('name') }}" required>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="image">Partner Image</label>
                                            <input type="file" id="image" name="image" class="form-control"
                                                required>
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control select2" id="status" name="status"
                                                style="width: 100%;" required>
                                                <option value=""> Select Status </option>
                                                <option value="1"
                                                    @if (old('status') == '1') selected @endif>Active
                                                </option>
                                                <option value="0"
                                                    @if (old('status') == '0') selected @endif>Inactive
                                                </option>
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="order">Arrangement Order</label>
                                            <input type="number" id="order" name="order" required class="form-control"
                                                value="{{ old('order') }}" required>
                                            @if ($errors->has('order'))
                                                <span class="text-danger">{{ $errors->first('order') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="image">Description</label>
                                            <textarea class="form-control" name="description" id="description" cols="30" rows="2"
                                                value="{{ old('description') }}"></textarea>
                                            @if ($errors->has('description'))
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-light btn-save">Save changes</button>
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
