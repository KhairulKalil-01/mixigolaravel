@extends('layouts.app')

@section('styles')
    @include('partials.datatables.css')
@endsection

@section('content')
    <div class="themebody-wrap">
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Staff Payroll Batches</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <button id="createPayrollBtn" class="btn btn-primary">
                                        value =  {{ $test }}
                                    </button>
                                </div>
                                <hr>

                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @include('partials.datatables.js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
