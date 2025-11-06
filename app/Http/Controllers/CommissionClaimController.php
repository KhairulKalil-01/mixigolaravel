<?php

namespace App\Http\Controllers;

use App\Models\CommissionClaim;
use App\Models\Invoice;
use App\Models\Staff;
use App\Models\ExternalAgent;
use Illuminate\Http\Request;

class CommissionClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('commission-claims.index');
    }

    public function fetchCommissionClaim(Request $request)
    {
        $claims = CommissionClaim::with(['invoice.client', 'staff', 'externalAgent'])->orderBy('created_at', 'desc')->get();

        $claims = $claims->map(function ($claim) {
            // Determine whether it's from staff or external agent
            $claimerType = $claim->staff_id ? 'Staff' : 'External Agent';
            $claimerName = $claim->staff->full_name ?? $claim->externalAgent->name ?? '-';

            return [
                'id' => $claim->id,
                'claim_number' => $claim->claim_number,
                'claimer_type' => $claimerType,
                'claimer_name' => $claimerName,
                'client_name' => $claim->invoice->client->name ?? '-',
                'amount' => $claim->amount,
                'status' => $claim->status_label,
                'created_at' => $claim->created_at->format('Y-m-d'),
            ];
        });

        return response()->json(['data' => $claims]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get invoices without commmission claim
        $staffs = Staff::all();
        $agents = ExternalAgent::all();
        $invoices = Invoice::doesntHave('commissionClaim')->get();
        return view('commission-claims.create', compact('invoices', 'staffs', 'agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* logic for claim_number */
        // Generate the next claim_number
        $latestClaim = CommissionClaim::latest('id')->first(); // get the latest record

        if (!$latestClaim) {
            // if no records exist, start from 1
            $nextNumber = 1;
        } else {
            // extract numeric part from claim_number
            $latestNumber = (int) str_replace('Comm', '', $latestClaim->claim_number);
            $nextNumber = $latestNumber + 1;
        }

        // format to something like CC0001, CC0002, etc.
        $claimNumber = 'Comm' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $validated = $request->validate([
            'staff_id' => 'nullable|required_without:external_agent_id|exists:staffs,id',
            'external_agent_id' => 'nullable|required_without:staff_id|exists:external_agents,id',
            'invoice_id' => 'required|exists:invoices,id',
            'commission_rate' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'submission_remarks' => 'nullable|string',
        ]);

        $validated['claim_number'] = $claimNumber;


        CommissionClaim::create($validated);
        return redirect()->route('commission-claims.index')->with('success', 'Claim submitted.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CommissionClaim $commissionClaim)
    {
        $commissionClaim->load(['invoice.client', 'staff', 'externalAgent']);
        return view('commission-claims.show', compact('commissionClaim'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommissionClaim $commissionClaim)
    {
        if ($commissionClaim->status != 0) { // Not Pending
            return response()->json([
                'success' => false,
                'message' => 'This commission claim has been approved/paid and cannot be deleted.'
            ], 400); // 400 Bad Request
        }

        $commissionClaim->delete();
        return response()->json([
            'success' => true,
            'message' => 'Commission claim deleted successfully.'
        ], 200);
    }
}
