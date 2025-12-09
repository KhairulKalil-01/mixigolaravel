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
                                <h4>Staff Advance Approval</h4>
                            </div>
                            <div class="card-body">
                                @include('staff-salary-advance-approvals.partials.form',[
                                    'action' =>route('staff-salary-advance-approvals.update', $advance->id),
                                    'method' => 'PUT',
                                    'advance' => $advance
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
