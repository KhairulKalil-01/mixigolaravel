@extends('layouts.app')

@section('content')
    <div class="themebody-wrap">
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Client</h4>
                            </div>
                            <div class="card-body">
                                @include('clients.partials.form', [
                                    'action' => route('clients.update', $client->id),
                                    'method' => 'PUT',
                                    'client' => $client,
                                    'patients' => $patients,
                                    'clientPatientIds' => $clientPatientIds,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
