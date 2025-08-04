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
                                <h4>Credit Note Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Credit Note Number</th>
                                            <td>{{ $credit_note->credit_note_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Invoice Number</th>
                                            <td>{{ $credit_note->invoice->invoice_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Name</th>
                                            <td>{{ $credit_note->client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Phone</th>
                                            <td>{{ $credit_note->client->mobileno }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>{{ $credit_note->credit_amount}}</td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>{{ $credit_note->credit_note_date }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $credit_note->status_label }}</td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td>{{ $credit_note->remarks }}</td>
                                        </tr>
                                        <tr>
                                            <th>Reason</th>
                                            <td>{{ $credit_note->reason_type }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <a href="{{ route('credit-notes.download_pdf', $credit_note->id) }}" class="btn btn-primary"
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
