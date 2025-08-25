<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    {{-- Staff Information --}}
    <h5 class="mb-3">Staff Information</h5>
    <br>

    <!-- Full Name -->
    <div class="form-group">
        <label class="form-label">Full Name <span class="text-danger">*</span></label>
        <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $staff->full_name ?? '') }}"
            required>
    </div>

    <!-- Gender -->
    <div class="form-group">
        <label class="form-label">Gender<span class="text-danger">*</span></label>
        <select name="sex" id="sex" class="form-control" required>
            <option value="">-- Select Gender --</option>
            <option value="1" {{ old('sex', $staff->sex ?? '') == '1' ? 'selected' : '' }}>Male</option>
            <option value="2" {{ old('sex', $staff->sex ?? '') == '2' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <!-- Religion -->
    <div class="form-group">
        <label class="form-label">Religion</label>
        <select name="religion" id="religion" class="form-control" required>
            <option value="">-- Select Religion --</option>
            <option value="Islam" {{ old('religion', $staff->religion ?? '') == 'Islam' ? 'selected' : '' }}>Islam
            </option>
            <option value="Budha" {{ old('religion', $staff->religion ?? '') == 'Budha' ? 'selected' : '' }}>Budha
            </option>
            <option value="Hindu" {{ old('religion', $staff->religion ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu
            </option>
            <option value="Other" {{ old('religion', $staff->religion ?? '') == 'Other' ? 'selected' : '' }}>Other
            </option>
        </select>
    </div>

    <!-- Marital Status -->
    <div class="form-group">
        <label class="form-label">Marital Status</label>
        <select name="marital_status" id="marital_status" class="form-control" required>
            <option value="">-- Select Marital Status --</option>
            <option value="Married"
                {{ old('marital_status', $staff->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married
            </option>
            <option value="Single"
                {{ old('marital_status', $staff->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
            <option value="Divorced"
                {{ old('marital_status', $staff->marital_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced
            </option>
        </select>
    </div>


    <!-- IC Num -->
    <div class="form-group">
        <label class="form-label">IC number <span class="text-danger">*</span></label>
        <input type="text" name="ic_num" class="form-control" value="{{ old('ic_num', $staff->ic_num ?? '') }}"
            required>
    </div>

    <!-- Passport -->
    <div class="form-group ">
        <label class="form-label">Passport</label>
        <input type="text" name="passport" class="form-control"
            value="{{ old('passport', $staff->passport ?? '') }}">
    </div>

    <!-- Branch -->
    <div class="form-group ">
        <label class="form-label">Branch<span class="text-danger">*</span></label>
        <select name="branch_id" class="form-control" required>
            <option value="">-- Select Branch --</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ old('branch_id', $staff->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->branch_name }}
                </option>
            @endforeach
        </select>
    </div>


    <!-- Department -->
    <div class="form-group ">
        <label class="form-label">Department<span class="text-danger">*</span></label>
        <select name="department_id" class="form-control" required>
            <option value="">-- Select Department --</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}"
                    {{ old('department_id', $staff->department_id ?? '') == $department->id ? 'selected' : '' }}>
                    {{ $department->department_name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Join Date -->
    <div class="form-group ">
        <label class="form-label">Join Date<span class="text-danger">*</span></label>
        <input type="date" name="joining_date" id="joining_date" class="form-control"
            value="{{ old('joining_date', optional(optional($staff)->joining_date ? \Carbon\Carbon::parse(optional($staff)->joining_date) : null)->format('Y-m-d')) }}">
    </div>

    <!-- Present Address -->
    <div class="form-group">
        <label class="form-label">Current Address</label>
        <input type="text" name="present_address" class="form-control"
             value="{{ old('present_address', $staff->present_address ?? '') }}">
    </div>

    <!-- Permanent Address -->
    <div class="form-group">
        <label class="form-label">Permanent Address</label>
        <input type="text" name="permanent_address" class="form-control"
            value="{{ old('permanent_address', $staff->permanent_address ?? '') }}">
    </div>

    <!-- Phone number -->
    <div class="form-group ">
        <label class="form-label">Phone number</label>
        <input type="text" name="mobileno" class="form-control"
            value="{{ old('mobileno', $staff->mobileno ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label">Emergency Contact Name <span class="text-danger">*</span></label>
        <input type="text" name="emergency_contact" class="form-control"
            value="{{ old('emergency_contact', $staff->emergency_contact ?? '') }}" required>
    </div>

    <!-- Phone number -->
    <div class="form-group ">
        <label class="form-label">Emergency Contact Number<span class="text-danger">*</span></label>
        <input type="text" name="emergency_phone_no" class="form-control"
            value="{{ old('emergency_phone_no', $staff->emergency_phone_no ?? '') }}" required>
    </div>
    <br>

    @if ($method !== 'PUT')
        <hr class="my-4">

        <br>

        {{-- Login Credentials --}}
        <h5 class="mb-3">System Login Credentials</h5>
        <br>
        <!-- Username -->
        <div class="form-group">
            <label class="form-label">Username <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control"
                value="{{ old('name', $staff->user?->name ?? '') }}" required>
        </div>


        <!-- Email -->
        <div class="form-group ">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $staff->user?->email ?? '') }}" required>
        </div>

        <!-- Password -->

        <div class="form-group ">
            <label class="form-label">Password {!! $method !== 'PUT' ? '<span class="text-danger">*</span>' : '' !!}</label>
            <input type="password" name="password" class="form-control" {{ $method !== 'PUT' ? 'required' : '' }}>
        </div>
    @endif

    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            {{ $method === 'PUT' ? 'Update Staff' : 'Create Staff' }}
        </button>
    </div>
</form>
