<x-admin.layout.app-layout>
    @section('title', 'Marathon runner List')
    @section('pagename', 'Marathon runner List')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped" data-id="Marathon List">
                                <thead>
                                    <tr>
                                        <th width="20px"><input type="checkbox" id="master"></th>
                                        <th>S/N</th>
                                        <th>runner Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Distance</th>
                                        <th>Region</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($runners as $runner)
                                        <tr id="marathon_runner_id_{{ $runner->id }}">
                                            <td><input type="checkbox" name="runner_id[]" value="{{ $runner->id }}"
                                                    id="sub_chk_{{ $runner->id }}" class="sub_chk"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $runner->full_name }}</td>
                                            <td>{{ $runner->phone }}</td>
                                            <td>{{ $runner->email }}</td>
                                            <td>{{ $runner->event }} Km</td>
                                            <td>{{ $runner->region }}</td>

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


    </section>
</x-admin.layout.app-layout>
