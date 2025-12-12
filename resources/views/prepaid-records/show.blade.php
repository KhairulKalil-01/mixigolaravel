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
                                <h4>Prepaid Service Record</h4>
                            </div>
                            <div class="custom-container">

                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered" style="width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <th>Invoice Number</th>
                                                            <td>
                                                                <a href="{{ route('invoices.show', $prepaidRecord->invoice_id) }}">{{ $prepaidRecord->invoice->invoice_number }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Client</th>
                                                            <td>
                                                                <a href="{{ route('clients.show', $prepaidRecord->invoice->client_id) }}">{{ $prepaidRecord->invoice->client->name }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Prepaid Status</th>
                                                            <td>{{ $prepaidRecord->status_label }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Address</th>
                                                            <td>{{ $prepaidRecord->invoice->client->address }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table table class="table table-bordered" style="width:100%">
                                                    <tbody>
                                                        <tr>
                                                            <th>Total Package Hour</th>
                                                            <th>Deducted Hour</th>
                                                            <th>Balance Hour</th>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ number_format($prepaidRecord->package_hour, 1) }}</td>
                                                            <td>{{ number_format($prepaidRecord->totalDeductedHour(), 1) }}
                                                            </td>
                                                            <td>{{ number_format($prepaidRecord->balanceHour(), 1) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- CHANGE TO DATATABLE WITH <<VIEW>> TO VIEW JOB, IN JOB THERE  WILL VIEW AND PRINT BUTTON (SERVICE RECEIPT)? --}}
                                <div class="col-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5>Service Records - Deductions</h5>
                                            <table class="table table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Actual Hour</th>
                                                        <th>Multiplier</th>
                                                        <th>Deducted Hour</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($prepaidRecord->prepaidDeductions as $record)
                                                        <tr>
                                                            <td>test {{-- {{ $record->service_job->date->format('Y-m-d') }} --}}</td>
                                                            <td>{{ $record->actual_hour }}</td>
                                                            <td>{{ number_format($record->multiplier, 1) }}</td>
                                                            <td>{{ number_format($record->deducted_hour, 1) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
