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
                                <h4>Commission Claim Form</h4>
                            </div>
                            <div class="card-body">
                                @include('commission-claims.partials.form', [
                                    'action' => route('commission-claims.store'),
                                    'method' => 'POST',
                                    'invoices' => $invoices,
                                    'staffs' => $staffs,
                                    'agents' => $agents,
                                    'claim' => null
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
