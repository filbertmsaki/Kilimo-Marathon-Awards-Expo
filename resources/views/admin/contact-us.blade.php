@extends("admin.layout.app")
@section("title",'Contact List')
@section("pagename",'Contact List')
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
  <style>
    @media (min-width: 576px) {
  /* CSS that should be displayed if width is equal to or less than 800px goes here */
        .modal-dialog {
          max-width: 900px;
          margin: 1.75rem auto;
      }
  }
  </style>
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
        
        var table = $('#contact_table').DataTable({
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
                title: 'contact_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'excel',
                text:      '<i class="fa fa-files-o"></i> Excel',
                titleAttr: 'Excel',
                title: 'contact_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },
                {
                extend:    'pdf',
                text:      '<i class="fa fa-file-pdf-o"></i> PDF',
                titleAttr: 'PDF',
                title: 'contact_lists_'+today,
                className: 'btn btn-default btn-sm',
                exportOptions: {
                    columns: ':not(:first,:last)'
                }
                },               
                {
                  extend:    'print',
                  text:      '<i class="fa fa-print"></i> Print',
                  titleAttr: 'Print',
                  title: 'contact_lists_'+today,
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
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  
  
     /* When click edit user */
      $('body').on('click', '.view-contact', function () {
        var contact_id = $(this).data('id');
        $.get('/admin/contact-us/' + contact_id +'/view',
         function (data) {
           $('#editcrudModal').html("Contact Info");
            $('#btn-save').val("view-contact");
            $('#ajax-crud-modal').modal('show');
            $('#contact_id').val(data.id);
            $('#name').val(data.name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#message').val(data.message);
        })
     });   
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
            <button style="margin-bottom: 10px" type="submit" class="btn btn-primary delete_all" formaction="{{ route('admin.contact_us.delete_all') }}">Delete  Selected Contact</button>
         
          </div>
          <!-- /.card-header -->
          <div class="card-body">
                  <table id="contact_table" class="table table-bordered table-striped">
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
                          @foreach ($contact_us  as $contact )
                            <tr id="contact_id_{{ $contact->id }}">
                              <td><input type="checkbox" name="contact_id[]" value="{{ $contact->id }}" id="sub_chk_{{ $contact->id }}" class="sub_chk"></td>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $contact->name }}
                                <span class="badge float-right">@if($contact->seen_at == null)<span class="badge badge-success">Not Seen</span>@endif</span>
                              
                              </td>              

                              <td>{{ $contact->phone }}</td>
                              <td>{{ $contact->email }}</td>
                              <td>{{ Str::limit($contact->message, 50)  }}</td>
                              <td>{{ $contact->created_at->format('d-m-Y g:i a') }}</td>
                              <td class=""> 
                                <a href="javascript:void(0)" id="view-contact" style="margin-right: 5px;" class="fa fa-edit view-contact" data-id="{{ $contact->id }}" data-toggle="tooltip" data-placement="top" title="Edit" ></a>
                                <a href="{{ route('admin.contact_us.delete',$contact->id) }}" id="delete-contact" class=" delete-contact fa fa-trash " data-toggle="tooltip" data-placement="top" title="Delete"></a>
                             
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

  <div class="modal fade" id="ajax-crud-modal" ria-hidden="true">
    <div class="modal-dialog">
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
            <form method="POST" action="{{ route('admin.contact_us.update') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="contact_id" id="contact_id">
              <div class="card-body">
                <div class="row">
                      <div class="form-group col-md-6">
                      <div class="input-group mb-3">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="First Name"  required autocomplete="name" autofocus>
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
                          <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Last Name"  required autocomplete="phone" autofocus>
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
                      <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter Email"  required autocomplete="email" autofocus>
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
                <button type="submit" name="contact-bt" value=""   class="btn btn-outline-light btn-save">Seen</button>
            </div>
          </form>
          </div>
         
        </div>
        <!-- /.modal-content -->
      </div>
    <!-- /.modal-dialog -->
  </div>



</section>
@endsection