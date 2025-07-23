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
                                <h4>Create Credit Note</h4>
                            </div>
                            <div class="card-body">
                                @include('credit-notes.partials.form', [
                                    'action' => route('credit-notes.store'),
                                    'method' => 'POST',
                                    'credit_note' => null,
                                    'invoices' => $invoices,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
