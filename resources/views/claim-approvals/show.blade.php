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
                                <h4>Staff Claim Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Staff Name</th>
                                            <td>
                                                {{ $staffClaim->staff->full_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Claim Date</th>
                                            <td>
                                                {{ $staffClaim->claim_date ? $staffClaim->claim_date->format('d-m-Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>
                                                RM {{ number_format($staffClaim->amount, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>
                                                {{ $staffClaim->payment_method ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> Description</th>
                                            <td> {{ $staffClaim->description }}</td>
                                        </tr>

                                        <tr>
                                            <th>Claim Type</th>
                                            <td>{{ $staffClaim->claim_type }}</td>
                                        </tr>
                                        <tr>
                                            <th>File</th>
                                            <td>
                                                @if ($staffClaim->receipt_path)
                                                    @if (Str::endsWith($staffClaim->receipt_path, ['.jpg', '.jpeg', '.png']))
                                                        <img src="{{ asset('storage/' . $staffClaim->receipt_path) }}"
                                                            alt="Receipt" style="max-width: 200px; height: auto;">
                                                    @elseif(Str::endsWith($staffClaim->receipt_path, '.pdf'))
                                                        <a href="{{ asset('storage/' . $staffClaim->receipt_path) }}"
                                                            target="_blank">
                                                            View Receipt (PDF)
                                                        </a>
                                                    @endif
                                                @else
                                                    <span>No receipt uploaded</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $staffClaim->status_label }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approved Amount</th>
                                            <td>RM {{ $staffClaim->approved_amount }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approval Remarks</th>
                                            <td>{{ $staffClaim->remarks }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approval By</th>
                                            <td>{{ $staffClaim->approvedByUser?->staff?->full_name ?? 'No Approval Yet' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <a href={{ route('claim-approvals.index') }} class="btn btn-secondary">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
