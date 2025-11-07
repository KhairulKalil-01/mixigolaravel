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
                                <h4>Commission {{ \Carbon\Carbon::create()->month($batch->month)->format('F') }} (
                                    {{ $batch->period_start->format('d M Y') }} - {{ $batch->period_end->format('d M Y') }})
                                </h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>Name:</b> {{ $record->staff->full_name ?? $record->externalAgent->name ?? '-' }}</td>
                                            <td><b>Claimer Type:</b> {{ $claimerType = $record->staff ? 'Staff' : 'External Agent'; }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="background-color:#d5cdcd;">Sales Invoice</th>
                                            <th style="background-color:#d5cdcd;">Description</th>
                                            <th style="background-color:#d5cdcd;">Invoice Amount</th>
                                            <th style="background-color:#d5cdcd;">Commission Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $record->commissionClaim->invoice->invoice_number ?? '-' }}</td>
                                            <td>{{ $record->description ?? '-'}}</td>
                                            <td >RM {{ number_format($record->commissionClaim->invoice->total_amount, 2) ?? '-' }}</td>
                                            <td>RM {{ number_format($record->amount,2) ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><b>Net Commission:</b></td>
                                            <td><b>RM {{ number_format($record->amount,2) ?? '-' }}</b></td>
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
