<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Name -->
    <div class="form-group">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $client->name ?? '') }}" required>
    </div>

    <!-- Assign Patient -->
    <div class="form-group mt-3">
        <label>Assign Patients</label>
        <select name="patients[]" class="form-control" multiple>
            @foreach ($patients as $patient)
                <option value="{{ $patient->id }}"
                    {{ in_array($patient->id, $clientPatientIds ?? []) ? 'selected' : '' }}>
                    {{ $patient->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- IC Number -->
    <div class="form-group mt-3">
        <label class="form-label">IC Number</label>
        <input type="text" name="ic_num" class="form-control" value="{{ old('ic_num', $client->ic_num ?? '') }}">
    </div>

    <div class="form-group mt-3">
        <label class="form-label">Gender <span class="text-danger">*</span></label>
        <select name="sex" class="form-control" required>
            <option value="">-- Select Gender --</option>
            <option value="Male" {{ old('sex', $client->sex ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('sex', $client->sex ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <!-- Mobile Number -->
    <div class="form-group mt-3">
        <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
        <input type="text" name="mobileno" class="form-control"
            value="{{ old('mobileno', $client->mobileno ?? '') }}" required>
    </div>

    <!-- Email -->
    <div class="form-group mt-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $client->email ?? '') }}">
    </div>

    <!-- Address -->
    <div class="form-group mt-3">
        <label class="form-label">Address <span class="text-danger">*</span></label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $client->address ?? '') }}"
            required>
    </div>

    <!-- City -->
    <div class="form-group mt-3">
        <label class="form-label">City <span class="text-danger">*</span></label>
        <input type="text" name="city" class="form-control" value="{{ old('city', $client->city ?? '') }}"
            required>
    </div>

    <!-- State -->
    <div class="form-group mt-3">
        <label class="form-label">State <span class="text-danger">*</span></label>
        <input type="text" name="state" class="form-control" value="{{ old('state', $client->state ?? '') }}"
            required>
    </div>

    <!-- Is Active -->
    <div class="form-group mt-3">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                {{ old('is_active', $client->is_active ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            {{ $method === 'PUT' ? 'Update' : 'Create' }} Client
        </button>
    </div>
</form>
