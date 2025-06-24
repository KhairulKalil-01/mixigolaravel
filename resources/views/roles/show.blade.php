@extends('layouts.app')

@section('content')
<div class="themebody-wrap">
    <div class="theme-body common-dash" data-simplebar>
        <div class="custom-container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Role Details</h4>
                        </div>
                        <div class="card-body">
                            <!-- Role Name -->
                            <div class="mb-4">
                                <strong>Role Name:</strong>
                                <p>{{ $role->name }}</p>
                            </div>

                            <!-- Permissions Grouped by Module -->
                            <div class="mb-4">
                                <strong>Assigned Permissions:</strong>

                                @foreach ($modules as $module)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <strong>{{ $module->name }}</strong>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $modulePermissionIds = $module->permissions->pluck('id')->toArray();
                                                $assignedPermissionIds = $role->permissions->pluck('id')->toArray();
                                                $matchedPermissions = array_intersect($modulePermissionIds, $assignedPermissionIds);
                                            @endphp

                                            @if (count($matchedPermissions) > 0)
                                                <ul>
                                                    @foreach ($module->permissions as $permission)
                                                        @if (in_array($permission->id, $assignedPermissionIds))
                                                            <li>{{ $permission->name }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p><em>No permissions assigned in this module.</em></p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Back Button -->
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back to Roles</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
