<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Amount -->
    <div class="form-group">
        <label class="form-label" for="amount">Amount (RM)</label>
        <input class="form-control" type="number" name="amount" id="amount" step="0.01"
            value="{{ old('amount', $advance->amount ?? '') }}" readonly>
    </div>

    <div class="form-group">
        <label class="form-label" for="status">Status<span class="text-danger">*</span></label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Select Approval Status --</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}"
                    {{ $advance->status == $status->value ? 'selected' : '' }}>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Approval Remarks -->
    <div class="form-group">
        <label class="form-label" for="approval_remarks">Approval Remarks</label>
        <input class="form-control" type="text" name="approval_remarks" id="approval_remarks"
            value="{{ old('approval_remarks', $advance->approval_remarks ?? '') }}">
    </div>



    <button class="btn btn-primary" type="submit">Submit</button>

</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        const startInput = document.getElementById("start_time");
        const endInput = document.getElementById("end_time");
        const hoursInput = document.getElementById("hours");
        const hourlyRateInput = document.getElementById("hourly_rate");
        const otMultiplier = document.getElementById("multiplier");
        const amountInput = document.getElementById("amount");
        const errorText = document.getElementById("endTimeError")

        function calculate() {
            const start = new Date(startInput.value);
            const end = new Date(endInput.value);
            const rate = parseFloat(hourlyRateInput.value) || 0;
            const multiplier = parseFloat(otMultiplier.value) || 1;

            if (start && end && end > start) {
                errorText.style.display = "none";
                const diffMs = end - start; // milliseconds
                const diffHours = diffMs / (1000 * 60 * 60); // convert to hours

                // Round to 2 decimal places
                const hours = Math.round(diffHours * 100) / 100;
                const amount = Math.round(hours * rate * multiplier * 100) / 100;

                hoursInput.value = hours;
                amountInput.value = amount;
            } else {
                errorText.style.display = "block";
            }
        }

        // recalculate
        startInput.addEventListener("change", calculate);
        endInput.addEventListener("change", calculate);
        otMultiplier.addEventListener("change", calculate);

        form.addEventListener("submit", function(e) {
            const start = new Date(startInput.value);
            const end = new Date(endInput.value);

            if (!startInput.value || !endInput.value || end < start) {
                e.preventDefault(); // stop form submit
                errorText.style.display = "block"; // show message
                errorText.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
        calculate();
    });
</script>
