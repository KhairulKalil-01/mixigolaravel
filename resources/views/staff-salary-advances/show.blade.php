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
                                <h4>Salary Advance Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Staff Name</th>
                                            <td>
                                                {{ $advance->staff->full_name ?? 'N/A' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Amount</th>
                                            <td>
                                                RM {{ number_format($advance->amount, 2) }}
                                            </td>
                                        </tr>

                                        {{--  <tr>
                                            <th> Description</th>
                                            <td> {{ $advance->description }}</td>
                                        </tr> --}}

                                        <tr>
                                            <th>Request Reason</th>
                                            <td>{{ $advance->request_reason }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $advance->status_label }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approval By</th>
                                            <td>{{ $advance->approvedByUser?->staff?->full_name ?? 'No Approval Yet' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Approval at</th>
                                            <td>
                                                {{ $advance->approved_at ?? 'N/A' }}
                                            </td>
                                        </tr>
                                         <tr>
                                            <th>Approval Remarks</th>
                                            <td>
                                                {{ $advance->approval_remarks }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <a href={{ route('staff-overtimes.index') }} class="btn btn-secondary">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
