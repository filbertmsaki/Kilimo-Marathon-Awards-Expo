<x-admin.layout.app-layout>
    @section('title', 'Gallery')
    @section('pagename', 'Gallery')
    @section('script')
        <script>
            $(document).ready(function() {
     
                /*  When user click add user button */
                $('#add-gallery-btn').click(function() {
                    $('#add-gallery-form').trigger("reset");
                    $('#add-gallery-title').html("Add New gallery");
                    $('#add-gallery-modal').modal('show');
                });
                /* When click edit user */
                $('body').on('click', '#edit-gallery-btn', function() {
                    var data = $(this).data('id');
                    if (isJSON(data)) {
                        $('#edit-gallery-title').html("Edit Gallery");
                        $('#edit-gallery-modal').modal('show');
                        $('#ed_gallery_id').val(data.slug);
                        $('#ed_title').val(data.title);
                        $('#ed_description').val(data.description);
                        $('#ed_event').select2('destroy');
                        $('#ed_event').val(data.event).select2();
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
                                Gallery</button>
                            <button type="button" class="btn btn-secondary bg-dark add-gallery-btn" id="add-gallery-btn"
                                data-toggle="modal" style="float: right">
                                Add Gallery
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="20px"><input type="checkbox" id="master"></th>
                                        <th>S/N</th>
                                        <th>Image title</th>
                                        <th>Image Description</th>
                                        <th>Image</th>
                                        <th>position</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($galleries as $gallery)
                                        <tr id="gallery_id_{{ $gallery->id }}">
                                            <td><input type="checkbox" name="gallery_id[]" value="{{ $gallery->id }}"
                                                    id="sub_chk_{{ $gallery->id }}" class="sub_chk"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $gallery->title }}</td>
                                            <td>{{ $gallery->description }}</td>
                                            <td>
                                                <div class="">
                                                    <img width="100" class="img-fluid"
                                                        src="{{ asset($gallery->image_url) }}" alt="Site_logo">
                                                </div>
                                            </td>
                                            <td>{{ ucwords($gallery->event) }}</td>
                                            <td class="">
                                                <a href="javascript:void(0)" id="edit-gallery-btn"
                                                    style="margin-right: 5px;" class="fa fa-edit edit-gallery-btn"
                                                    data-id="{{ $gallery }}" data-toggle="tooltip"
                                                    data-placement="top" title="Edit">
                                                </a>
                                                <a href=""
                                                    onclick="event.preventDefault();
                                                    document.getElementById('gallery_delete-form{{ $gallery->id }}').submit();"
                                                    class="fa fa-trash " data-toggle="tooltip" data-placement="top"
                                                    title="Delete">
                                                </a>
                                                <form class="d-none m-0 p-0"
                                                    id="gallery_delete-form{{ $gallery->id }}"
                                                    action="{{ route('admin.gallery.destroy', 'delete') }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" id="id" name="id"
                                                        value="{{ $gallery->id }}" />
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
        <div class="modal fade" id="edit-gallery-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-gallery-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form name="edit-gallery-form" id="edit-gallery-form" method="POST"
                            action="{{ route('admin.gallery.update', 'update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="gallery_id" id="ed_gallery_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="event">Event</label>
                                            <select class="form-control select2" id="ed_event" name="event"
                                                style="width: 100%;" required>
                                                <option value=""> Select Event </option>
                                                <option value="marathon"
                                                    @if (old('event') == 'marathon') selected @endif>Kilimo Marathon
                                                </option>
                                                <option value="awards"
                                                    @if (old('event') == 'awards') selected @endif>Kilimo Awards
                                                </option>
                                                <option value="expo"
                                                    @if (old('event') == 'expo') selected @endif>Kilimo Expo
                                                </option>
                                            </select>
                                            @if ($errors->has('event'))
                                                <span class="text-danger">{{ $errors->first('event') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="title">Image Title</label>
                                            <input type="text" id="ed_title" name="title" class="form-control"
                                                value="{{ old('title') }}" required>
                                            @if ($errors->has('title'))
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div style="margin-bottom: 10px;" class="" id="galleryImage"></div>
                                        <div class="" style="margin-bottom: 10px;">
                                            <img width="300" class="img-fluid" id="imageData" alt="Site_logo">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="image">Upload Image</label>
                                            <input type="file" id="image" name="image"
                                                class="form-control">
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="image">Image Description</label>
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
                                <button type="submit" name="award-gallery" value=""
                                    class="btn btn-outline-light btn-save">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="add-gallery-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-gallery-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form name="add-gallery-form" id="add-gallery-form" method="POST"
                            action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="event">Event</label>
                                            <select class="form-control select2" id="event" name="event"
                                                style="width: 100%;" required>
                                                <option value=""> Select Event </option>
                                                <option value="marathon"
                                                    @if (old('event') == 'marathon') selected @endif>Kilimo Marathon
                                                </option>
                                                <option value="awards"
                                                    @if (old('event') == 'awards') selected @endif>Kilimo Awards
                                                </option>
                                                <option value="expo"
                                                    @if (old('event') == 'expo') selected @endif>Kilimo Expo
                                                </option>
                                            </select>
                                            @if ($errors->has('event'))
                                                <span class="text-danger">{{ $errors->first('event') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="title">Image Title</label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                value="{{ old('title') }}" required>
                                            @if ($errors->has('title'))
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="image">Upload Image</label>
                                            <input type="file" id="image" name="image" class="form-control"
                                                required>
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="image">Image Description</label>
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
