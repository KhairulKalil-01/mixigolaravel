@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif


    <!-- Invoice Selection -->
    <div class="form-group">
        <label class="form-label" for="invoice_id">Invoice <span class="text-danger">*</span></label>
        <select name="invoice_id" id="invoice_id" class="form-control" required>
            <option value="">-- Select Invoice --</option>
            @foreach ($invoices as $inv)
                <option value="{{ $inv->id }}" data-amount="{{ $inv->total_amount }}"
                    {{ old('invoice_id') == $inv->id ? 'selected' : '' }}>{{ $inv->invoice_number }} -
                    {{ $inv->client->name ?? '' }}</option>
            @endforeach
        </select>
    </div>

    <!-- Staff or External Agent -->
    <div class="form-group">
        <label class="form-label">Claim Made By: <span class="text-danger">*</span></label><br>
        <label><input type="radio" name="claim_type" value="staff"
                {{ old('claim_type') == 'staff' ? 'checked' : '' }} required> Staff</label>
        <label class="ms-3"><input type="radio" name="claim_type" value="agent"
                {{ old('claim_type') == 'agent' ? 'checked' : '' }}> External Agent</label>
    </div>

    <div class="form-group staff-field" style="display:none;">
        <label class="form-label">Select Staff</label>
        <select name="staff_id" class="form-control">
            <option value="">-- Select Staff --</option>
            @foreach ($staffs as $staff)
                <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }}>
                    {{ $staff->full_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group agent-field" style="display:none;">
        <label class="form-label">Select External Agent</label>
        <select name="external_agent_id" class="form-control">
            <option value="">-- Select External Agent --</option>
            @foreach ($agents as $agent)
                <option value="{{ $agent->id }}" {{ old('external_agent_id') == $agent->id ? 'selected' : '' }}>
                    {{ $agent->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="invoice_amount" class="form-label">Invoice Amount (RM)</label>
            <input type="text" id="invoice_amount" name="invoice_amount" class="form-control" readonly>
        </div>

        <div class="col-md-4 mb-3">
            <label for="commission_rate" class="form-label">Commission Rate (%) <span
                    class="text-danger">*</span></label>
            <input type="number" id="commission_rate" name="commission_rate" class="form-control" step="0.01"
                placeholder="eg. 10 for 10%" min="0" value="{{ old('commission_rate') }}" required>
        </div>

        <div class="col-md-4 mb-3">
            <label for="amount" class="form-label">Commission Amount (RM)</label>
            <input type="text" id="amount" name="amount" class="form-control" readonly>
        </div>
    </div>

    <!-- Remarks -->
    <div class="form-group">
        <label class="form-label" for="submission_remarks">Submission Remarks</label>
        <textarea name="submission_remarks" id="submission_remarks" class="form-control" rows="3">{{ old('submission_remarks', $claim->submission_remarks ?? '') }}</textarea>
    </div>

    <button class="btn btn-primary" type="submit">Submit</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Staff / Agent toggle
        document.querySelectorAll('input[name="claim_type"]').forEach(el => {
            el.addEventListener('change', function() {
                document.querySelector('.staff-field').style.display = this.value === 'staff' ?
                    'block' : 'none';
                document.querySelector('.agent-field').style.display = this.value === 'agent' ?
                    'block' : 'none';
            });

            // Restore visibility if editing
            if (el.checked) {
                document.querySelector('.staff-field').style.display = el.value === 'staff' ? 'block' :
                    'none';
                document.querySelector('.agent-field').style.display = el.value === 'agent' ? 'block' :
                    'none';
            }
        });


        // Invoice amount and commission calculation
        const invoiceSelect = document.getElementById('invoice_id');
        const invoiceAmountInput = document.getElementById('invoice_amount');
        const commissionRateInput = document.getElementById('commission_rate');
        const commissionAmountInput = document.getElementById('amount');


        function calculateCommission() {
            const rate = parseFloat(commissionRateInput.value) || 0;
            const amount = parseFloat(invoiceAmountInput.value) || 0;
            const commission = (rate / 100) * amount;
            commissionAmountInput.value = commission.toFixed(2);
        }

        invoiceSelect.addEventListener('change', function() {
            const selected = invoiceSelect.options[invoiceSelect.selectedIndex];
            const amount = selected.getAttribute('data-amount') || 0;
            invoiceAmountInput.value = amount;
            calculateCommission();
        });

        commissionRateInput.addEventListener('input', calculateCommission);
    });
</script>
