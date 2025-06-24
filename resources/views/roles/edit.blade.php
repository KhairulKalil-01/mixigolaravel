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
                                <h4>Edit Role</h4>
                            </div>
                            <div class="card-body">
                                @include('roles.partials.form',[
                                    'action' =>route('roles.update', $role->id),
                                    'method' => 'PUT',
                                    'role' => $role
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
