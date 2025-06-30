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
                                    <h4>Patient Details</h4>

                                    <p><strong>Name:</strong> {{ $patient->name }}</p>
                                    <p><strong>IC Number:</strong> {{ $patient->ic_num }}</p>
                                    <p><strong>Mobile:</strong> {{ $patient->mobileno }}</p>
                                    <p><strong>Address:</strong> {{ $patient->address }}</p>
                                    <p><strong>City:</strong> {{ $patient->city }}</p>
                                    <p><strong>Branch:</strong> {{ $patient->branch }}</p>

                                    <hr>

                                    <h4>Related Clients</h4>

                                    @if ($patient->clients->isEmpty())
                                        <p>No clients linked to this patient.</p>
                                    @else
                                        <ul>
                                            @foreach ($patient->clients as $client)
                                                <li>{{ $client->name }} (IC: {{ $client->ic_num }})</li>
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
