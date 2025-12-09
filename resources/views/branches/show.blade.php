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
                                <h4>Branch Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Branch Name</th>
                                            <td>{{ $branch->branch_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $branch->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $branch->mobileno }}</td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td>{{ $branch->city }}</td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>{{ $branch->state }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $branch->address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
