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
                                    <h4>Staff Details</h4>
                                    <p><strong>Name:</strong> {{ $staff->full_name }}</p>
                                    <p><strong>Phone number:</strong> {{ $staff->mobileno }}</p>
                                    <p><strong>Email:</strong> {{ $staff->user?->email }}</p>
                                    <p><strong>Ic Num:</strong> {{ $staff->ic_num }}</p>
                                    <p><strong>Passport:</strong> {{ $staff->passport }}</p>
                                    <p><strong>Join Date:</strong> {{ $staff->joining_date }}</p>
                                    <p><strong>Gender:</strong> {{ $staff->sex }}</p>
                                    <p><strong>Religion:</strong> {{ $staff->religion }}</p>
                                    <p><strong>Marital Status:</strong> {{ $staff->marital_status }}</p>
                                    <p><strong>Current Address:</strong> {{ $staff->present_address }}</p>
                                    <p><strong>Permanent Address:</strong> {{ $staff->permanent_address }}</p>
                                    <p><strong>Emergency Contact:</strong> {{ $staff->emergency_contact }}</p>
                                    <p><strong>Emergency Contact Phone:</strong> {{ $staff->emergency_phone_no }}</p>
                                    <p><strong>System Role:</strong></p>
                                    <ul>
                                        @foreach ($staff->user?->getRoleNames() ?? [] as $role)
                                            <li><p>{{ $role }}</p></li>
                                        @endforeach
                                    </ul>
                                    <hr>

                                    {{-- <h5>Permissions</h5>
                                    <ul>
                                        @foreach ($staff->getAllPermissions() as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul> --}}
                                </div>
                                <a href="{{ route('staff.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
