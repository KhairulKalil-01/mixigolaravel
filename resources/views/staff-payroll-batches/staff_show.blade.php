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
                                <h4>Payslip {{ \Carbon\Carbon::create()->month($batch->month)->format('F') }} (
                                    {{ $batch->period_start->format('d M Y') }} - {{ $batch->period_end->format('d M Y') }})
                                </h4>
                            </div>
                            <div class="card-body">
                                @php
                                    $earnings = $payroll->items->where('type', 1)->values();
                                    $deductions = $payroll->items->where('type', 2)->values();
                                    $maxRows = max($earnings->count(), $deductions->count());
                                @endphp

                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><b>Name:</b> {{ $payroll->staff->full_name }}</td>
                                            <td colspan="2"><b>EPF Number:</b>
                                                {{ $payroll->staff->epf_no }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>IC No:</b> {{ $payroll->staff->ic_num }}</td>
                                            <td colspan="2"><b>Base Salary:</b> RM
                                                {{ number_format($payroll->staff->currentSalaryStructure->base_salary, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Department:</b>
                                                {{ $payroll->staff->department->department_name }}</td>
                                            <td colspan="2"><b>Income Tax Number:</b>
                                                {{ $payroll->staff->income_tax_no }}</td>
                                        </tr>

                                        <tr>
                                            <th colspan="2" style="text-align:center; background-color:#56a9e5;">Earnings
                                            </th>
                                            <th colspan="2" style="text-align:center; background-color:#eba57d;">
                                                Deductions</th>
                                        </tr>
                                        <th style="background-color:#d5cdcd;">Description</th>
                                        <th style="background-color:#d5cdcd;">Amount</th>
                                        <th style="background-color:#d5cdcd;">Description</th>
                                        <th style="background-color:#d5cdcd;">Amount</th>
                                        </tr>

                                        @for ($i = 0; $i < $maxRows; $i++)
                                            <tr>
                                                <td>{{ $earnings[$i]->description ?? '' }}</td>
                                                <td>
                                                    @if (isset($earnings[$i]))
                                                        RM {{ number_format($earnings[$i]->amount, 2) }}
                                                    @endif
                                                </td>
                                                <td>{{ $deductions[$i]->description ?? '' }}</td>
                                                <td>
                                                    @if (isset($deductions[$i]))
                                                        RM {{ number_format($deductions[$i]->amount, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endfor

                                        <tr>
                                            <th>Gross Earnings</th>
                                            <td>RM {{ number_format($earnings->sum('amount'), 2) }}</td>
                                            <th>Total Deductions</th>
                                            <td>RM {{ number_format($deductions->sum('amount'), 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="1">Net Pay</th>

                                        </tr>
                                        <tr>
                                            <td colspan="1"><b>RM {{ number_format($payroll->net_salary, 2) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                @if ($batch->status == 1)
                                    <a href="{{ route('payrolls.download_pdf', [$payroll->id, $batch->id]) }}"
                                        class="btn btn-primary" target="_blank">
                                        Download Payslip
                                    </a>
                                @endif
                                @if ($batch->status !== 1)
                                    @can('Edit Staff Payroll Batch')
                                        <a href=" {{ route('staff-payroll-batches.staff_edit', [$batch->id, $payroll->id]) }}"
                                            class="btn btn-primary viewBtn">Edit</a>
                                    @endcan
                                @endif
                                <a href="{{ route('staff-payroll-batches.show', $batch->id) }}"
                                    class="btn btn-secondary">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
