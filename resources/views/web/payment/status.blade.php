@php($title = 'Payment Status')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-10">
        <div class="container">
            <div class="box">
                <div class="box-body">
                    @if ($status === 'successful')
                        <h2>Payment Successful</h2>
                        <p>Your payment was successful. Thank you for your registration!</p>
                        <p><strong>Reference:</strong> {{ $reference }}</p>
                        <p><strong>Transaction ID:</strong> {{ $transaction_id }}</p>
                        <p><strong>Name:</strong> {{ $registration->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $registration->customer_email }}</p>
                        <p><strong>Phone:</strong> {{ $registration->customer_phone_number }}</p>
                    @elseif ($status === 'cancelled')
                        <h2>Payment Cancelled</h2>
                        <p>Your payment was cancelled. Please try again or contact support.</p>
                        <p><strong>Reference:</strong> {{ $reference }}</p>
                    @elseif ($status === 'failed')
                        <h2>Payment Failed</h2>
                        <p>Your payment failed. Please try again or contact support.</p>
                        <p><strong>Reference:</strong> {{ $reference }}</p>
                    @else
                        <h2>Unknown Status</h2>
                        <p>An unknown error occurred. Please contact support.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
