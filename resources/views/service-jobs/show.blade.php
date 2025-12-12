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
                                <h4>Job Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Invoice</th>
                                            <td>{{ $serviceJob->invoice->invoice_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Name</th>
                                            <td>{{ $serviceJob->invoice->client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Phone</th>
                                            <td>{{ $serviceJob->invoice->client->mobileno }}</td>
                                        </tr>
                                        <tr>
                                            <th>Patient</th>
                                            <td>{{ $serviceJob->patient->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Person In-charge</th>
                                            <td>{{ $serviceJob->caregiver->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $serviceJob->start_datetime->format('Y-m-d') }}</td>
                                            <td>{{ $serviceJob->end_datetime->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Time</th>
                                            <th>End Time</th>

                                        </tr>
                                        <tr>
                                            <td>{{ $serviceJob->start_datetime->format('H:i') }}</td>
                                            <td>{{ $serviceJob->end_datetime->format('H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Duration</th>
                                            <td>
                                                {{ $serviceJob->start_datetime->diffInMinutes($serviceJob->end_datetime)/60 }} hours
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Service Price</th>
                                            <td>{{ $serviceJob->service_price }}</td>
                                        </tr>
                                        <tr>
                                            <th>Price Per Hour</th>
                                            <td>{{ $serviceJob->price_per_hour }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $serviceJob->status_label }}</td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td>{{ $serviceJob->remarks }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
