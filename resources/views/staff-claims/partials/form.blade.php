<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Claim Date -->
    <div class="form-group">
        <label class="form-label" for="claim_date">Claim Date</label>
        <input type="date" name="claim_date" id="claim_date" class="form-control"
            value="{{ old('claim_date', optional(optional($claim)->claim_date)->format('Y-m-d')) }}" required>
    </div>

    <div class="form-group">
        <label class="form-label">Claim Type (Mileage, Accomodation, Toll, etc)</label>
        <input class="form-control" type="text" name="claim_type"
            value="{{ old('claim_type', $claim->claim_type ?? '') }}" placeholder="Claim Type" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="amount">Amount</label>
        <input class="form-control" type="number" name="amount" step="0.01"
            value="{{ old('amount', $claim->amount ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label">Description</label>
        <input class="form-control" type="text" name="description"
            value="{{ old('description', $claim->description ?? '') }}" required>
    </div>

    <div class="form-group">
        <label  class="form-label" for="receipt">Upload Receipt (PDF/JPEG) - 2MB max:</label>
        <input type="file" name="receipt" id="receipt" class="form-control" accept=".pdf,.jpeg,.jpg,.png">
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>
