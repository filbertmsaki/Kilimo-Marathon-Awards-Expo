<x-admin.layout.app-layout>
    @section('title', 'Subscribe')
    @section('pagename', 'Subscribe')
    @section('css')

    @endsection
    @section('script')
        <script>
            $(document).ready(function() {

                /* When click edit user */
                $('body').on('click', '.delete_subscriber', function() {
                    var data = $(this).data('id');
                    console.log(data);
                    var url = "{{ route('admin.subscribe.destroy', 'delete') }}";
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id:data
                        },
                        success: function(dataResult) {
                            window.location.reload();
                        }
                    })

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
                                    formaction="{{ route('admin.subscribe.destroy.all') }}">Delete Selected
                                    Subscribers</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="table-div">
                                <table id="datatable" class="table table-bordered table-striped"
                                    data-id="Subscribers List">
                                    <thead>
                                        <tr>
                                            <th width="20px"><input type="checkbox" id="master"></th>
                                            <th>S/N</th>
                                            <th>Email Address</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscribers as $subscriber)
                                            <tr id="subscriber_id_{{ $subscriber->id }}">
                                                <td><input type="checkbox" name="subscriber_id[]"
                                                        value="{{ $subscriber->id }}" id="sub_chk_{{ $subscriber->id }}"
                                                        class="sub_chk"></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $subscriber->email }}</td>
                                                <td>{{ $subscriber->created_at->format('d-m-Y g:i a') }}</td>

                                                <td class="" style="text-align:center">

                                                    <a href="javascript:void(0)"
                                                        class="btn btn-danger btn-sm delete_subscriber"
                                                        data-id="{{ $subscriber->id }}" data-toggle="tooltip"
                                                        data-placement="top" title="Delete"> <i
                                                            class="fa fa-trash "></i> Delete</a>
                                                    {{-- <form class="d-none m-0 p-0" id="data_delete"
                                                    action="{{ route('admin.subscribe.destroy', 'delete') }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id"
                                                        value="{{ $subscriber->id }}">
                                                </form> --}}
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
    </section>

</x-admin.layout.app-layout>
