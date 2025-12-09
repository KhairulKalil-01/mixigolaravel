<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-group">
        <label class="form-label" for="claimer">Claimer</label>
        <input type="text" name="claimer" id="claimer" class="form-control"
            value="{{ $commission_approval->claimer_name ?? 'N/A' }}" disabled>
    </div>

    <!-- Claim Date -->
    <div class="form-group">
        <label class="form-label" for="claim_date">Claim Date</label>
        <input type="date" name="claim_date" id="claim_date" class="form-control"
            value="{{ old('claim_date', optional(optional($commission_approval)->claim_date)->format('Y-m-d')) }}" disabled>
    </div>

    <div class="form-group">
        <label class="form-label">Claim Type (Mileage, Accomodation, Toll, etc)</label>
        <input class="form-control" type="text" name="claim_type"
            value="{{ old('claim_type', $commission_approval->claim_type ?? '') }}" placeholder="Claim Type" disabled>
    </div>

    <div class="form-group">
        <label class="form-label" for="amount">Amount</label>
        <input class="form-control" type="number" name="amount" step="0.01"
            value="{{ old('amount', $commission_approval->amount ?? '') }}" disabled>
    </div>

    <div class="form-group">
        <label class="form-label" for="submission_remarks">Submission Remarks</label>
        <input class="form-control" type="text" name="submission_remarks"
            value="{{ old('submission_remarks', $commission_approval->submission_remarks ?? '') }}" disabled>
    </div>

    <div class="form-group">
        <label class="form-label" for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Select Approval Status --</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}"
                    {{ old('status', $commission_approval->status ?? null) == $status->value ? 'selected' : '' }}>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="remarks">Approval Remarks</label>
        <input class="form-control" type="text" name="remarks"
            value="{{ old('remarks', $commission_approval->remarks ?? '') }}">
    </div>


    <button class="btn btn-primary" type="submit">Submit</button>
</form>
