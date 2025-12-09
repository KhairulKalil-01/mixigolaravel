<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Select Invoice -->
    <div class="form-group mt-3">
        <label class="form-label">Select Invoice</label>
        <select name="invoice_id" class="form-control">
            <option value="">-- Select Invoice --</option>
            @foreach ($invoices as $invoice)
                <option value="{{ $invoice->id }}"
                    {{ old('invoice_id', $client_payment->invoice_id) == $invoice->id ? 'selected' : '' }}>
                    {{ $invoice->client->name }} - {{ $invoice->invoice_number }}
                    (RM{{ number_format($invoice->total_amount, 2) }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- Payment Type -->
    <div class="form-group mt-3">
        <label class="form-label">Payment Type</label>
        <select name="payment_type" class="form-control" required>
            <option value="">-- Select Payment Type --</option>
            <option value=1
                {{ old('payment_type') == 1 || (isset($client_payment) && $client_payment->payment_type == 1) ? 'selected' : '' }}>
                Deposit</option>
            <option value=2
                {{ old('payment_type') == 2 || (isset($client_payment) && $client_payment->payment_type == 2) ? 'selected' : '' }}>
                Balance Payment</option>
            <option value=3
                {{ old('payment_type') == 3 || (isset($client_payment) && $client_payment->payment_type == 3) ? 'selected' : '' }}>
                Full Payment</option>
        </select>
    </div>




    <!-- Payment Method -->
    <div class="form-group mt-3">
        <label class="form-label">Payment Method</label>
        <select name="payment_method" class="form-control" required>
            <option value="">-- Select Payment Method --</option>
            <option value=1
                {{ old('payment_method') == 1 || (isset($client_payment) && $client_payment->payment_method == 1) ? 'selected' : '' }}>
                Transfer</option>
            <option value=2
                {{ old('payment_method') == 2 || (isset($client_payment) && $client_payment->payment_method == 2) ? 'selected' : '' }}>
                FPX/Website</option>
        </select>
    </div>

    <!-- Amount -->
    <div class="form-group mt-3">
        <label class="form-label">Amount (RM)</label>
        <input type="number" name="amount" class="form-control" min='0' step='0.01'
            value="{{ old('amount', $client_payment->amount ?? '') }}" required>
    </div>

    <!-- Payment Status -->
    <div class="form-group mt-3">
        <label class="form-label">Payment Status</label>
        <select name="payment_status" class="form-control" required>
            <option value="">-- Select Payment Status --</option>
            <option value=1
                {{ old('payment_status') == 1 || (isset($client_payment) && $client_payment->payment_status == 1) ? 'selected' : '' }}>
                Pending</option>
            <option value=2
                {{ old('payment_status') == 2 || (isset($client_payment) && $client_payment->payment_status == 2) ? 'selected' : '' }}>
                Completed</option>
        </select>
    </div>

    <!-- Payment Date -->
    <div class="form-group mt-3">
        <label class="form-label">Payment Date</label>
        <input type="date" name="payment_date" class="form-control"
            value="{{ old('payment_date', isset($client_payment) ? \Carbon\Carbon::parse($client_payment->payment_date)->format('Y-m-d') : '') }}">
    </div>


    <!-- Remarks -->
    <div class="form-group mt-3">
        <label class="form-label">Remarks</label>
        <input type="text" name="remarks" class="form-control"
            value="{{ old('remarks', isset($client_payment) ? $client_payment->remarks : '') }}"
            placeholder="Enter remarks">
    </div>



    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">
            {{ $method === 'PUT' ? 'Update' : 'Create' }} Client Payment
        </button>
    </div>
</form>
