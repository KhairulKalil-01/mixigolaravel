<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-group">
        <label class="form-label">Service Name<span class="text-danger">*</span></label>
        <input class="form-control" type="text" name="service_name"
            value="{{ old('service_name', $servicePricing->service_name ?? '') }}" placeholder="Service Name" required>
    </div>
    <div class="form-group">
        <label class="form-label">Service Type<span class="text-danger">*</span></label> {{-- caregiver/physio/ nursing --}}
        <select name="service_type" class="form-control" required>
            <option value="">-- Select Type --</option>
            <option value="Caregiver"
                {{ old('service_type', $servicePricing->service_type ?? '') == 'Caregiver' ? 'selected' : '' }}>
                Caregiver</option>
            <option value="Nursing"
                {{ old('service_type', $servicePricing->service_type ?? '') == 'Nursing' ? 'selected' : '' }}>Nursing
            </option>
            <option value="Physiotherapy"
                {{ old('service_type', $servicePricing->service_type ?? '') == 'Physiotherapy' ? 'selected' : '' }}>
                Physiotherapy</option>
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Number of day</label>
        <input class="form-control" type="number" name="number_of_days"
            value="{{ old('number_of_days', $servicePricing->number_of_days ?? '') }}">
    </div>
    <div class="form-group">
        <label class="form-label">Number of hour</label>
        <input class="form-control" type="number" name="number_of_hours"
            value="{{ old('number_of_hours', $servicePricing->number_of_hours ?? '') }}">
    </div>
    <div class="form-group">
        <label class="form-label">Price<span class="text-danger">*</span></label>
        <input class="form-control" type="number" name="price"
            value="{{ old('price', $servicePricing->price ?? '') }}" required>
    </div>
    <div class="form-group mt-3">
        <label class="form-label">Remarks</label>
        <textarea name="remarks" class="form-control" rows="4">{{ old('remarks', $servicePricing->remarks ?? '') }}</textarea>
    </div>

    <button class="btn btn-primary" type="submit">Submit</button>
</form>
