@extends('layouts.app')

@section('content')
    <div class="themebody-wrap">
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Staff</h4>
                            </div>
                            <div class="card-body">
                                @include('staff.partials.form', [
                                    'action' => route('staff.update', $staff->id),
                                    'method' => 'PUT',
                                    'staff' => $staff,
                                    'branches' => $branches ?? [],
                                    'departments' => $departments ?? [],
                                    'banks' => $banks ?? []
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
