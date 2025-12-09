<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\StaffPayrollBatch;
use App\Models\StaffPayrollRecord;
use App\Models\StaffPayrollRecordItem;
use App\Models\StaffSalaryAdvance;
use App\Models\StaffAllowance;
use App\Models\StaffOvertime;
use App\Models\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class StaffPayrollBatchController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Staff Payroll Batch'])->only(['index', 'show', 'fetchStaffPayrollRecords', 'staffShow']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Staff Payroll Batch'])->only(['store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Staff Payroll Batch'])->only(['edit', 'update', 'staffEdit', 'staffUpdate', 'approve']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Staff Payroll Batch'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = StaffPayrollBatch::all();
        return view('staff-payroll-batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $month = now()->format('m');
        $year = now()->format('Y');
        $createdBy = auth()->id();
        $today = Carbon::today()->format('Y-m-d');

        // Check if batch exists
        if (StaffPayrollBatch::where('month', $month)
            ->where('year', $year)
            ->exists()
        ) {
            return response()->json([
                'message' => 'Payroll for ' . now()->format('F Y') . ' already exists.'
            ], 409); // 409 Conflict
        }

        // 1. Create new batch
        $batch = StaffPayrollBatch::create([
            'month' => $month,
            'year' => $year,
            'created_by' => $createdBy,
        ]);

        // 2. For each active staff, create payroll record
        $staffList = Staff::with(['currentSalaryStructure', 'overtimes', 'salaryAdvances'])
            ->where('is_active', true)
            ->get();

        foreach ($staffList as $staff) {

            // 3. Create payroll record for each staff
            $payrollRecord = StaffPayrollRecord::create([
                'staff_payroll_batch_id' => $batch->id,
                'staff_id' => $staff->id,
                'basic_salary' => $staff->currentSalaryStructure->base_salary ?? 0,
                'status' => 0,
            ]);

            // 4. Add Base Salary as earning item
            $baseSalary = $staff->currentSalaryStructure->base_salary ?? 0;
            if ($baseSalary > 0) {
                StaffPayrollRecordItem::create([
                    'staff_payroll_record_id' => $payrollRecord->id,
                    'type'        => 1, // earning
                    'description' => 'Earned Salary',
                    'amount'      => $baseSalary,
                ]);
            }

            // 5. Allowances
            $allowances = StaffAllowance::where('salary_structure_id', $staff->currentSalaryStructure->id)
                ->where('effective_from', '<=', $today)
                ->where(function ($query) use ($today) {
                    $query->whereNull('effective_to')->orWhere('effective_to', '>=', $today);
                })->get();

            foreach ($allowances as $allowance) {
                StaffPayrollRecordItem::create([
                    'staff_payroll_record_id' => $payrollRecord->id,
                    'type'        => 1,
                    'description' => 'Allowance: ' . $allowance->allowance_type,
                    'amount'      => $allowance->amount,
                ]);
            }

            // 6. Overtime
            $overtimes = $staff->overtimes()->where('status', 1)->get();
            foreach ($overtimes as $overtime) {
                StaffPayrollRecordItem::create([
                    'staff_payroll_record_id' => $payrollRecord->id,
                    'type'        => 1,
                    'description' => 'Overtime on ' . ($overtime->start_time ? $overtime->start_time->format('Y-m-d') : 'N/A'),
                    'amount'      => $overtime->amount,
                ]);
            }

            // 8. Salary Advances (deductions)
            $salaryAdvances = $staff->salaryAdvances()
                ->where('status', 1)
                ->whereNull('payroll_id')
                ->get();

            foreach ($salaryAdvances as $advance) {
                StaffPayrollRecordItem::create([
                    'staff_payroll_record_id' => $payrollRecord->id,
                    'type'        => 2, // deduction
                    'description' => 'Salary Advance',
                    'amount'      => $advance->amount,
                ]);

                $advance->update(['payroll_id' => $payrollRecord->id]); // mark as used
            }

            // 9. EPF based on total earnings
            $totalEarnings = $payrollRecord->items()->where('type', 1)->sum('amount'); // type 1 =  earnings
            $epfPercentage = $staff->currentSalaryStructure->epf_employee ?? 0;
            $epfDeduction = $totalEarnings * ($epfPercentage / 100);

            if ($epfDeduction > 0) {
                StaffPayrollRecordItem::create([
                    'staff_payroll_record_id' => $payrollRecord->id,
                    'type' => 2, // deduction
                    'description' => 'EPF Employee Contribution',
                    'amount' => $epfDeduction,
                ]);
            }

            // TODO: Add SOCSO, EIS, PCB, etc. here

        }

        return response()->json([
            'message' => 'Payroll for ' . now()->format('F Y') . ' created successfully.',
            'batch_id' => $batch->id
        ]);
    }


    // Show
    public function show(StaffPayrollBatch $staffPayrollBatch)
    {
        $batch = $staffPayrollBatch;
        $staffPayrolls = StaffPayrollRecord::with('staff')->where('staff_payroll_batch_id', $staffPayrollBatch->id)->get();

        return view('staff-payroll-batches.show', compact('batch', 'staffPayrolls'));
    }

    public function approve($id)
    {
        $batch = StaffPayrollBatch::findOrFail($id);

        // Update status
        $batch->status = 1; // Approved
        $batch->save();

        return response()->json([
            'message' => 'Batch approved successfully!',
            'status' => $batch->status,
        ]);
    }

    public function fetchStaffPayrollRecords(Request $request)
    {
        $batchId = $request->input('batch_id');

        $payrollRecords = StaffPayrollRecord::with('staff')
            ->where('staff_payroll_batch_id', $batchId)
            ->get();

        // Format data for DataTables
        $data = $payrollRecords->map(function ($record) {
            return [
                'id' => $record->id,
                'batch_id' => $record->staff_payroll_batch_id,
                'staff_name' => $record->staff->full_name,
                'basic_salary' => number_format($record->basic_salary, 2),
                'overtime_total' => number_format($record->overtime_total, 2),
                'allowances_total' => number_format($record->allowances_total, 2),
                'deductions_total' => number_format($record->deductions_total, 2),
                'net_salary' => number_format($record->net_salary, 2),
                'status' => $record->status_record_label,
                'action' => '',
            ];
        });

        return response()->json(['data' => $data]);
    }


    public function staffShow(StaffPayrollBatch $batch, StaffPayrollRecord $payroll)
    {
        // to show individual staff payroll details
        $payroll->load(['items', 'staff', 'staff.currentSalaryStructure', 'staff.department']);
        return view('staff-payroll-batches.staff_show', compact('batch', 'payroll'));
    }

    public function staffEdit(StaffPayrollBatch $batch, StaffPayrollRecord $payroll)
    {
        // Show the edit form for a specific staff payroll record within a batch
        $earned_salary = $payroll->items()->where('description', 'Earned Salary')->value('amount'); // Get the earned salary 
        $payroll->load(['items', 'staff']);
        return view('staff-payroll-batches.staff_edit', compact('batch', 'payroll', 'earned_salary'));
    }

    public function staffUpdate(Request $request, StaffPayrollBatch $batch, StaffPayrollRecord $payroll)
    {
        $validated = $request->validate([
            'earned_salary' => 'required|numeric|min:0',
        ]);

        // 1. Update or create the related 'Earned Salary' item
        $earnedItem = $payroll->items()->where('description', 'Earned Salary')->first();

        if ($earnedItem) {
            $earnedItem->update(['amount' => $validated['earned_salary']]);
        } else {
            $payroll->items()->create([
                'type' => 1, // earning
                'description' => 'Earned Salary',
                'amount' => $validated['earned_salary'],
            ]);
        }

        // 2. Recalculate EPF based on total earnings
        $totalEarnings = $payroll->items()->where('type', 1)->sum('amount');
        $epfPercentage = $payroll->staff->currentSalaryStructure->epf_employee ?? 0;
        $epfDeduction = $totalEarnings * ($epfPercentage / 100);

        // 3. Update existing EPF based on total earnings
        $epfItem = $payroll->items()->where('description', 'EPF Employee Contribution')->first();

        if ($epfItem) {
            $epfItem->update(['amount' => $epfDeduction]);
        } else {
            $payroll->items()->create([
                'type' => 2,
                'description' => 'EPF Employee Contribution',
                'amount' => $epfDeduction,
            ]);
        }

        return redirect()
            ->route('staff-payroll-batches.staff_show', [$batch, $payroll])
            ->with('success', 'Staff payroll updated successfully.');
    }


    // Generate PDF
    public function downloadPdf($id)
    {
        $payslip = StaffPayrollRecord::with('batch', 'items', 'staff', 'staff.currentSalaryStructure', 'staff.department')->findOrFail($id);
        $month = \Carbon\Carbon::parse($payslip->batch->month)->format('F-Y');
        $pdf = Pdf::loadView('staff-payroll-batches.pdf', compact('payslip', 'month'))->setPaper('A4');


        return $pdf->stream("Payslip-{$month}-{$payslip->staff->full_name}.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffPayrollBatch $staffPayroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffPayrollBatch $staffPayroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffPayrollBatch $staffPayroll)
    {
        //
    }
}
