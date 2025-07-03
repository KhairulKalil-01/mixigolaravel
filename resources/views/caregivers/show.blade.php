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
                                <h4>Caregiver Details</h4>
                            </div>
                            <div class="card-body">
                                <p><strong>Branch:</strong> {{ $caregiver->branch->branch_name }}</p>
                                <p><strong>Name:</strong> {{ $caregiver->name }}</p>
                                <p><strong>Nationality:</strong> {{ $caregiver->nationality }}</p>
                                <p><strong>Gender:</strong> {{ $caregiver->sex }}</p>
                                <p><strong>Employment Type:</strong> {{ $caregiver->employment_type_label }}</p>
                                <p><strong>Employment Date:</strong> {{ $caregiver->employment_date }}</p>
                                <p><strong>IC Number:</strong> {{ $caregiver->ic_num }}</p>
                                <p><strong>Passport:</strong> {{ $caregiver->passport }}</p>
                                <p><strong>Email:</strong> {{ $caregiver->email }}</p>
                                <p><strong>Mobile:</strong> {{ $caregiver->mobileno }}</p>
                                <p><strong>Rate Per Hour:</strong> RM {{ number_format($caregiver->rate_per_hour, 2) }}</p>
                                <p><strong>Bank Name:</strong> {{ $caregiver->bank->bank_name }}</p>
                                <p><strong>Bank Number:</strong> {{ $caregiver->bank_num }}</p>
                                <p><strong>Status:</strong> {{ $caregiver->is_active }}</p>
                                <p><strong>Qualification:</strong> {{ $caregiver->qualification }}</p>
                                <p><strong>Emergency Contact:</strong> {{ $caregiver->emergency_name }}</p>
                                <p><strong>Emergency Number:</strong> {{ $caregiver->emergency_no }}</p>
                                <p><strong>Current Address:</strong> {{ $caregiver->current_address }}</p>
                                <p><strong>Current City:</strong> {{ $caregiver->current_city }}</p>
                                <p><strong>Current State:</strong> {{ $caregiver->current_state }}</p>
                                <p><strong>Permanent Address:</strong> {{ $caregiver->permanent_address }}</p>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
