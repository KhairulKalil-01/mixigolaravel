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
                                <h4>Edit Salary Structure</h4>
                            </div>
                            <div class="card-body">
                                @include('salary-structures.partials.form', [
                                    'action' => route('salary-structures.update', $salary_structure->id),
                                    'method' => 'PUT',
                                    'salary_structure' => $salary_structure,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
