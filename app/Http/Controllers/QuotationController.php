<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Client;
use App\Models\Patient;
use App\Models\ServicePricing;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QuotationController extends Controller
{

    public function index()
    {
        $quotations = Quotation::all();
        return view('quotations.index', compact('quotations'));
    }

    public function fetchQuotation(Request $request)
    {
        $quotations = Quotation::all();

        return response()->json([
            'data' => $quotations
        ]);
    }

    public function create()
    {
        $clients = Client::all();
        $patients = Patient::all();
        $servicePricings = ServicePricing::all();

        return view('quotations.create', compact('clients', 'patients', 'servicePricings'));
    }

    public function store(Request $request)
    {
        $year = now()->year;

        // Get the latest quotation number for this year
        $lastQuotation = Quotation::whereYear('created_at', $year)->orderBy('quotation_number', 'desc')->first();

        if ($lastQuotation && preg_match('/QUO-' . $year . '-(\d+)/', $lastQuotation->quotation_number, $matches)) {
            $sequence = (int) $matches[1] + 1;
        } else {
            $sequence = 1;
        }

        $quotationNumber = 'QTN-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Proceed to validate and create the quotation
        $validated = $request->validate([
            //drop service_start_date
            'client_id' => 'required|exists:clients,id',
            'patient_id' => 'nullable|exists:clients,id',
            

        ]);

        $validated['quotation_number'] = $quotationNumber;

        Quotation::create($validated);

        return redirect()->route('quotations.index')->with('success', 'Quotation created.');
    }

    public function show(string $id)
    {
        $quotation = Quotation::findOrFail($id);
        return view('quotations.show', compact('quotation'));
    }


    public function edit(string $id)
    {
        $quotation = Quotation::findOrFail($id);
        return view('quotations.edit', compact('quotation'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobileno' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:255',
        ]);

        $quotation->update($validated);

        return redirect()->route('quotations.index')->with('success', 'Quotation updated.');
    }

    public function destroy(string $id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();

        return response()->json(['message' => 'Quotation deleted successfully.']);
    }
}
