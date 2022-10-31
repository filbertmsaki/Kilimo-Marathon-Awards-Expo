<x-admin.layout.app-layout>
    @section('title', 'Contact Us')
    @section('pagename', 'Contact Us')
    @section('css')
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                $('body').on('click', '#view-contact', function() {
                    var data = $(this).data('id');
                    if (isJSON(data)) {
                        $('#editcrudModal').html("Contact Info");
                        $('#view-contact-modal').modal('show');
                        $('#contact_id').val(data.id);
                        $('#name').val(data.name);
                        $('#phone').val(data.phone);
                        $('#email').val(data.email);
                        $('#message').val(data.message);
                    }
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
                                    formaction="{{ route('admin.contact.destroy.all') }}">Delete Selected
                                    Contact</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered table-striped" data-id="Contact List">
                                    <thead>
                                        <tr>
                                            <th width="20px"><input type="checkbox" id="master"></th>
                                            <th>S/N</th>
                                            <th>Sender Name</th>
                                            <th>Mobile</th>
                                            <th>email</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contact_us as $contact)
                                            <tr id="contact_id_{{ $contact->id }}">
                                                <td><input type="checkbox" name="contact_id[]"
                                                        value="{{ $contact->id }}" id="sub_chk_{{ $contact->id }}"
                                                        class="sub_chk"></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $contact->name }}
                                                    <span class="badge float-right">
                                                        @if ($contact->seen_at == null)
                                                            <span class="badge badge-success">Not Seen</span>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>{{ $contact->phone }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ Str::limit($contact->message, 50) }}</td>
                                                <td>{{ $contact->created_at->format('d-m-Y g:i a') }}</td>
                                                <td class="">
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" id="view-contact"
                                                            class="btn btn-info btn-sm" data-id="{{ $contact }}"
                                                            data-toggle="tooltip" data-placement="top" title="Read">
                                                            <i class="fa fa-eye "></i> Read</a>
                                                        <a href="javascript:void(0)"
                                                            onclick="event.preventDefault();
                                                        document.getElementById('data_delete').submit();"
                                                            class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Delete"> <i
                                                                class="fa fa-trash "></i> Delete</a>
                                                    </div>
                                                    <form class="d-none m-0 p-0" id="data_delete"
                                                        action="{{ route('admin.contact.destroy', 'delete') }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id"
                                                            value="{{ $contact->id }}">
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
        <div class="modal fade" id="view-contact-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editcrudModal"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <input type="hidden" name="contact_id" id="contact_id">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="First Name" required
                                            autocomplete="name" autofocus>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" placeholder="Last Name" required
                                            autocomplete="phone" autofocus>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-phone"></span>
                                            </div>
                                        </div>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Enter Email" required
                                            autocomplete="email" autofocus>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message"> Message</label>
                                <textarea name="message" class="form-control" id="message" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <form method="POST" action="{{ route('admin.contact.update', 'update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-light btn-save">Seen</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>
</x-admin.layout.app-layout>
