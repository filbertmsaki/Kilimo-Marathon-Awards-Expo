<x-admin.layout.app-layout>
    @section('title', 'Dpo Payment')
    @section('pagename', 'Dpo Payment')
    @section('css')
    @endsection
    @section('script')
        <script>
            $(document).ready(function() {
                $('body').on('click', '#verify-btn', function() {
                    var value = $(this).data('id');
                    if (isJSON(value)) {
                        $('#payment-verity-modal').modal('show');

                        $('#payment_id').val(value.id);
                        $('#pay_slug').val(value.slug);
                        $('#customername').html(value.customername);
                        $('#transactionamount').html(value.transactionamount);
                        $('#customerphone').html('+' + value.customerphone);
                        $('#customeraddress').html(value.customeraddress);
                        $('#mobilepaymentrequest').html('Mobile Request : ' + value
                            .mobilepaymentrequest);
                        $('#transactionref').html('Invoice #' + value.transactionref);
                        $('#status').html('Payment Status: ' + value.status);
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
                        var curr_month = d.getMonth() + 1;
                        var curr_year = d.getFullYear();
                        var hours = d.getHours();
                        var minutes = d.getMinutes();
                        var seconds = d.getSeconds();
                        var st = value.transactionrollingreservedate;
                        var pattern = /(\d{4})\/(\d{2})\/(\d{2})/;
                        var dt = new Date(st.replace(pattern, '$1-$2-$3'));
                        var order_date = dt.getDate();
                        var order_month = dt.getMonth() + 1;
                        var order_year = dt.getFullYear();

                        var tax = value.transactionfinalamount - value.transactionnetamount;
                        $('#date').html(curr_date + "-" + curr_month + '-' + curr_year +
                            ' ' + hours + ":" + minutes + ":" + seconds);
                        $('#transactionrollingreservedate').html(order_date + "-" +
                            order_month + '-' + order_year);
                        $('#tax').html(tax.toFixed(2));
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
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped"
                                data-id="{{ date('Y') }} DPO Payment">
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
                                    @foreach ($payments as $payment)
                                        <tr id="award_category_id_{{ $payment->id }}">
                                            <td><input type="checkbox" name="category_id[]" value="{{ $payment->id }}"
                                                    id="sub_chk_{{ $payment->id }}" class="sub_chk"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $payment->customername }}</td>
                                            <td>{{ $payment->customerphone }}</td>
                                            <td>{{ $payment->transactionamount }}</td>
                                            <td>{{ $payment->status }}</td>
                                            <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                            <td class="">
                                                <a href="javascript:void(0)" id="verify-btn"
                                                    class="btn btn-primary btn-sm" data-id="{{ $payment }}"
                                                    data-toggle="tooltip" data-placement="top" title="Verify"> <i
                                                        class="fa fa-check "></i> Verify</a>
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
        <div class="modal fade" id="payment-verity-modal" ria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">

                    <!-- BEGIN INVOICE -->
                    <div class="col-xs-12">
                        <div class="grid invoice">
                            <div class="grid-body">
                                <div class="invoice-title">
                                    <div class="row" style="float:right;">
                                        <div class="col-xs-12">
                                            <h4 class="modal-title" id="userCrudModal"></h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h2>Invoice Details<br>
                                                <span class="small" id="transactionref"></span>
                                            </h2>
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
                                    <div class=" ml-auto mr-3 text-right">
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
                                                    <td class="text-right"><strong
                                                            id="transactionnetamount">N/A</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                    </td>
                                                    <td class="text-right"><strong>Total</strong></td>
                                                    <td class="text-right"><strong id="total">N/A</strong>
                                                    </td>
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
                            <form method="POST" action="{{ route('admin.payment.dpo.verify') }}">
                                @csrf
                                <input type="hidden" name="pay_slug" id="pay_slug">
                                <button type="submit" class="btn btn-outline-light btn-save">Verify Payment</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </div>
    </section>
</x-admin.layout.app-layout>
