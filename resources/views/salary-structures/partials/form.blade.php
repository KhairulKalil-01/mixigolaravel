<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Base Salary -->
    <div class="form-group">
        <label class="form-label" for="base_salary">Base Salary</label>
        <input type="number" name="base_salary" id="base_salary" class="form-control"
            value="{{ old('base_salary', $salary_structure->base_salary ?? '') }}">
    </div>

    <!-- Work Day Per Week -->
    <div class="form-group">
        <label class="form-label" for="work_day_per_week">Work Day Per Week</label>
        <input type="number" name="work_day_per_week" id="work_day_per_week" class="form-control"
            value="{{ old('work_day_per_week', $salary_structure->work_day_per_week ?? '') }}">
    </div>

    <!-- Work Hour Per Day -->
    <div class="form-group">
        <label class="form-label" for="work_hour_per_day">Work Hour Per Day</label>
        <input type="number" name="work_hour_per_day" id="work_hour_per_day" class="form-control"
            value="{{ old('work_hour_per_day', $salary_structure->work_hour_per_day ?? '') }}">
    </div>

    <!-- Employee EPF -->
    <div class="form-group">
        <label class="form-label" for="epf_employee">Employee EPF Contribution (%)</label>
        <input type="number" name="epf_employee" id="epf_employee" class="form-control" min="11" max="60"
            step="0.1" value="{{ old('epf_employee', $salary_structure->epf_employee ?? '') }}">
    </div>

    <!-- Employer EPF -->
    <div class="form-group">
        <label class="form-label" for="epf_employer">Employer EPF Contribution (%)</label>
        <input type="number" name="epf_employer" id="epf_employer" class="form-control" min="13" max="19"
            step="0.1" value="{{ old('epf_employer', $salary_structure->epf_employer ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="socso_employee">SOCSO (Employee)</label>
        <input type="number" name="socso_employee" id="socso_employee" class="form-control"
            value="{{ old('socso_employee', $salaryStructure->socso_employee ?? 0) }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="socso_employer">SOCSO (Employer)</label>
        <input type="number" name="socso_employer" id="socso_employer" class="form-control"
            value="{{ old('socso_employer', $salaryStructure->socso_employer ?? 0) }}">
    </div>

    <button class="btn btn-primary" type="submit">Submit</button>
</form>
