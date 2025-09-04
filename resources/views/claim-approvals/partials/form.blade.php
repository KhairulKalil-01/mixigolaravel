<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-group">
        <label class="form-label" for="staff">Staff</label>
        <input type="text" name="staff" id="staff" class="form-control"
            value="{{ $staffClaim->staff->full_name ?? 'N/A' }}" disabled>
    </div>

    <!-- Claim Date -->
    <div class="form-group">
        <label class="form-label" for="claim_date">Claim Date</label>
        <input type="date" name="claim_date" id="claim_date" class="form-control"
            value="{{ old('claim_date', optional(optional($staffClaim)->claim_date)->format('Y-m-d')) }}" disabled>
    </div>

    <div class="form-group">
        <label class="form-label">Claim Type (Mileage, Accomodation, Toll, etc)</label>
        <input class="form-control" type="text" name="claim_type"
            value="{{ old('claim_type', $staffClaim->claim_type ?? '') }}" placeholder="Claim Type" disabled>
    </div>

    <div class="form-group">
        <label class="form-label" for="amount">Amount</label>
        <input class="form-control" type="number" name="amount" step="0.01"
            value="{{ old('amount', $staffClaim->amount ?? '') }}" disabled>
    </div>

    <div class="form-group">
        <label class="form-label">Description</label>
        <input class="form-control" type="text" name="description"
            value="{{ old('description', $staffClaim->description ?? '') }}" disabled>
    </div>

    <div class="form-group">
        <label class="form-label" for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Select Approval Status --</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}"
                    {{ old('status', $staffClaim->status ?? null) == $status->value ? 'selected' : '' }}>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="approved_amount">Approved Amount</label>
        <input class="form-control" type="number" name="approved_amount" step="0.01"
            value="{{ old('approved_amount', $staffClaim->approved_amount ?? '') }}">
    </div>


    <div class="form-group">
        <label class="form-label" for="payment_method">Payment Method</label>
        <select name="payment_method" id="payment_method" class="form-control" required>
            <option value="">-- Select Payment Method --</option>
            @foreach ($paymentMethods as $payment_method)
                <option value="{{ $payment_method->value }}"
                    {{ old('payment_method', $staffClaim->payment_method ?? null) == $payment_method->value ? 'selected' : '' }}>
                    {{ $payment_method->label() }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="remarks">Remarks</label>
        <input class="form-control" type="text" name="remarks"
            value="{{ old('remarks', $staffClaim->remarks ?? '') }}">
    </div>


    <button class="btn btn-primary" type="submit">Submit</button>
</form>
