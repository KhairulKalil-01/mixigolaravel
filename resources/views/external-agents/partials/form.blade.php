<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-group">
        <label class="form-label">Name<span style="color: red">*</span></label>
        <input class="form-control" type="text" name="name" value="{{ old('name', $agent->name ?? '') }}"
            placeholder="Name" required>
    </div>
    <div class="form-group">
        <label class="form-label">Company Name</label>
        <input class="form-control" type="text" name="company_name"
            value="{{ old('company_name', $agent->company_name ?? '') }}" placeholder="Company Name">
    </div>
    <div class="form-group">
        <label class="form-label">IC Number</label>
        <input class="form-control" type="text" name="ic_no" value="{{ old('ic_no', $agent->ic_no ?? '') }}">
    </div>
    <div class="form-group">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="{{ old('email', $agent->email ?? '') }}">
    </div>
    <div class="form-group">
        <label class="form-label">Phone Number</label>
        <input class="form-control" type="text" name="mobileno"
            value="{{ old('mobileno', $agent->mobileno ?? '') }}">
    </div>
    <div class="form-group">
        <label class="form-label">TIN number (Tax Identification Number)<span style="color: red">*</span></label>
        <input class="form-control" type="text" name="tax_no" value="{{ old('tax_no', $agent->tax_no ?? '') }}" required>
    </div>
    <!-- Bank Details-->
    <div class="form-group">
        <label class="form-label" for="bank_id">Bank</label>
        <select name="bank_id" id="bank_id" class="form-control" required>
            <option value="">-- Select Bank --</option>
            @foreach ($banks as $bank)
                <option value="{{ $bank->id }}"
                    {{ old('bank_id', $agent->bank_id ?? null) == $bank->id ? 'selected' : '' }}>
                    {{ $bank->bank_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Bank Account Number<span style="color: red">*</span></label>
        <input class="form-control" type="text" name="bank_acc_no" value="{{ old('bank_acc_no', $agent->bank_acc_no ?? '') }}" required>
    </div>

    <button class="btn btn-primary" type="submit">Submit</button>
</form>
