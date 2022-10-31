<x-admin.layout.app-layout>
    @section('title', 'Award Categories')
    @section('pagename', 'Award Categories')
    @section('css')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    @endsection
    @section('script')

        <script>
            $(document).ready(function() {
                /*  When user click add user button */
                $('body').on('click', '#add-new-category-btn', function() {
                    $('#add-new-category-form').trigger("reset");
                    $('#add-new-category-title').html("Add New runner");
                    $('#add-new-category-modal').modal('show');
                });
                /* When click edit user */
                $('body').on('click', '#edit-category-btn', function() {
                    var data = $(this).data('id');
                    console.log(data.description);
                    if (isJSON(data)) {
                        $('#edit-category-title').html("Edit Marathon runner");
                        $('#edit-category-modal').modal('show');
                        $('#category_id').val(data.slug);
                        $('#name').val(data.name);
                        $('#name_in_swahili').val(data.name_in_swahili);
                        $('#description_edit').summernote('code', data.description);
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
                                    formaction="{{ route('admin.award.category.destroy.all') }}">Delete Selected
                                    category</button>

                                <button type="button" class="btn btn-secondary bg-dark add-new-category-btn"
                                    id="add-new-category-btn" data-toggle="modal" style="float: right">
                                    Add category
                                </button>


                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered table-striped" data-id="Category">
                                    <thead>
                                        <tr>
                                            <th width="20px"><input type="checkbox" id="master"></th>
                                            <th>S/N</th>
                                            <th>Category Name</th>
                                            <th>Total Nominees Per Category</th>
                                            <th>Total Vote Per Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr id="award_category_id_{{ $category->slug }}">
                                                <td><input type="checkbox" name="category_id[]"
                                                        value="{{ $category->slug }}" id="sub_chk_{{ $category->slug }}"
                                                        class="sub_chk"></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ count($category->current_year_nominee) }}</td>
                                                <td>{{ $category->current_year_nominee->sum('vote') }}</td>
                                                <td class="">
                                                    <a href="javascript:void(0)" id="edit-category-btn"
                                                        style="margin-right: 5px;" class="fa fa-edit "
                                                        data-id="{{ $category }}" data-toggle="tooltip"
                                                        data-placement="top" title="Edit"></a>
                                                    <a href="{{ route('admin.award.category.destroy', 'delete') }}"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('delete-category-btn').submit();"
                                                        id="delete-runner" class=" delete-runner fa fa-trash "
                                                        data-toggle="tooltip" data-placement="top" title="Delete"></a>
                                                    <form class="d-none m-0 p-0" id="delete-category-btn"
                                                        action="{{ route('admin.award.category.destroy', 'delete') }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id"
                                                            value="{{ $category->slug }}">
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

        <div class="modal fade" id="add-new-category-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="add-new-category-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form name="add-new-category-form" id="add-new-category-form" method="POST"
                            action="{{ route('admin.award.category.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" name="name" placeholder="Category Name">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <input class="form-control" name="name_in_swahili"
                                                placeholder="Category Name In Swahili">
                                            @if ($errors->has('name_in_swahili'))
                                                <span
                                                    class="text-danger">{{ $errors->first('name_in_swahili') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Category Description</label>
                                    <textarea id="description" name="description" class="form-control summernote" style="height: 500px"></textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-light btn-add">Save
                                    changes</button>

                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="edit-category-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-category-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <form id="edit-category-form" method="POST"
                            action="{{ route('admin.award.category.update', 'update') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="category_id" id="category_id">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" name="name" id="name"
                                                placeholder="Category Name">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <input class="form-control" name="name_in_swahili" id="name_in_swahili"
                                                placeholder="Category Name In Swahili">
                                            @if ($errors->has('name_in_swahili'))
                                                <span
                                                    class="text-danger">{{ $errors->first('name_in_swahili') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Category Description</label>
                                    <textarea id="description_edit" name="description" class="form-control summernote" style="height: 500px"></textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light"
                                    data-dismiss="modal">Close</button>

                                <button type="submit" name="category_data" value=""
                                    class="btn btn-outline-light btn-save">Save
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
