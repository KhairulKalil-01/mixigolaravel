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
                                <h4>Edit Credit Note</h4>
                            </div>
                            <div class="card-body">
                                @include('credit-notes.partials.form', [
                                    'action' => route('credit-notes.update', $credit_note->id),
                                    'method' => 'PUT',
                                    'credit_note' => $credit_note,
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
