<form action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" method="POST">
    @csrf
    @if (isset($role))
        @method('PUT')
    @endif

    <div class="form-group">
        <label>Role Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', isset($role) ? $role->name : '') }}"
            required>
    </div>

    <div class="form-group">
        <label class="form-label">Guard Name</label>
        <select class="form-control" name="guard_name" required>
            <option value="web" {{ old('guard_name', $role->guard_name ?? '') == 'web' ? 'selected' : '' }}>web
            </option>
        </select>
    </div>

    <div class="form-group mt-3">
        <label class="form-label">Assign Permissions</label><br>

        @foreach ($modules as $module)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>{{ $module->name }}</strong>
                </div>
                <div class="card-body">
                    @foreach ($module->permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                class="form-check-input"
                                {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>


    <button type="submit" class="btn btn-primary mt-4">
        {{ isset($role) ? 'Update Role' : 'Create Role' }}
    </button>
</form>
