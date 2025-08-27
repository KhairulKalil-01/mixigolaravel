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
                            <div class="card-body">
                                <div class="container">
                                    <h4>Current Salary Structure</h4>
                                    <br>
                                    <p><strong>Staff: </strong> {{ $current_salary->staff->full_name }}</p>
                                    <p><strong>Branch: </strong> {{ $current_salary->staff->branch->branch_name }}</p>
                                    <p><strong>Base Salary: </strong> {{ $current_salary->base_salary }}</p>
                                    <p><strong>Employee EPF: </strong> {{ $current_salary->epf_employee }}%</p>
                                    <p><strong>Employer EPF: </strong> {{ $current_salary->epf_employer }}%</p>
                                    <p><strong>Socso Employee: </strong> {{ $current_salary->socso_employee }}</p>
                                    <p><strong>Socso Employer: </strong> {{ $current_salary->socso_employer }}</p>

                                    <br>
                                    <a href="{{ route('salary-structures.index') }}" class="btn btn-secondary">Back</a>
                                    &nbsp;
                                    @can('Edit Salary Structure')
                                        <a href="{{ route('salary-structures.edit', $current_salary->id) }}"
                                            class="btn btn-primary">Edit</a>
                                    @endcan
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="container">
                                                <h5>Salary Structure History</h5>
                                                <div class="salary-history">
                                                    @forelse ($salary_history as $history)
                                                        <div
                                                            class="card mb-3 @if ($history->id === $current_salary->id) border-success @endif">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <h5 class="mb-1">Base Salary: RM
                                                                            {{ number_format($history->base_salary, 2) }}
                                                                        </h5>
                                                                        <p class="mb-1">EPF Employee:
                                                                            {{ $history->epf_employee }}%</p>
                                                                        <p class="mb-1">EPF Employer:
                                                                            {{ $history->epf_employer }}%</p>
                                                                    </div>
                                                                    <div class="text-end">
                                                                        <span class="badge bg-primary">
                                                                            From:
                                                                            {{ $history->effective_from->format('d-m-Y') }}
                                                                        </span>
                                                                        <span
                                                                            class="badge bg-{{ $history->effective_to ? 'secondary' : 'success' }}">
                                                                            To:
                                                                            {{ $history->effective_to ? $history->effective_to->format('d-m-Y') : 'Present' }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p class="text-muted">No salary history available.</p>
                                                    @endforelse
                                                </div>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
