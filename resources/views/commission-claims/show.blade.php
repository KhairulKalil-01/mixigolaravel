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
                                                {{ $commissionClaim->claimer_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Claimer Type</th>
                                            <td>
                                                {{ $commissionClaim->claimer_type }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Invoice</th>
                                            <td>
                                                {{ $commissionClaim->invoice->invoice_number ?? 'N/A' }} - 
                                                {{ $commissionClaim->invoice->client->name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Invoice Amount</th>
                                            <td>
                                                RM {{ number_format($commissionClaim->invoice->total_amount ?? 0,2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Commission Rate</th>
                                            <td>
                                                {{ number_format($commissionClaim->commission_rate ?? 0,2) }} %
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Commission Amount</th>
                                            <td>
                                                RM {{ number_format($commissionClaim->amount,2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>
                                                {{  $commissionClaim->payment_method ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Submission Remarks</th>
                                            <td> {{ $commissionClaim->submission_remarks }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $commissionClaim->status_label }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                              <a href={{ route('commission-claims.index') }} class="btn btn-secondary">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
