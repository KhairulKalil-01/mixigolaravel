<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Credit Note Select -->
    <div class="form-group">
        <label class="form-label" for="credit_note_id">Credit Note</label>
        <select name="credit_note_id" id="credit_note_id" class="form-select" required>
            <option value="">-- Select Credit Note --</option>
            @foreach ($credit_notes as $credit_note)
                <option value="{{ $credit_note->id }}"
                    {{ old('credit_note_id', $refund->credit_note_id ?? null) == $credit_note->id ? 'selected' : '' }}>
                    {{ $credit_note->credit_note_number }} — {{ $credit_note->client->name }} —
                    RM{{ number_format($credit_note->credit_amount, 2) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Status -->
    <div class="form-group">
        <label class="form-label" for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Select Status --</option>
            <option value="1" {{ old('status', $refund->status ?? '') == 1 ? 'selected' : '' }}>
                Pending</option>
            <option value="2" {{ old('status', $refund->status ?? '') == 2 ? 'selected' : '' }}>
                Completed</option>
        </select>
    </div>

    <!-- Refund Date -->
    <div class="form-group">
        <label class="form-label" for="refund_date">Refund Date</label>
        <input type="date" name="refund_date" id="refund_date" class="form-control"
            value="{{ old('refund_date', isset($refund) ? \Carbon\Carbon::parse($refund->refund_date)->format('Y-m-d') : date('Y-m-d')) }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="reason_type">Reason</label>
        <select name="reason_type" id="reason_type" class="form-control" required>
            <option value="">-- Select Reason --</option>
            <option value="1" {{ old('reason_type', $refund->reason_type ?? '') == 1 ? 'selected' : '' }}>
                Cancellation</option>
            <option value="2" {{ old('reason_type', $refund->reason_type ?? '') == 2 ? 'selected' : '' }}>
                Discount Adjustment</option>
            <option value="3" {{ old('reason_type', $refund->reason_type ?? '') == 3 ? 'selected' : '' }}>
                Overpayment</option>
        </select>
    </div>

    <!-- Bank Details-->
    <div class="form-group">
        <label class="form-label" for="bank_id">Bank</label>
        <select name="bank_id" id="bank_id" class="form-select" required>
            <option value="">-- Select Bank --</option>
            @foreach ($banks as $bank)
                <option value="{{ $bank->id }}"
                    {{ old('bank_id', $refund->bank_id ?? null) == $bank->id ? 'selected' : '' }}>
                    {{ $bank->bank_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="bank_account">Bank Account Number</label>
        <input type="text" name="bank_account" id="bank_account" class="form-control"
            value="{{ old('bank_account', $refund->bank_account ?? '') }}" required>
    </div>



    <div class="form-group">
        <label class="form-label" for="amount">Amount (RM)</label>
        <input type="number" name="amount" id="amount" class="form-control" step="0.01"
            value="{{ old('amount', $refund->amount ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="remarks">Remarks</label>
        <textarea name="remarks" id="remarks" class="form-control">{{ old('remarks', $refund->remarks ?? '') }}</textarea>
    </div>



    <button class="btn btn-primary" type="submit">Submit</button>
</form>
