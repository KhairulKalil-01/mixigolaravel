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
                                <h4>Department Details</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" style="width:100%">
                                    <tbody>
                                        <tr>
                                            <th>Agent Name</th>
                                            <td>{{ $agent->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>TIN Number (Tax Identification Number)</th>
                                            <td>{{ $agent->tax_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>Company Name</th>
                                            <td>{{ $agent->company_name ?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <th>IC Number</th>
                                            <td>{{ $agent->ic_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $agent->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td>{{ $agent->mobileno }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bank</th>
                                            <td>{{ $agent->bank->bank_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bank Acc. Number</th>
                                            <td>{{ $agent->bank_acc_no ?? 'N/A' }}</td>
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
