<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Name -->
    <div class="form-group">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="full_name" class="form-control"
            value="{{ old('full_name', $user->staff->full_name ?? '') }}" readonly>
    </div>

    <!-- IC Number -->
    <div class="form-group mt-3">
        <label class="form-label">IC Number</label>
        <input type="text" name="ic_num" class="form-control"
            value="{{ old('ic_num', $user->staff->ic_num ?? '') }}" readonly>
    </div>

    <!-- Present Address -->
    <div class="form-group">
        <label class="form-label">Current Address</label>
        <input type="text" name="present_address" class="form-control"
            value="{{ old('present_address', $user->staff->present_address ?? '') }}">
    </div>

    <!-- Permanent Address -->
    <div class="form-group">
        <label class="form-label">Permanent Address</label>
        <input type="text" name="permanent_address" class="form-control"
            value="{{ old('permanent_address', $user->staff->permanent_address ?? '') }}">
    </div>

    <!-- Phone number -->
    <div class="form-group">
        <label class="form-label">Phone number</label>
        <input type="text" name="mobileno" class="form-control"
            value="{{ old('mobileno', $user->staff->mobileno ?? '') }}">
    </div>

    <!-- Emergency Contact -->
    <div class="form-group">
        <label class="form-label">Emergency Contact Name <span class="text-danger">*</span></label>
        <input type="text" name="emergency_contact" class="form-control"
            value="{{ old('emergency_contact', $user->staff->emergency_contact ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label">Emergency Contact Number <span class="text-danger">*</span></label>
        <input type="text" name="emergency_phone_no" class="form-control"
            value="{{ old('emergency_phone_no', $user->staff->emergency_phone_no ?? '') }}" required>
    </div>

    <!-- Passport -->
    <div class="form-group">
        <label class="form-label">Passport</label>
        <input type="text" name="passport" class="form-control"
            value="{{ old('passport', $user->staff->passport ?? '') }}">
    </div>

    <!-- Email -->
    <div class="form-group mt-3">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
    </div>

    <!-- Password -->
    <div class="form-group">
        <label class="form-label">Password (leave blank if not changing)</label>
        <input type="password" id="password" name="password" class="form-control">
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control mt-2" placeholder="Confirm password">
        <small id="password-message" class="text-danger d-none">Passwords do not match</small>
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>

</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        const message = document.getElementById('password-message');

        function checkMatch() {
            if (password.value && confirm.value) {
                if (password.value !== confirm.value) {
                    message.classList.remove('d-none');
                } else {
                    message.classList.add('d-none');
                }
            } else {
                message.classList.add('d-none');
            }
        }

        password.addEventListener('input', checkMatch);
        confirm.addEventListener('input', checkMatch);
    });
</script>
