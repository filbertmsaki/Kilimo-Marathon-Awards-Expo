<x-admin.layout.app-layout>
    @section('title', 'Award Winners')
    @section('pagename', 'Award Winners')
    @section('css')
    @endsection
    @section('script')
    @endsection
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped" data-id="{{ $id }} Nominee List">
                                <thead>
                                    <tr>
                                        <th width="20px"><input type="checkbox" id="master"></th>
                                        <th>Nominee Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Category</th>
                                        <th>status</th>
                                        <th>Verified</th>
                                        <th>Votes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nominees as $nominee)
                                        <tr id="nominee_id_{{ $nominee->id }}">
                                            <td><input type="checkbox" name="category_id[]" value="{{ $nominee->id }}"
                                                    id="sub_chk_{{ $nominee->id }}" class="sub_chk"></td>
                                            <td>{{ $nominee->full_name }}</td>
                                            <td>{{ $nominee->mobile }}</td>
                                            <td>{{ $nominee->email }}</td>
                                            <td>{{ $nominee->awardcategory->name }}</td>
                                            <td>{{ $nominee->company_individual }}</td>
                                            <td>
                                                @if ($nominee->verified == 1)
                                                    Verified
                                                @else
                                                    Not Verified
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $nominee->vote ?? '0' }}
                                            </td>
                                            <td class="">
                                                <a href="javascript:void(0)" id=""
                                                    class="btn btn-outline-primary  btn-sm "
                                                    data-id=""><i class="fa fa-bell"></i>
                                                    Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</x-admin.layout.app-layout>
