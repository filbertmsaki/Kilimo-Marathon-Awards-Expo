@extends("admin.layout.app")
@section("title",'Payment Page')
@section("pagename",'Payment')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">

 <!-- Google Font: Source Sans Pro -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <style>

.invoice {
    padding: 30px;
    color:#fff !important;
}

.invoice h2 {
	margin-top: 0px;
	line-height: 0.8em;
}

.invoice .small {
	font-weight: 300;
  font-size: 60%;
}

.invoice hr {
	margin-top: 10px;
	border-color: #ddd;
}

.invoice .table tr.line {
	border-bottom: 1px solid #ccc;
}

.invoice .table td {
	border: none;
}

.invoice .identity {
	margin-top: 10px;
	font-size: 1.1em;
	font-weight: 300;
}

.invoice .identity strong {
	font-weight: 600;
}


.grid {
    position: relative;
	width: 100%;
	color: #666666;
	border-radius: 2px;
	box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
}
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

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
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
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- Page specific script -->
<script>  
  $(function () {
   
      const date = new Date();
      const month = date.getMonth() + 1;
      const today= (month.toString().length > 1 ? month : "0" + month) + "_" + date.getDate() + "_" + date.getFullYear()+ "_" +date.getHours() + "" + date.getMinutes() + "" + date.getSeconds();
      
      var table = $('#empTable').DataTable({
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
              title: 'Payment_lists_'+today,
              className: 'btn btn-default btn-sm',
              exportOptions: {
                  columns: ':not(:first,:last)'
              }
              },
              {
              extend:    'excel',
              text:      '<i class="fa fa-files-o"></i> Excel',
              titleAttr: 'Excel',
              title: 'Payment_lists_'+today,
              className: 'btn btn-default btn-sm',
              exportOptions: {
                  columns: ':not(:first,:last)'
              }
              },
              {
              extend:    'pdf',
              text:      '<i class="fa fa-file-pdf-o"></i> PDF',
              titleAttr: 'PDF',
              title: 'Payment_lists_'+today,
              className: 'btn btn-default btn-sm',
              exportOptions: {
                  columns: ':not(:first,:last)'
              }
              },               
              {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> Print',
                titleAttr: 'Print',
                title: 'Payment_lists_'+today,
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
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    //Edit User
        $('body').on('click', '#edit-user', function () {
          var payment_id = $(this).data('id');
          $.get('/admin/payments/dpo/' + payment_id +'/view',
          
            function (data) {

                $('#role_checkbox').empty();
                $('#permission_checkbox').empty();
                $('#userCrudModal').empty();
                $('#customername').empty();
                $('#btn-save').val("edit-user");
                $('#ajax-crud-modal').modal('show');

                $.each(data, function(key,value) {
                  // $('#userCrudModal').html('Customer Name: '+ value.slug);
                  $('#payment_id').val(value.id);
                  $('#pay_slug').val(value.slug);
                  $('#customername').html(value.customername);
                  $('#transactionamount').html(value.transactionamount);
                  $('#customerphone').html('+255 - '+value.customerphone);
                  $('#customeraddress').html(value.customeraddress);
                  $('#mobilepaymentrequest').html('Mobile Request : '+value.mobilepaymentrequest);
                  $('#transactionref').html('Invoice #'+value.transactionref);
                  $('#status').html('Payment Status: '+value.status);
                  $('#customercredittype').html(value.customercredittype);
                  $('#result').html(value.result);
                  $('#resultexplanation').html(value.resultexplanation);
                  $('#transactionfinalamount').html(value.transactionfinalamount);
                  $('#fraudalert').html(value.fraudalert);
                  $('#fraudexplnation').html(value.fraudexplnation);
                  $('#transactionnetamount').html(value.transactionnetamount);
                  $('#total').html(value.transactionfinalamount.toFixed(2));

                  var d = new Date(value.created_at);
                  var curr_date = d.getDate();
                  var curr_month = d.getMonth()+ 1;
                  var curr_year = d.getFullYear();

                  var hours = d.getHours();
                  var minutes = d.getMinutes();
                  var seconds = d.getSeconds();

                  var st = value.transactionrollingreservedate;
                  var pattern = /(\d{4})\/(\d{2})\/(\d{2})/;
                  var dt = new Date(st.replace(pattern,'$1-$2-$3'));
                  var order_date = dt.getDate();
                  var order_month = dt.getMonth()+ 1;
                  var order_year = dt.getFullYear();

                  var tax = value.transactionfinalamount - value.transactionnetamount;

                    $('#date').html(curr_date + "-" + curr_month + '-' + curr_year+' ' +hours + ":" +minutes+ ":" +seconds);

                    $('#transactionrollingreservedate').html(order_date + "-" + order_month + '-' + order_year);
                    $('#tax').html(tax.toFixed(2));

                  });
          })
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

            <div class="card">
              <div class="card-header">
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="empTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="20px"><input type="checkbox" id="master"></th>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Pay Date</th>
                    <th>Action(s)</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($payments  as $payment )
                      <tr id="award_category_id_{{ $payment->id }}">
                        <td><input type="checkbox" name="category_id[]" value="{{ $payment->id }}" id="sub_chk_{{ $payment->id }}" class="sub_chk"></td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payment->customername }}</td>
                        <td >{{ $payment->customerphone  }}</td>
                        <td >{{$payment->transactionamount   }}</td>
                        <td >{{$payment->status   }}</td>
                        <td >{{$payment->created_at->format('d/m/Y')   }}</td>
                        <td class=""> 
                          <a href="javascript:void(0)" id="edit-user" style="margin-right: 5px;" class="fa fa-edit " data-id="{{ $payment->id }}" data-toggle="tooltip" data-placement="top" title="Edit" ></a>
                          <a href="#" id="delete-category" class=" delete-category fa fa-trash " data-toggle="tooltip" data-placement="top" title="Delete"></a>
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

      <div class="modal fade" id="ajax-crud-modal" ria-hidden="true" >
        <div class="modal-dialog">
          <div class="modal-content bg-dark" >
            <form method="POST" action="{{ route('admin.dpo_payments.verify') }}" >
              @csrf
              <input type="hidden" name="payment_id" id="payment_id">
              <input type="hidden" name="pay_slug" id="pay_slug">
  
           
                    <!-- BEGIN INVOICE -->
                    <div class="col-xs-12">
                      <div class="grid invoice">
                          <div class="grid-body">
                              <div class="invoice-title">
                                  <div class="row" style="float:right;" >
                                      <div class="col-xs-12"  >
                                        <h4 class="modal-title" id="userCrudModal"></h4>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>                                                            
                                      </div>
                                  </div>
                                  <br>
                                  <div class="row">
                                      <div class="col-xs-12">
                                          <h2>Invoice Details<br>
                                          <span class="small" id="transactionref"></span></h2>
                                      </div>
                                  </div>
                              </div>
                              <hr>
                              <div class="row ml-1">
                                  <div class="">
                                      <address>
                                          <strong>Billed To:</strong><br>
                                          <span id="customername"></span><br>
                                          <span id="customeraddress"></span><br>
                                          <span title="Phone" id="customerphone"></span> 
                                      </address>
                                  </div>
                                  <div class=" ml-auto mr-3 text-right" >
                                      <address>
                                          <strong>Payed To:</strong><br>
                                          Kilimo Marathon, Awards & EXPO<br>
                                          Mkulima House, 2nd Floor - Mandela Rd,<br>
                                          Ubungo, Dar es salaam, Tanzania<br>
                                          <abbr title="Phone">P:</abbr> +255 754 222 800
                                      </address>
                                  </div>
                              </div>
                              <div class="row ml-1">
                                  <div class="">
                                      <address>
                                          <strong>Payment Method:</strong><br>
                                          <span id="customercredittype">Visa ending **** 1234</span><br>
                                          
                                      </address>
                                  </div>
                                  <div class="ml-auto mr-3 text-right">
                                      <address>
                                          <strong>Order Date:</strong><br>
                                          <span id="date"></span>
                                      </address>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                      <h3> SUMMARY</h3>
                                      <table class="table table-striped">
                                          <thead>
                                              {{-- <tr class="line">
                                                  <td><strong>#</strong></td>
                                                  <td class="text-center"><strong>PROJECT</strong></td>
                                                  <td class="text-center"><strong>HRS</strong></td>
                                                  <td class="text-right"><strong>RATE</strong></td>
                                                  <td class="text-right"><strong>SUBTOTAL</strong></td>
                                              </tr> --}}
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td>1</td>
                                                  <td><strong>Transaction Detail</strong></td>
                                                  <td class="text-center" id="result">15</td>
                                                  <td class="text-center" id="resultexplanation"></td>
                                                  <td class="text-right" id="transactionfinalamount"></td>
                                              </tr>
                                              <tr>
                                                  <td>2</td>
                                                  <td><strong>Fraud</strong></td>
                                                  <td class="text-center" id="fraudalert"></td>
                                                  <td class="text-center" id="fraudexplnation"></td>
                                                  <td class="text-right"> N/A</td>
                                              </tr>
                                              <tr class="line">
                                                  <td>3</td>
                                                  <td><strong>Transaction Date</strong></td>
                                                  <td class="text-center">N/A</td>
                                                  <td class="text-center" id="transactionrollingreservedate"></td>
                                                  <td class="text-right">N/A</td>
                                              </tr>
                                              <tr>
                                                  <td colspan="3"></td>
                                                  <td class="text-right"><strong>VAT</strong></td>
                                                  <td class="text-right"><strong id="tax">N/A</strong></td>
                                              </tr>
                                              <tr>
                                                <td colspan="3"></td>
                                                <td class="text-right"><strong>Net Amount</strong></td>
                                                <td class="text-right"><strong id="transactionnetamount">N/A</strong></td>
                                            </tr>
                                              <tr>
                                                  <td colspan="3">
                                                  </td><td class="text-right"><strong>Total</strong></td>
                                                  <td class="text-right"><strong id="total">N/A</strong></td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>									
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- END INVOICE -->
                
                <!-- /.card-body -->               
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                @can('edit-users')
                  <button type="submit" name="user_data" value=""   class="btn btn-outline-light btn-save">Verify Payment</button>
                @endcan
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