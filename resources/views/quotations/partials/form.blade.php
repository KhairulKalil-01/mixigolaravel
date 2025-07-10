<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Client Selection -->
    <div class="form-group">
        <label class="form-label" for="client_id">Client</label>
        <select name="client_id" class="form-control" required>
            <option value="">-- Select Client --</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Patient Selection -->
    <div class="form-group">
        <label class="form-label" for="patient_id">Patient</label>
        <select name="patient_id" class="form-control" required>
            <option value="">-- Select Patient --</option>
            @foreach ($patients as $patient)
                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
            @endforeach
        </select>
    </div>

    <hr>

    <!-- Quotation Items (Repeatable Group) -->
    <h5>Services</h5>
    <div id="quotation-items-wrapper">
        <div class="quotation-item border p-3 mb-2">
            <div class="row align-items-end">
                <!-- Service Select (6 columns) -->
                <div class="form-group col-md-6">
                    <label class="form-label">Service</label>
                    <select name="items[0][service_pricing_id]" class="form-control service-select" required>
                        <option value="">-- Select Service --</option>
                        @foreach ($servicePricings as $service)
                            <option value="{{ $service->id }}" data-name="{{ $service->service_name }}"
                                data-price="{{ $service->price }}">
                                {{ $service->service_name }} - RM{{ number_format($service->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity (2 columns) -->
                <div class="form-group col-md-1">
                    <label class="form-label">Qty</label>
                    <input type="number" name="items[0][quantity]" class="form-control quantity-input" value="1"
                        min="1" required>
                </div>

                <!-- Subtotal (3 columns) -->
                <div class="form-group col-md-3">
                    <label class="form-label">Subtotal (RM)</label>
                    <input type="text" name="items[0][subtotal]" class="form-control subtotal-output" readonly>
                </div>

                <!-- Remove Button (1 column) -->
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger remove-item w-100 mt-4">X</button>
                </div>
            </div>
        </div>

    </div>

    <button type="button" class="btn btn-secondary" id="add-service-item">+ Add Another Service</button>

    <hr>

    <div class="form-group">
        <label class="form-label" for="mileage">Mileage (RM)</label>
        <input type="number" name="mileage" id="mileage" class="form-control" step="0.01"
            value="{{ old('mileage', $quotation->mileage ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="discount">Discount (RM)</label>
        <input type="number" name="discount" id="discount" class="form-control" step="0.01"
            value="{{ old('discount', $quotation->discount ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="discount">Grand Total (RM)</label>
        <input type="number" name="final_price" id="final_price" class="form-control" step="0.01"
            value="{{ old('final_price', $quotation->final_price ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="remarks">Remarks</label>
        <textarea name="remarks" class="form-control" rows="3" value="{{ old('remarks', $quotation->remarks ?? '') }}"></textarea>
    </div>

    <div class="form-group col-12 col-md-12 col-xl-4">
        <label class="form-label" for="valid_until">Valid Until</label>
        <input type="date" name="valid_until" class="form-control"
            value="{{ old('valid_until', $quotation->valid_until ?? '') }}">
    </div>

    <button class="btn btn-primary" type="submit">Submit</button>
</form>

@push('scripts')
    <script>
        let itemIndex = 1;

        $('#add-service-item').on('click', function() {
            let newItem = $('.quotation-item').first().clone();
            newItem.find('select').each(function() {
                let name = $(this).attr('name');
                if (name) {
                    name = name.replace(/\[\d+\]/, `[${itemIndex}]`);
                    $(this).attr('name', name);
                }
                $(this).prop('selectedIndex', 0); // reset selection
            });

            newItem.find('input').each(function() {
                let name = $(this).attr('name');
                if (name) {
                    name = name.replace(/\[\d+\]/, `[${itemIndex}]`);
                    $(this).attr('name', name).val('');
                }
            });
            newItem.find('.subtotal-output').val('');
            $('#quotation-items-wrapper').append(newItem);
            itemIndex++;
        });

        // Remove item
        $(document).on('click', '.remove-item', function() {
            if ($('.quotation-item').length > 1) {
                $(this).closest('.quotation-item').remove();
            }
        });

        // Auto calculate subtotal
        $(document).on('change', '.service-select, .quantity-input', function() {
            let wrapper = $(this).closest('.quotation-item');
            let price = parseFloat(wrapper.find('.service-select option:selected').data('price')) || 0;
            let quantity = parseInt(wrapper.find('.quantity-input').val()) || 0;
            wrapper.find('.subtotal-output').val((price * quantity).toFixed(2));
        });


        function calculateTotal() {
            let total = 0;

            $('.subtotal-output').each(function() {
                let subtotal = parseFloat($(this).val()) || 0;
                total += subtotal;
            });

            let mileage = parseFloat($('#mileage').val()) || 0;
            let discount = parseFloat($('#discount').val()) || 0;

            let grandTotal = total + mileage - discount;

            $('#final_price').val(grandTotal.toFixed(2));
        }

        // Trigger calculation when:
        $(document).on('change', '.service-select, .quantity-input, #mileage, #discount', function() {
            let wrapper = $(this).closest('.quotation-item');
            let price = parseFloat(wrapper.find('.service-select option:selected').data('price')) || 0;
            let quantity = parseInt(wrapper.find('.quantity-input').val()) || 0;
            wrapper.find('.subtotal-output').val((price * quantity).toFixed(2));

            calculateTotal();
        });

        // Also recalculate when items are added or removed
        $('#add-service-item').on('click', function() {
            // after appending new item
            setTimeout(() => {
                calculateTotal();
            }, 100); // short delay to ensure DOM updates
        });

        $(document).on('click', '.remove-item', function() {
            setTimeout(() => {
                calculateTotal();
            }, 100);
        });

        // Trigger on page load (for edit form)
        $(document).ready(function() {
            calculateTotal();
        });
    </script>
@endpush
