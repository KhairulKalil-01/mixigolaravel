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
                                <h4>Refund Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Refund Number</th>
                                            <td>{{ $refund->refund_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Credit Note Number</th>
                                            <td>{{ $refund->creditNote->credit_note_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Invoice</th>
                                            <td>{{ $refund->invoice->invoice_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Name</th>
                                            <td>{{ $refund->invoice->client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Phone</th>
                                            <td>{{ $refund->invoice->client->mobileno }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>{{ $refund->amount }}</td>
                                        </tr>
                                        <tr>
                                            <th>Refund Date</th>
                                            <td>{{ $refund->refund_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td>{{ $refund->remarks }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <a href="{{ route('refunds.download_pdf', $refund->id) }}" class="btn btn-primary"
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
