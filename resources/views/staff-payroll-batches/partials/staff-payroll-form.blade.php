{{-- show any error --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    {{-- Staff Information --}}
    <h5 class="mb-3">Staff Payroll</h5>
    <br>

    <!-- Earned Salary -->
    <div class="form-group">
        <label class="form-label">Earned Salary (RM) <span class="text-danger">* </span></label>
        <input type="number" name="earned_salary" class="form-control" value="{{ old('amount', $earned_salary ?? '') }}" required>
    </div>


    <!-- Submit Button -->
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Update Payroll</button>
    </div>
</form>
