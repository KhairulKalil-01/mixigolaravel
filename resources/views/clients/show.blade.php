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
                                    <h4>Client Details</h4>

                                    <p><strong>Name:</strong> {{ $client->name }}</p>
                                    <p><strong>IC Number:</strong> {{ $client->ic_num }}</p>
                                    <p><strong>Email:</strong> {{ $client->email }}</p>
                                    <p><strong>Mobile:</strong> {{ $client->mobileno }}</p>
                                    <p><strong>Address:</strong> {{ $client->address }}</p>
                                    <p><strong>City:</strong> {{ $client->city }}</p>

                                    <hr>

                                    <h4>Related Patients</h4>

                                    @if ($client->patients->isEmpty())
                                        <p>No patients linked to this client.</p>
                                    @else
                                        <ul>
                                            @foreach ($client->patients as $patient)
                                                <li>{{ $patient->name }} (Condition: {{ $patient->condition_description }})</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
