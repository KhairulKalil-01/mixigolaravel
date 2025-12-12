<?php

namespace App\Http\Controllers;

use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Caregiver;
use App\Models\Branch;
use App\Models\BankList;
use Illuminate\Http\Request;
use App\EmploymentType;
use Carbon\Carbon;

class CaregiverController extends Controller
{
    public function __construct()
    {
        //Spaties Permission Middleware
        $this->middleware(['auth', PermissionMiddleware::class . ':View Caregiver'])->only(['index', 'show', 'fetchCaregiver']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Caregiver'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Caregiver'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Caregiver'])->only(['destroy']);
    }

    public function index()
    {
        return view('caregivers.index');
    }

    public function fetchCaregiver(Request $request)
    {
        $caregivers = Caregiver::with('branch')->get();

        $caregivers = $caregivers->map(function ($caregiver) {
            $employmentTypeEnum = EmploymentType::tryFrom($caregiver->employment_type);
            return [
                'id' => $caregiver->id,
                'branch_name' => $caregiver->branch->branch_name ?? '-',
                'name' => $caregiver->name,
                'mobileno' => $caregiver->mobileno,
                'employment_type' => $employmentTypeEnum?->label() ?? 'Unknown',
                'nationality' => $caregiver->nationality,
            ];
        });
        return response()->json(['data' => $caregivers]);
    }

    // API to get available caregivers within a datetime range
    public function available(Request $request)
    {
        $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $start = Carbon::parse($request->start_datetime);
        $end = Carbon::parse($request->end_datetime);

        $caregivers = Caregiver::whereDoesntHave('jobs', function ($q) use ($start, $end) {
            $q->where(function ($q2) use ($start, $end) {
                $q2->whereBetween('start_datetime', [$start, $end])
                    ->orWhereBetween('end_datetime', [$start, $end])
                    ->orWhere(function ($q3) use ($start, $end) {
                        $q3->where('start_datetime', '<', $start)
                            ->where('end_datetime', '>', $end);
                    });
            });
        })->select('id', 'name', 'payout_per_hour')->get();

        return response()->json(['data' => $caregivers]);
    }

    // API to get all caregivers
    public function getCaregivers(Request $request)
    {
        $caregivers = Caregiver::select('id', 'name', 'rate_per_hour')
        ->where('is_active', 1)
        ->get();
        return response()->json(['data' => $caregivers]);
    }


    public function create()
    {
        $branches = Branch::all();
        $banks = BankList::all();
        return view('caregivers.create', compact('branches', 'banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'branch_id' => 'required|int',
            'sex' => 'required|string|max:225',
            'name' => 'required|string|max:225',
            'ic_num' => 'required|string|max:255',
            'passport' => 'required|string|max:255',
            'email' => 'nullable|email|max:225',
            'mobileno' => 'required|string|max:20',
            'bank_list_id' => 'nullable|int|max:20',
            'bank_num' => 'nullable|string|max:255',
            'is_available' => 'nullable|int',
            'is_active' => 'nullable|int',
            'employment_type' => 'nullable|int',
            'employment_date' => 'nullable|date',
            'rate_per_hour' => 'nullable|numeric|min:0',
            'qualification' => 'nullable|string|max:255',
            'emergency_name' => 'nullable|string|max:255',
            'emergency_no' => 'nullable|string|max:20',
            'permanent_address' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'current_address' => 'required|string|max:225',
            'current_city' => 'required|string|max:225',
            'current_state' => 'nullable|string|max:255',
        ]);

        Caregiver::create($validated);
        return redirect()->route('caregivers.index')->with('success', 'Caregiver created.');
    }

    public function show(string $id)
    {
        $caregiver = Caregiver::findOrFail($id);
        return view('caregivers.show', compact('caregiver'));
    }


    public function edit(string $id)
    {
        $caregiver = Caregiver::findOrFail($id);
        $branches = Branch::all();
        $banks = BankList::all();
        return view('caregivers.edit', compact('caregiver', 'branches', 'banks'));
    }

    public function update(Request $request, Caregiver $caregiver)
    {
        $validated = $request->validate([
            'branch_id' => 'required|int',
            'sex' => 'required|string|max:225',
            'name' => 'required|string|max:225',
            'ic_num' => 'required|string|max:255',
            'passport' => 'required|string|max:255',
            'email' => 'nullable|email|max:225',
            'mobileno' => 'required|string|max:20',
            'bank_list_id' => 'nullable|int|max:20',
            'bank_num' => 'nullable|string|max:255',
            'is_available' => 'nullable|int',
            'is_active' => 'nullable|int',
            'employment_type' => 'nullable|int',
            'employment_date' => 'nullable|date',
            'rate_per_hour' => 'nullable|numeric|min:0',
            'qualification' => 'nullable|string|max:255',
            'emergency_name' => 'nullable|string|max:255',
            'emergency_no' => 'nullable|string|max:20',
            'permanent_address' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'current_address' => 'required|string|max:225',
            'current_city' => 'required|string|max:225',
            'current_state' => 'nullable|string|max:255',
        ]);

        $caregiver->update($validated);

        return redirect()->route('caregivers.index')->with('success', 'Caregiver updated.');
    }

    public function destroy(string $id)
    {
        $caregiver = Caregiver::findOrFail($id);
        $caregiver->delete();

        return response()->json(['message' => 'Caregiver deleted successfully.']);
    }
}
