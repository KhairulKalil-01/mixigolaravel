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
                                <h4>Create Client</h4>
                            </div>
                            <div class="card-body">
                                @include('clients.partials.form', [
                                    'action' => route('clients.store'),
                                    'method' => 'POST',
                                    'client' => null,
                                    'patients' => $patients,
                                    'clientPatientIds' => null,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
