<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Name -->
    <div class="form-group">
        <label class="form-label">Username<span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    </div>


    <!-- Email -->
    <div class="form-group mt-3">
        <label class="form-label">Email<span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}"
            required>
    </div>

    <!-- Password -->
    <div class="form-group mt-3">
        <label class="form-label">Password {!! $method !== 'PUT' ? '<span class="text-danger">*</span>' : '' !!}</label>
        <input type="password" name="password" class="form-control" {{ $method !== 'PUT' ? 'required' : '' }}>
    </div>

    <!-- Role -->
    <div class="form-group mt-3">
        <label class="form-label">Roles</label>
        <div>
            @foreach ($roles as $role)
                <div class="form-check">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input"
                        id="role_{{ $role->id }}"
                        {{ isset($user) && $user->hasRole($role->name) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            {{ $method === 'PUT' ? 'Update' : 'Create' }} User
        </button>
    </div>
</form>
