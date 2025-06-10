@extends('layouts.app') {{-- or your layout --}}

@section('content')
    <div class="themebody-wrap">
        <div class="container">
            <h1>Branches</h1>
            <a href="{{ route('branches.create') }}" class="btn btn-primary mb-3">Add New Branch</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Mobile No</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($branches as $branch)
                        <tr>
                            <td>{{ $branch->branch_name }}</td>
                            <td>{{ $branch->city }}</td>
                            <td>{{ $branch->state }}</td>
                            <td>{{ $branch->mobileno }}</td>
                            <td>{{ $branch->email }}</td>
                            <td>
                                <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <!-- Optional: delete button -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No branches found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
@endsection
