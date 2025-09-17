<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Start Time -->
    <div class="form-group">
        <label class="form-label" for="start_time">Start time</label>
        <input type="datetime-local" name="start_time" id="start_time" class="form-control"
            value="{{ old('start_time', optional(optional($overtime)->start_time)->format('Y-m-d\TH:i')) }}" disabled>
    </div>

    <!-- End Time -->
    <div class="form-group">
        <label class="form-label" for="end_time">End Time</label>
        <input type="datetime-local" name="end_time" id="end_time" class="form-control"
            value="{{ old('end_time', optional(optional($overtime)->end_time)->format('Y-m-d\TH:i')) }}" disabled>
        <small id="endTimeError" class="text-danger" style="display:none;">End time cannot be before start time!</small>
    </div>

    <!-- Multiplier -->
    <div class="form-group">
        <label class="form-label" for="multiplier">Multiplier</label>
        <select name="multiplier" id="multiplier" class="form-control" disabled>
            <option value="1.5" {{ old('multiplier', $overtime->multiplier ?? '') == 1.5 ? 'selected' : '' }}>Normal
                Day (1.5x)</option>
            <option value="2.0" {{ old('multiplier', $overtime->multiplier ?? '') == 2.0 ? 'selected' : '' }}>Rest
                Day (2.0x)</option>
            <option value="3.0" {{ old('multiplier', $overtime->multiplier ?? '') == 3.0 ? 'selected' : '' }}>Public
                Holiday (3.0x)</option>
        </select>
    </div>

    <!-- Hourly rate -->
    <div class="form-group">
        <label class="form-label" for="hourly_rate">Hourly Rate (RM)</label>
        <input class="form-control" type="number" name="hourly_rate" id="hourly_rate"
            value="{{ old('hourly_rate', $overtime->hourly_rate) }}" readonly>
    </div>

    <!-- Hours -->
    <div class="form-group">
        <label class="form-label" for="hours">Hours</label>
        <input class="form-control" type="number" name="hours" id="hours" step="0.01"
            value="{{ old('hours', $overtime->hours ?? '') }}" disabled>
    </div>

    <!-- Amount -->
    <div class="form-group">
        <label class="form-label" for="amount">Amount (RM)</label>
        <input class="form-control" type="number" name="amount" id="amount" step="0.01"
            value="{{ old('amount', $overtime->amount ?? '') }}" readonly>
    </div>

    <div class="form-group">
        <label class="form-label" for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Select Approval Status --</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}"
                    {{ $overtime->status == $status->value ? 'selected' : '' }}>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
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
