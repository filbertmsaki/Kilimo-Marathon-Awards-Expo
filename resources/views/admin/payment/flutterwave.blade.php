<x-admin.layout.app-layout>
    @section('title', 'Flutterwave Payments')
    @section('pagename', 'Flutterwave Payments')
    @section('css')
    @endsection
    @section('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();

            $('body').on('click', '#verify-btn', function() {
                var payment = $(this).data('id');
                $('#payment-verity-modal').modal('show');

                // Dynamically generated content for the modal
                var paymentDetails = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Customer Name:</strong> ${payment.customer_name}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phone Number:</strong> ${payment.customer_phone_number}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email:</strong> ${payment.customer_email}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Payment Date:</strong> ${new Date(payment.created_at).toLocaleDateString()}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Transaction ID:</strong> ${payment.transaction_id}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Reference:</strong> ${payment.reference}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>FLW Reference:</strong> ${payment.flw_reference}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Payment Type:</strong> ${payment.payment_type}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> ${payment.status}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Currency:</strong> ${payment.charged_currency}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Amount:</strong> ${payment.amount}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Paid Amount:</strong> ${payment.charged_amount}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Card Details:</strong> ${payment.card_first_6digits}******${payment.card_last_4digits} (${payment.card_type})</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Issuer:</strong> ${payment.card_issuer}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Country:</strong> ${payment.card_country}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Related Model:</strong> ${payment.payable_type}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Related Model ID:</strong> ${payment.payable_id}</p>
                        </div>
                    </div>
                `;

                $('#invoice-details').html(paymentDetails);
            });
        });
    </script>
    @endsection
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- Optional Header -->
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped">
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
                                            <td>{{ $payment->customer_name }}</td>
                                            <td>{{ $payment->customer_phone_number }}</td>
                                            <td>{{ $payment->charged_amount }} {{ $payment->charged_currency }}</td>
                                            <td>{{ $payment->status }}</td>
                                            <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="verify-btn"
                                                    class="btn btn-primary btn-sm" data-id="{{ $payment }}"
                                                    data-toggle="tooltip" data-placement="top" title="Verify">
                                                    <i class="fa fa-check"></i> Verify
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="payment-verity-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title">Payment Verification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Invoice Details Here -->
                        <div id="invoice-details">
                            <!-- Dynamic content will be injected here via JavaScript -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-admin.layout.app-layout>
