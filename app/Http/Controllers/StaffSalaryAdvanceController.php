<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\StaffSalaryAdvance;
use Illuminate\Http\Request;

class StaffSalaryAdvanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Staff Advance'])->only(['index', 'show', 'fetchStaffAdvances']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Staff Advance'])->only(['create', 'store']);
        //$this->middleware(['auth', PermissionMiddleware::class . ':Edit Staff Advance'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Staff Advance'])->only(['destroy']);
    }

    public function index()
    {
        return view('staff-salary-advances.index');
    }

    public function fetchStaffAdvances()
    {
        $staffId = auth()->user()->staff->id;

        $advances = StaffSalaryAdvance::with('staff:id,full_name')
            ->where('staff_id', $staffId)
            ->get()
            ->map(function ($advance) {
                return [
                    'id' => $advance->id,
                    'staff_name' => $advance->staff->full_name,
                    'amount' => $advance->amount,
                    'status' => $advance->status_label,
                ];
            });
        return response()->json(['data' => $advances]);
    }

    public function create()
    {
        return view('staff-salary-advances.create');
    }

    public function store(Request $request)
    {
        $staffId = auth()->user()->staff->id;

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:10000',
            'request_reason' => 'required|string',
        ]);

        StaffSalaryAdvance::create([
            'staff_id' => $staffId,
            'amount' => $validated['amount'],
            'request_reason' => $validated['request_reason'],
        ]);

        return redirect()->route('staff-salary-advances.index')
            ->with('success', 'Salary advance saved successfully.');
    }

    public function show(StaffSalaryAdvance $staff_salary_advance)
    {
        $advance = $staff_salary_advance->load('staff:id,full_name');
        return view('staff-salary-advances.show', compact('advance'));
    }

    public function destroy(string $id)
    {
        $advance = StaffSalaryAdvance::find($id);

        if ($advance->status != 0) { // Not Pending
            return response()->json([
                'success' => false,
                'message' => 'This advance has been approved/paid and cannot be deleted.'
            ], 400); // 400 Bad Request
        }

        if (!$advance) {
            return response()->json(['success' => false, 'message' => 'Record not found.'], 404);
        }

        $advance->delete();

        return response()->json(['success' => true, 'message' => 'Salary advance deleted successfully.']);
    }
}
