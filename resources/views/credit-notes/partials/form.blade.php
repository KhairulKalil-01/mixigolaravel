<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Invoice Select -->
    <div class="form-group">
        <label class="form-label" for="quotation_id" class="form-label">Invoice</label>
        <select name="invoice_id" id="quotation_id" class="form-select" required>
            <option value="">-- Select Invoice --</option>
            @foreach ($invoices as $invoice)
                <option value="{{ $invoice->id }}"
                    {{ old('invoice_id', $credit_note->invoice_id ?? null) == $invoice->id ? 'selected' : '' }}>
                    {{ $invoice->invoice_number }} — {{ $invoice->client->name }} —
                    RM{{ number_format($invoice->total_amount, 2) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Credit Note Date -->
    <div class="form-group">
        <label class="form-label" for="credit_note_date">Credit Note Date</label>
        <input type="date" name="credit_note_date" id="credit_note_date" class="form-control"
            value="{{ old('credit_note_date', isset($credit_note) ? \Carbon\Carbon::parse($credit_note->credit_note_date)->format('Y-m-d') : date('Y-m-d')) }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="reason_type">Reason</label>
        <select name="reason_type" id="reason_type" class="form-control" required>
            <option value="">-- Select Reason --</option>
            <option value="1" {{ old('reason_type', $credit_note->reason_type ?? '') == 1 ? 'selected' : '' }}>
                Cancellation</option>
            <option value="2" {{ old('reason_type', $credit_note->reason_type ?? '') == 2 ? 'selected' : '' }}>
                Discount Adjustment</option>
            <option value="3" {{ old('reason_type', $credit_note->reason_type ?? '') == 3 ? 'selected' : '' }}>
                Overpayment</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="credit_amount">Credit Amount (RM)</label>
        <input type="number" name="credit_amount" id="credit_amount" class="form-control" step="0.01"
            value="{{ old('credit_amount', $credit_note->credit_amount ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="remarks">Remarks</label>
        <textarea name="remarks" id="remarks" class="form-control">{{ old('remarks', $credit_note->remarks ?? '') }}</textarea>
    </div>



    <button class="btn btn-primary" type="submit">Submit</button>
</form>
