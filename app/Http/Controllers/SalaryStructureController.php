<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\SalaryStructure;
use App\Models\StaffAllowance;
use Illuminate\Support\Carbon;

class SalaryStructureController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Salary Structure'])->only(['index', 'show', 'fetchSalaryStructure']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Salary Structure'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Salary Structure'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Salary Structure'])->only(['destroy']);
    }

    public function index()
    {
        return view('salary-structures.index');
    }

    public function fetchSalaryStructure()
    {
        $today = now();

        $data = SalaryStructure::with('staff')
            ->where('effective_from', '<=', $today)
            ->where(function ($query) use ($today) {
                $query->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', $today);
            })->orderBy('base_salary', 'desc')->get()->map(function ($salary) {
                return [
                    'id' => $salary->id,
                    'staff_id' => $salary->staff_id,
                    'full_name' => $salary->staff->full_name ?? '',
                    'base_salary' => $salary->base_salary,
                    'epf_employee' => $salary->epf_employee,
                    'epf_employer' => $salary->epf_employer,
                    'effective_from' => $salary->effective_from
                        ? $salary->effective_from->format('d-m-Y')
                        : null,
                    'effective_to' => $salary->effective_to
                        ? $salary->effective_to->format('d-m-Y')
                        : 'Present',
                ];
            });

        return response()->json(['data' => $data]);
    }

    public function show($id)
    {
        $staff = Staff::findOrFail($id);

        $salary_history = $staff->salaryStructures()
            ->with('allowances')
            ->orderBy('effective_to', 'asc')
            ->get();

        $current_salary = $salary_history
            ->firstWhere(function ($s) {
                return $s->effective_to === null || $s->effective_to >= now();
            });

        return view('salary-structures.show', compact('staff', 'current_salary', 'salary_history'));
    }

    public function edit(SalaryStructure $salary_structure)
    {
        $salary_structure->load('allowances');

        return view('salary-structures.edit', compact('salary_structure'));
    }

    public function update(Request $request, SalaryStructure $salaryStructure)
    {
        $staffId = $salaryStructure->staff_id;

        // End the current record
        $salaryStructure->update([
            'effective_to' => Carbon::yesterday(),
        ]);

        // Create a new record
        $newSalaryStructure = SalaryStructure::create([
            'staff_id' => $staffId,
            'base_salary' => $request->base_salary,
            'epf_employee' => $request->epf_employee,
            'epf_employer' => $request->epf_employer,
            'work_day_per_week' => $request->work_day_per_week,
            'work_hour_per_day' => $request->work_hour_per_day,
            'effective_from' => Carbon::today(),
            'effective_to' => null,
        ]);

        // End the current allowances for this salary structure
        StaffAllowance::where('salary_structure_id', $salaryStructure->id)
            ->update(['effective_to' => Carbon::yesterday()]);

        // Create new allowance records (if provided in request)
        if ($request->has('allowances') && !empty($request->allowances)) {
            foreach ($request->allowances as $allowance) {
                // Skip empty rows (e.g., no type, no amount)

                if (!empty($allowance['type']) && !empty($allowance['amount'])) {
                    StaffAllowance::create([
                        'salary_structure_id' => $newSalaryStructure->id,
                        'allowance_type' => $allowance['type'],
                        'amount' => $allowance['amount'],
                        'effective_from' => Carbon::today(),
                        'effective_to' => null,
                    ]);
                }
            }
        }

        return redirect()->route('salary-structures.index')->with('success', 'Salary structure updated successfully.');
    }
}
