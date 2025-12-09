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
                                <h4>Edit Invoice</h4>
                            </div>
                            <div class="card-body">
                                @include('invoices.partials.form', [
                                    'action' => route('invoices.update', $invoice->id),
                                    'method' => 'PUT',
                                    'invoice' => $invoice,
                                    'quotations' =>$quotations,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
