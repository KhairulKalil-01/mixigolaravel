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
                                    <h4>Profile Details</h4>

                                    <p><strong>Name:</strong> {{ $user->staff->full_name }}</p>
                                    <p><strong>Phone number:</strong> {{ $user->staff->mobileno }}</p>
                                    <p><strong>Email:</strong> {{ $user->staff->user?->email }}</p>
                                    <p><strong>Ic Num:</strong> {{ $user->staff->ic_num }}</p>
                                    <p><strong>Passport:</strong> {{ $user->staff->passport }}</p>
                                    <p><strong>Join Date:</strong> {{ $user->staff->joining_date }}</p>
                                    <p><strong>Gender:</strong> {{ $user->staff->sex }}</p>
                                    <p><strong>Religion:</strong> {{ $user->staff->religion }}</p>
                                    <p><strong>Marital Status:</strong> {{ $user->staff->marital_status }}</p>
                                    <p><strong>Current Address:</strong> {{ $user->staff->present_address }}</p>
                                    <p><strong>Permanent Address:</strong> {{ $user->staff->permanent_address }}</p>
                                    <p><strong>Emergency Contact:</strong> {{ $user->staff->emergency_contact }}</p>
                                    <p><strong>Emergency Contact Phone:</strong> {{ $user->staff->emergency_phone_no }}</p>
                                    <br>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
