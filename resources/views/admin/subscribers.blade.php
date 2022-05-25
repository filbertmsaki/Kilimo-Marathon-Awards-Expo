@extends("admin.layout.app")
@section("title",'Subscribers List')
@section("pagename",'Subscribers List')
@section('css')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
   <!-- DataTables -->
   <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
   <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
   <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
   
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
@endsection
@section('script')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
<style>
 select {
  /* for Firefox */
  -moz-appearance: none;
  /* for Chrome */
  -webkit-appearance: none;
}

/* For IE10 */
select::-ms-expand {
  display: none;
}
</style>
<script>
    $(function () {
     
        const date = new Date();
        const month = date.getMonth() + 1;
        const today= (month.toString().length > 1 ? month : "0" + month) + "_" + date.getDate() + "_" + date.getFullYear()+ "_" +date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();
        
        var table = $('#subscribertable').DataTable({
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
          pageLength: 10,
          responsive: true, "lengthChange": true, "autoWidth": false,
          processing: true,
          dom:"<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          buttons: [
                {
                extend:    'copy',
                text:      '<i class="fa fa-files-o"></i> Copy',
                titleAttr: 'Copy',
                className: 'btn btn-default btn-sm'
                },
                {
                extend:    'csv',
                text:      '<i class="fa fa-files-o"></i> CSV',
                titleAttr: 'CSV',
                title: 'subscribers_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'excel',
                text:      '<i class="fa fa-files-o"></i> Excel',
                titleAttr: 'Excel',
                title: 'subscribers_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'pdf',
                text:      '<i class="fa fa-file-pdf-o"></i> PDF',
                titleAttr: 'PDF',
                title: 'subscribers_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },               
                {
                  extend:    'print',
                  text:      '<i class="fa fa-print"></i> Print',
                  titleAttr: 'Print',
                  title: 'subscribers_lists_'+today,
                  className: 'btn btn-default btn-sm',
                  exportOptions: {
                      columns: ':not(:first,:last)'
                  }
                },  
          ],
     
        });
    });
  </script>
  <script>
    $(document).ready(function () {
   
        $("#master").click(function () {
			  	$('input:checkbox').not(this).prop('checked', this.checked);
		  	});

    });
  
    
  </script>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
       
        <!-- /.card -->
        <form  method="POST">
          @csrf
          @method('delete')
          <div class="card">
            <div class="card-header">
              <button style="margin-bottom: 10px" type="submit" class="btn btn-primary delete_all" formaction="{{ route('admin.subscribers.delete_all') }}">Delete Selected Subscribers</button>
        
          
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="subscribertable" class="table table-bordered table-striped">
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
                  @foreach ($subscribers  as $subscriber )
                    <tr id="subscriber_id_{{ $subscriber->id }}">
                      <td><input type="checkbox" name="subscriber_id[]" value="{{ $subscriber->id }}" id="sub_chk_{{ $subscriber->id }}" class="sub_chk"></td>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $subscriber->email }}</td>
                      <td>{{ $subscriber->created_at->format('d-m-Y g:i a') }}</td>
                 
                      <td class="" style="text-align:center"> 
                        <a href="{{ route('admin.subscribers.delete',$subscriber->id) }}" class=" btn btn-outline-primary  " data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
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
@endsection