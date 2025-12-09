@extends('layouts.app')

@section('styles')
    @include('partials.datatables.css')
@endsection


@section('content')
    <div class="themebody-wrap">
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Client Payments</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Invoice Number</th>
                                            <td>{{ $client_payment->invoice->invoice_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client</th>
                                            <td>{{ $client_payment->client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Type</th>
                                            <td>{{ $client_payment->payment_type }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status</th>
                                            <td>{{ $client_payment->payment_status }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>{{ $client_payment->payment_status }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>{{ $client_payment->amount }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{ $client_payment->updated_at->format('d-m-Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td>{{ $client_payment->remarks }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <a href="{{ route('client-payments.download_pdf', $client_payment->id) }}" class="btn btn-primary"
                                    target="_blank">
                                    Download
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
