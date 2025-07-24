@extends('layouts.app')

@section('content')
    <div class="themebody-wrap">
        <!-- theme body start-->
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Create Refund</h4>
                            </div>
                            <div class="card-body">
                                @include('refunds.partials.form', [
                                    'action' => route('refunds.store'),
                                    'method' => 'POST',
                                    'refund' => null
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
