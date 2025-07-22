<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Quotation Select -->
    <div class="form-group">
        <label class="form-label" for="quotation_id" class="form-label">Quotation</label>
        <select name="quotation_id" id="quotation_id" class="form-select" required>
            <option value="">-- Select Quotation --</option>
            @foreach ($quotations as $quotation)
                <option value="{{ $quotation->id }}"
                    {{ old('quotation_id', $invoice->quotation_id ?? null) == $quotation->id ? 'selected' : '' }}>
                    {{ $quotation->quotation_number }} — {{ $quotation->client->name }} —
                    RM{{ number_format($quotation->final_price, 2) }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Invoice Date -->
    <div class="form-group">
        <label for="invoice_date">Invoice Date</label>
        <input type="date" name="invoice_date" id="invoice_date" class="form-control"
            value="{{ old('invoice_date', optional($invoice->invoice_date)->format('Y-m-d') ?? date('Y-m-d')) }}">
    </div>

    <!-- Due Date -->
    <div class="form-group">
        <label for="due_date">Due Date</label>
        <input type="date" name="due_date" id="due_date" class="form-control"
            value="{{ old('due_date', optional($invoice->due_date)->format('Y-m-d') ?? \Carbon\Carbon::now()->addMonth()->format('Y-m-d')) }}">
    </div>

    <div class="form-group">
        <label for="remarks">Remarks</label>
        <textarea name="remarks" id="remarks" class="form-control">{{ old('remarks', $invoice->remarks ?? '') }}</textarea>
    </div>



    <button class="btn btn-primary" type="submit">Submit</button>
</form>
