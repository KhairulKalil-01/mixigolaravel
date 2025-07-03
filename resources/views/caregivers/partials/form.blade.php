<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Name -->
    <div class="form-group">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $caregiver->name ?? '') }}"
            required>
    </div>

    <!-- Sex -->
    <div class="form-group mt-3">
        <label class="form-label">Gender <span class="text-danger">*</span></label>
        <select name="sex" class="form-control" required>
            <option value="">-- Select Gender --</option>
            <option value="Male" {{ old('sex', $caregiver->sex ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('sex', $caregiver->sex ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <!-- Assign Branch -->
    <div class="form-group mt-3">
        <label class="form-label">Branch<span class="text-danger">*</span></label>
        <select name="branch_id" class="form-control" required>
            <option value="">-- Select Branch --</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ old('branch_id', $caregiver->branch_id ?? null) == $branch->id ? 'selected' : '' }}>
                    {{ $branch->branch_name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- IC Number -->
    <div class="form-group mt-3">
        <label class="form-label">IC Number</label>
        <input type="text" name="ic_num" class="form-control" value="{{ old('ic_num', $caregiver->ic_num ?? '') }}">
    </div>

    <!-- Nationality -->
    <div class="form-group mt-3">
        <label class="form-label">Nationality</label>
        <select name="nationality" class="form-control">
            <option value="">-- Select Nationality --</option>
            <option value="Malaysia"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Malaysia' ? 'selected' : '' }}>Malaysia
            </option>
            <option value="Indonesia"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Indonesia' ? 'selected' : '' }}>Indonesia
            </option>
            <option value="Pakistan"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Pakistan' ? 'selected' : '' }}>Pakistan
            </option>
            <option value="Bangladesh"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh
            </option>
            <option value="Philipine"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Philipine' ? 'selected' : '' }}>Philipine
            </option>
            <option value="Sri Lanka"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka
            </option>
            <option value="Thailand"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Thailand' ? 'selected' : '' }}>Thailand
            </option>
            <option value="Myanmar"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
            <option value="Brunei"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Brunei' ? 'selected' : '' }}>Brunei</option>
            <option value="Vietnam"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
            <option value="Africa"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Africa' ? 'selected' : '' }}>Africa</option>
            <option value="Others"
                {{ old('nationality', $caregiver->nationality ?? '') == 'Others' ? 'selected' : '' }}>Others</option>
        </select>
    </div>


    <!-- Passport -->
    <div class="form-group mt-3">
        <label class="form-label">Passport</label>
        <input type="text" name="passport" class="form-control"
            value="{{ old('passport', $caregiver->passport ?? '') }}">
    </div>

    <!-- Email -->
    <div class="form-group mt-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $caregiver->email ?? '') }}">
    </div>

    <!-- Mobile Number -->
    <div class="form-group mt-3">
        <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
        <input type="text" name="mobileno" class="form-control"
            value="{{ old('mobileno', $caregiver->mobileno ?? '') }}" required>
    </div>

    <!-- Rate Per Hour -->
    <div class="form-group mt-3">
        <label class="form-label">Rate Per Hour <span class="text-danger">*</span></label>
        <input type="number" name="rate_per_hour" class="form-control"
            value="{{ old('rate_per_hour', $caregiver->rate_per_hour ?? '') }}" min="0" required>
    </div>

    <!-- Bank -->
    <div class="form-group mt-3">
        <label class="form-label">Bank</label>
        <select name="bank_list_id" class="form-control" required>
            <option value="">-- Select Bank --</option>
            @foreach ($banks as $bank)
                <option value="{{ $bank->id }}"
                    {{ old('bank_list_id', $caregiver->bank_list_id ?? null) == $bank->id ? 'selected' : '' }}>
                    {{ $bank->bank_name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Bank Account Number -->
    <div class="form-group mt-3">
        <label class="form-label">Bank Account Number <span class="text-danger">*</span></label>
        <input type="text" name="bank_num" class="form-control"
            value="{{ old('bank_num', $caregiver->bank_num ?? '') }}" required>
    </div>

    <!-- Employement Type -->
    <div class="form-group mt-3">
        <label class="form-label">Employment Type</label>
        <select name="employment_type" class="form-control" required>
            <option value="">-- Select Employment Type --</option>
            <option value="1"
                {{ old('employment_type', $caregiver->employment_type ?? '') == '1' ? 'selected' : '' }}>Full Time
            </option>
            <option value="2"
                {{ old('employment_type', $caregiver->employment_type ?? '') == '2' ? 'selected' : '' }}>Part Time
            </option>
        </select>
    </div>

    <!-- Employement Date -->
    <div class="form-group mt-3">
        <label class="form-label">Employment Date</label>
        <input type="date" name="employment_date" class="form-control"
            value="{{ old('employment_date', $caregiver->employment_date ?? '') }}">
    </div>

    <!-- Qualification -->
    <div class="form-group mt-3">
        <label class="form-label">Qualification</label>
        <select name="qualification" class="form-control">
            <option value="">-- Select Qualification --</option>
            <option value="PMR"
                {{ old('qualification', $caregiver->qualification ?? '') == 'PMR' ? 'selected' : '' }}>PMR</option>
            <option value="SPM"
                {{ old('qualification', $caregiver->qualification ?? '') == 'SPM' ? 'selected' : '' }}>SPM</option>
            <option value="Diploma"
                {{ old('qualification', $caregiver->qualification ?? '') == 'Diploma' ? 'selected' : '' }}>Diploma
            </option>
            <option value="Degree"
                {{ old('qualification', $caregiver->qualification ?? '') == 'Degree' ? 'selected' : '' }}>Degree
            </option>
            <option value="Master"
                {{ old('qualification', $caregiver->qualification ?? '') == 'Master' ? 'selected' : '' }}>Master
            </option>
            <option value="PhD"
                {{ old('qualification', $caregiver->qualification ?? '') == 'PhD' ? 'selected' : '' }}>PhD</option>
        </select>
    </div>


    <!-- Emergency Contact -->
    <div class="form-group mt-3">
        <label class="form-label">Emergency Contact Name<span class="text-danger">*</span></label>
        <input type="text" name="emergency_name" class="form-control"
            value="{{ old('emergency_name', $caregiver->emergency_name ?? '') }}" required>
    </div>

    <!-- Emergency Contact -->
    <div class="form-group mt-3">
        <label class="form-label">Emergency Contact Number<span class="text-danger">*</span></label>
        <input type="text" name="emergency_no" class="form-control"
            value="{{ old('emergency_no', $caregiver->emergency_no ?? '') }}" required>
    </div>

    <!-- Current Address -->
    <div class="form-group mt-3">
        <label class="form-label">Current Address <span class="text-danger">*</span></label>
        <input type="text" name="current_address" class="form-control"
            value="{{ old('current_address', $caregiver->current_address ?? '') }}" required>
    </div>

    <!-- Current City -->
    <div class="form-group mt-3">
        <label class="form-label">Current City <span class="text-danger">*</span></label>
        <input type="text" name="current_city" class="form-control"
            value="{{ old('current_city', $caregiver->current_city ?? '') }}" required>
    </div>

    <!-- Current State -->
    <div class="form-group mt-3">
        <label class="form-label">Current State <span class="text-danger">*</span></label>
        <input type="text" name="current_state" class="form-control"
            value="{{ old('current_state', $caregiver->current_state ?? '') }}" required>
    </div>

    <!-- Permanent Address -->
    <div class="form-group mt-3">
        <label class="form-label">Permanent Address <span class="text-danger">*</span></label>
        <input type="text" name="permanent_address" class="form-control"
            value="{{ old('permanent_address', $caregiver->permanent_address ?? '') }}" required>
    </div>


    <!-- Is Active -->
    <div class="form-group mt-3">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                {{ old('is_active', $caregiver->is_active ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>


    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            {{ $method === 'PUT' ? 'Update' : 'Create' }} caregiver
        </button>
    </div>
</form>
