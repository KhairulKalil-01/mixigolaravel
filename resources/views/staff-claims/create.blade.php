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
                                <h4>Staff Claim Form</h4>
                            </div>
                            <div class="card-body">
                                @include('staff-claims.partials.form', [
                                    'action' => route('staff-claims.store'),
                                    'method' => 'POST',
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
