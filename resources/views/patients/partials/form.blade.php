<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Name -->
    <div class="form-group">
        <label class="form-label">Patient Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $patient->name ?? '') }}" required>
    </div>

    <!-- Assign Client to the Patient -->
    <div class="form-group mt-3">
        <label class="form-label">Add client to this patient</label>
        <div class="d-flex flex-column gap-2">
            @foreach ($clients as $client)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="clients[]" value="{{ $client->id }}"
                        {{ in_array($client->id, $clientPatientIds ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        {{ $client->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <!-- IC Number -->
    <div class="form-group mt-3">
        <label class="form-label">IC Number</label>
        <input type="text" name="ic_num" class="form-control" value="{{ old('ic_num', $patient->ic_num ?? '') }}">
    </div>

    <div class="form-group mt-3">
        <label class="form-label">Gender <span class="text-danger">*</span></label>
        <select name="sex" class="form-control" required>
            <option value="">-- Select Gender --</option>
            <option value="Male" {{ old('sex', $patient->sex ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('sex', $patient->sex ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <!-- Mobile Number -->
    <div class="form-group mt-3">
        <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
        <input type="text" name="mobileno" class="form-control"
            value="{{ old('mobileno', $patient->mobileno ?? '') }}" required>
    </div>

    <!-- Address -->
    <div class="form-group mt-3">
        <label class="form-label">Address <span class="text-danger">*</span></label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $patient->address ?? '') }}"
            required>
    </div>

    <!-- City -->
    <div class="form-group mt-3">
        <label class="form-label">City <span class="text-danger">*</span></label>
        <input type="text" name="city" class="form-control" value="{{ old('city', $patient->city ?? '') }}"
            required>
    </div>

    <!-- State -->
    <div class="form-group mt-3">
        <label class="form-label">State <span class="text-danger">*</span></label>
        <input type="text" name="state" class="form-control" value="{{ old('state', $patient->state ?? '') }}"
            required>
    </div>

    <!-- Is Active -->
    <div class="form-group mt-3">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                {{ old('is_active', $patient->is_active ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            {{ $method === 'PUT' ? 'Update' : 'Create' }} Patient
        </button>
    </div>
</form>
