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
                                <h4>Commission Claim Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Claimer Name</th>
                                            <td>
                                                {{ $commission_approval->claimer_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Claimer Type</th>
                                            <td>
                                                {{ $commission_approval->claimer_type }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Invoice</th>
                                            <td>
                                                {{ $commission_approval->invoice->invoice_number ?? 'N/A' }} - 
                                                {{ $commission_approval->invoice->client->name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Invoice Amount</th>
                                            <td>
                                                RM {{ number_format($commission_approval->invoice->total_amount ?? 0,2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Commission Rate</th>
                                            <td>
                                                {{ number_format($commission_approval->commission_rate ?? 0,2) }} %
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Commission Amount</th>
                                            <td>
                                                RM {{ number_format($commission_approval->amount,2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Submission Remarks</th>
                                            <td> {{ $commission_approval->submission_remarks }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $commission_approval->status_label }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approval Remarks</th>
                                            <td>{{ $commission_approval->approval_remarks }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                              <a href={{ route('commission-approvals.index') }} class="btn btn-secondary">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
