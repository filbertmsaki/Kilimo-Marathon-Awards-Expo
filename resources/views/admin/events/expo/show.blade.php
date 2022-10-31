<x-admin.layout.app-layout>
    @section('title', $id . ' Expo List')
    @section('pagename', $id . ' Expo List')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped"
                                data-id="{{ $id }} Expo List">
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
                                            <td>{{ $expo->service_business_name }}</td>
                                            <td>{{ $expo->contact_person_name }}</td>
                                            <td>{{ $expo->contact_person_phone }}</td>
                                            <td>{{ $expo->contact_person_email }}</td>
                                            <td>{{ $expo->business_details }}</td>
                                            <td class="">
                                                <a href="javascript:void(0)" id="" style="margin-right: 5px;"
                                                    class="fa fa-edit" data-id="" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"></a>
                                                <a href="javascript:void(0)" id="" class=" fa fa-trash"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"></a>

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
    </section>
</x-admin.layout.app-layout>
