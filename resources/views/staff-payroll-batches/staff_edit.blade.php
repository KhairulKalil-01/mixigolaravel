@extends('layouts.app')

@section('content')
    <div class="themebody-wrap">
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Staff Payroll</h4>
                            </div>
                            <div class="card-body">
                                @include('staff-payroll-batches.partials.staff-payroll-form', [
                                    'action' => route('staff-payroll-batches.staff_update', [$batch->id, $payroll->id]),
                                    'method' => 'PUT',
                                    'batch' => $batch,
                                    'payroll' => $payroll,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
