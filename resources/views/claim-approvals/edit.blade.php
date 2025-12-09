@extends('layouts.app')

@section('content')
    <div class="themebody-wrap">
        <!-- theme body start-->
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Approve Claim</h4>
                            </div>
                            <div class="card-body">
                                @include('claim-approvals.partials.form',[
                                    'action' =>route('claim-approvals.update', $staffClaim->id),
                                    'method' => 'PUT',
                                    'staffClaim' => $staffClaim ?? null,
                                    'statuses' => $statuses ?? [],
                                    'paymentMethods' => $paymentMethods ?? [],
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
