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
                                <h4>Staff Overtime Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Staff Name</th>
                                            <td>
                                                {{ $overtime->staff->full_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Overtime Date</th>
                                            <td>
                                                {{ $overtime->start_time->format('Y-m-d') ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Start time</th>
                                            <td>{{ $overtime->start_time }}</td>
                                        </tr>
                                        <tr>
                                            <th>End time</th>
                                            <td>{{ $overtime->end_time }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>
                                                RM {{ number_format($overtime->amount, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Hour</th>
                                            <td>
                                                {{ $overtime->hours }}-hour
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $overtime->status_label }}</td>
                                        </tr>
                                         <tr>
                                            <th>Approval By</th>
                                            <td>{{ $overtime->approvedByUser?->staff?->full_name ?? 'No Approval Yet' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approved at</th>
                                            <td>
                                                {{ $overtime->approved_at ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <a href={{ route('staff-overtime-approvals.index') }} class="btn btn-secondary">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
