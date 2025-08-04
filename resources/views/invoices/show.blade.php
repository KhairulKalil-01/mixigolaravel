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
                                <h4>Invoice Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Invoice Number</th>
                                            <td>{{ $invoice->invoice_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Quotation Number</th>
                                            <td>{{ $invoice->quotation->quotation_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client</th>
                                            <td>{{ $invoice->quotation->client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $invoice->quotation->client->mobileno }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $invoice->quotation->client->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>{{ $invoice->quotation->client->state }}</td>
                                        </tr>
                                        <tr>
                                            <th>Services</th>
                                            <td>
                                                <table style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Service</th>
                                                            <th>Quantity</th>
                                                            <th>Price (RM)</th>
                                                            <th>Amount (RM)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($invoice->quotation->items as $index => $item)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $item->service_name }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                                                <td>{{ number_format($item->subtotal, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" style="text-align: right;"><strong>Sub
                                                                    Total:</strong></td>
                                                            <td style="text-align: right;">RM
                                                                {{ number_format($invoice->quotation->items->sum('subtotal'), 2) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" style="text-align: right;">
                                                                <strong>Mileage:</strong></td>
                                                            <td style="text-align: right;">RM
                                                                {{ number_format($invoice->quotation->mileage, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" style="text-align: right;">
                                                                <strong>Discount:</strong></td>
                                                            <td style="text-align: right;">RM
                                                                {{ number_format($invoice->quotation->discount, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" style="text-align: right;"><strong>Grand
                                                                    Total:</strong></td>
                                                            <td style="text-align: right;"><strong>RM
                                                                    {{ number_format($invoice->quotation->final_price, 2) }}</strong>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $invoice->created_at->format('d-m-Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{ $invoice->updated_at->format('d-m-Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Invoice Status</th>
                                            <td>{{ $invoice->status_label }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <a href="{{ route('invoices.download_pdf', $invoice->id) }}" class="btn btn-primary"
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
