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

    <input type="hidden" id="base_price_per_hour"> 

    <!-- 1. Select Client -->
    <div class="form-group">
        <label class="form-label" for="client">Client</label>
        <select name="client_id" id="client" class="form-control">
            <option value="">-- Select Client --</option>
        </select>
    </div>


    <!-- 2. Select Invoice (Loaded based on selected client) -->
    <div class="form-group">
        <label class="form-label" for="invoice">Invoice</label>
        <select name="invoice_id" id="invoice" class="form-control" disabled>
            <option value="">-- Select Invoice --</option>
        </select>
    </div>

    <!-- 4. Select Prepaid Record (Loaded based on selected invoice) -->
    <div class="form-group">
        <label class="form-label" for="prepaid_id">Prepaid Package</label>
        <select name="prepaid_id" id="prepaid_id" class="form-control" disabled>
            <option value="">-- Select Prepaid Package --</option>
        </select>
    </div>


    <!-- 5. Select Patient (Loaded based on selected client OR invoice, depending on your relationships) -->
    <div class="form-group">
        <label class="form-label" for="patient_id">Patient</label>
        <select name="patient_id" id="patient_id" class="form-control" disabled>
            <option value="">-- Select Patient --</option>
        </select>
    </div>


    <!-- 6. Service Start DateTime -->
    <div class="form-group">
        <label class="form-label" for="start_datetime">Service Start</label>
        <input type="datetime-local" name="start_datetime" id="start_datetime" class="form-control" disabled>
    </div>

    <!-- 7. Service End DateTime -->
    <div class="form-group">
        <label class="form-label" for="end_datetime">Service End</label>
        <input type="datetime-local" name="end_datetime" id="end_datetime" class="form-control" disabled>
    </div>


    <!-- 8. Hours of Service (calculated automatically, user cannot edit) -->
    <div class="form-group">
        <label class="form-label" for="hours_of_service">Hours of Service</label>
        <input type="text" name="hours_of_service" id="hours_of_service" class="form-control" readonly>
    </div>


    <!-- 9. Service Price (comes from quotation items related to selected invoice) -->
    <div class="form-group">
        <label class="form-label" for="service_price">Service Price (RM)</label>
        <input type="text" id="service_price" name="service_price" class="form-control" readonly>
    </div>


    <!-- 10. Price Per Hour (service_price ÷ hours_of_service) -->
    <div class="form-group">
        <label class="form-label" for="price_per_hour">Price Per Hour (RM)</label>
        <input type="text" name="price_per_hour" id="price_per_hour" class="form-control" readonly>
    </div>


    <!-- 11. Select Caregiver -->
    <div class="form-group">
        <label class="form-label" for="caregiver_id">Caregiver</label>
        <select name="caregiver_id" id="caregiver_id" class="form-control" disabled>
            <option value="">-- Select Caregiver --</option>
        </select>
    </div>


    <!-- 12. Mileage Amount (if applicable) -->
    <div class="form-group">
        <label class="form-label" for="mileage_amount">Mileage Amount (RM)</label>
        <input type="number" step="0.01" name="mileage_amount" id="mileage_amount" class="form-control">
    </div>


    <!-- 13. Caregiver Payout Per Hour (used later for payroll) -->
    <div class="form-group">
        <label class="form-label" for="caregiver_payout_per_hour">Caregiver Payout Per Hour (RM)</label>
        <input type="number" step="0.01" name="caregiver_payout_per_hour" id="caregiver_payout_per_hour"
            class="form-control">
    </div>

    <!-- Inline loaders used by AJAX -->
    <div style="display:none;">
        <div id="clientLoader" class="spinner-border spinner-border-sm" role="status"></div>
        <div id="invoiceLoader" class="spinner-border spinner-border-sm" role="status"></div>
        <div id="prepaidLoader" class="spinner-border spinner-border-sm" role="status"></div>
        <div id="patientLoader" class="spinner-border spinner-border-sm" role="status"></div>
        <div id="caregiverLoader" class="spinner-border spinner-border-sm" role="status"></div>
    </div>


    <button class="btn btn-primary" type="submit">Submit</button>
</form>

<script src="{{ asset('assets/js/jquery-3.6.0.js') }}"></script>
<script>
    $(document).ready(function() {
        
        // ------------------ Utility ------------------
        function show($el) { $el.show(); }
        function hide($el) { $el.hide(); }
        function clearFields(...fields) { fields.forEach(f => f.val(''));}

        function updateServicePrice() {
            const hours = parseFloat($('#hours_of_service').val()) || 0;
            const rate = parseFloat($('#price_per_hour').val()) || 0;
            $('#service_price').val((hours > 0 && rate > 0) ? (hours * rate).toFixed(2) : '');
        }

        // ------------------ Load Clients ------------------
        function loadClients() {
            const $select = $('#client');
            show($('#clientLoader'));
            $.ajax({
                url: '{{ route('clients.get') }}',
                method: 'GET',
                success: function(res) {
                    $select.empty().append('<option value="">-- Select Client --</option>');
                    res.data.forEach(c => $select.append(`<option value="${c.id}">${c.name}</option>`));
                },
                error: function() { alert('Failed to load clients'); },
                complete: function() { hide($('#clientLoader')); }
            });
        }

        loadClients();

        // ------------------ On Client Change ------------------
        $('#client').on('change', function() {
            const clientId = $(this).val();

            // Reset
            $('#invoice, #prepaid_id, #patient_id, #caregiver_id').prop('disabled', true).empty().append('<option value="">-- Select --</option>');
            clearFields($('#start_datetime'), $('#end_datetime'), $('#hours_of_service'), $('#service_price'), $('#price_per_hour'), $('#caregiver_payout_per_hour'));

            if (!clientId) return;

            // Load Invoices
            show($('#invoiceLoader'));
            $.ajax({
                url: '{{ route("client.invoices.get", ["id" => ":clientId"]) }}'.replace(':clientId', clientId),
                method: 'GET',
                success: function(res) {
                    const $invoice = $('#invoice');
                    $invoice.empty().append('<option value="">-- Select Invoice --</option>');
                    res.data.forEach(inv => {
                        $invoice.append(`<option value="${inv.invoice_id}" data-price-per-hour="${inv.price_per_hour}">${inv.invoice_number} - RM${inv.total_price}</option>`);
                    });
                    $invoice.prop('disabled', false);
                },
                error: function() { alert('Failed to load invoices'); },
                complete: function() { hide($('#invoiceLoader')); }
            });

            // Load Patients
            show($('#patientLoader'));
            $.ajax({
                url: '{{ route("client.patients.get", ["id" => ":clientId"]) }}'.replace(':clientId', clientId),
                method: 'GET',
                success: function(res) {
                    const $patient = $('#patient_id');
                    $patient.empty().append('<option value="">-- Select Patient --</option>');
                    res.data.forEach(p => $patient.append(`<option value="${p.id}">${p.name}</option>`));
                    $patient.prop('disabled', false);
                },
                error: function() { alert('Failed to load patients'); },
                complete: function() { hide($('#patientLoader')); }
            });
        });

        // ------------------ On Invoice Change ------------------
        $('#invoice').on('change', function() {
            const $selected = $(this).find('option:selected');
            const invoiceId = $(this).val();
            const pricePerHour = parseFloat($selected.data('price-per-hour') || 0);

            // Reset fields that depend on invoice selection
            clearFields($('#start_datetime'), $('#end_datetime'), $('#hours_of_service'), $('#service_price'));
            $('#price_per_hour').val(pricePerHour.toFixed(2));
            
            if (!invoiceId) {
                $('#start_datetime, #end_datetime').prop('disabled', true);
                $('#prepaid_id').prop('disabled', true).html('<option value="">-- Select Prepaid --</option>');
                return;
            };

            $('#start_datetime, #end_datetime').prop('disabled', false);

            // Load prepaid packages
            show($('#prepaidLoader'));
            $.ajax({
                url: '{{ route("invoice.prepaids.get", ["id" => ":invoiceId"]) }}'.replace(':invoiceId', invoiceId),
                method: 'GET',
                success: function(res) {
                    const $pre = $('#prepaid_id');
                    $pre.empty().append(
                        '<option value="">-- Select Prepaid Package --</option>');
                    res.data.forEach(p => {
                        $pre.append(`<option 
                        value="${p.id}" 
                        data-remaining="${p.remaining_hour}" 
                        data-price-per-hour="${p.price_per_hour}" 
                        data-service-price="${p.unit_price}"
                    >
                        ${p.service_name} - ${p.remaining_hour} hrs remaining
                    </option>`);
                    });
                    $pre.prop('disabled', false);
                },
                error: function() {
                    alert('Failed to load prepaids');
                },
                complete: function() {
                    hide($('#prepaidLoader'));
                }
            });
        });

        // ------------------ On Prepaid Selection ------------------
        $('#prepaid_id').on('change', function() {
            const $selected = $(this).find(':selected');
            if (!$selected.val()) {
                // When deselected, revert to base price per hour from invoice
                const invoiceSelectedOption = $('#invoice').find('option:selected');
                const basePrice = parseFloat(invoiceSelectedOption.data('price-per-hour') || 0);
                $('#price_per_hour').val(basePrice.toFixed(2));
                updateServicePrice();
                return;
            }

            const pricePerHour = parseFloat($selected.data('price-per-hour') || 0);
            
            $('#price_per_hour').val(pricePerHour.toFixed(2));
            
            // Recalculate service price with the new hourly rate
            updateServicePrice();
        });


        // ------------------ Compute Hours Based on Datetime ------------------
        $('#start_datetime, #end_datetime').on('change', function() {
            const s = $('#start_datetime').val();
            const e = $('#end_datetime').val();
            
            if (!s || !e) {
                clearFields($('#hours_of_service'), $('#service_price'));
                return;
            }

            const start = new Date(s);
            const end = new Date(e);

            if (end <= start) {
                clearFields($('#hours_of_service'), $('#service_price'));
                return;
            }

            const diffMs = end - start;
            const diffHours = diffMs / (1000 * 60 * 60); // Get hours with decimals
            $('#hours_of_service').val(diffHours.toFixed(2));

            updateServicePrice();
            fetchAvailableCaregivers(s, e);
        });

        // ------------------ Fetch Available Caregivers ------------------
        function fetchAvailableCaregivers(start, end) {
            show($('#caregiverLoader'));
            $('#caregiver_id').prop('disabled', true).html('<option>Loading...</option>');
            $.ajax({
                url: '{{ route("caregivers.get_all") }}',
                method: 'GET',
                data: { start_datetime: start, end_datetime: end },
                success: function(res) {
                    const $cg = $('#caregiver_id');
                    $cg.empty().append('<option value="">-- Select Caregiver --</option>');
                    res.data.forEach(c => {
                        $cg.append(`<option value="${c.id}" data-payout="${c.rate_per_hour || 0}">${c.name} - RM${c.rate_per_hour || 0}/hr</option>`);
                    });
                    $cg.prop('disabled', false);
                },
                error: function() { alert('Failed to load caregivers');},
                complete: function() { hide($('#caregiverLoader'));}
            });
        }

        // ------------------ Caregiver Selection ------------------
        $('#caregiver_id').on('change', function() {
            const payout = parseFloat($(this).find(':selected').data('payout') || 0);
            $('#caregiver_payout_per_hour').val(payout.toFixed(2));
        });
    });
</script>