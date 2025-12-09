<?php

namespace App\Http\Controllers;

use App\Models\ExternalAgent;
use App\Models\BankList;
use Illuminate\Http\Request;

class ExternalAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('external-agents.index');
    }

    public function fetchExternalAgent(Request $request)
    {
        $agents = ExternalAgent::all();

        return response()->json([
            'data' => $agents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banks = BankList::all();
        return view('external-agents.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'mobileno' => 'nullable|string|max:20',
            'tax_no' => 'required|string|max:225',
            'bank_id' => 'nullable|exists:bank_lists,id',
            'bank_acc_no' => 'nullable|string|max:255',

        ]);

        ExternalAgent::create($validated);
        return redirect()->route('external-agents.index')->with('success', 'Agent created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExternalAgent $externalAgent)
    {
        $agent = $externalAgent;
        return view('external-agents.show', compact('agent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalAgent $externalAgent)
    {
        $agent = $externalAgent;
        $banks = BankList::all();
        return view('external-agents.edit', compact('agent', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalAgent $externalAgent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'mobileno' => 'nullable|string|max:20',
            'tax_no' => 'required|string|max:255',
            'bank_id' => 'nullable|exists:bank_lists,id',
            'bank_acc_no' => 'nullable|string|max:255',
        ]);

        $externalAgent->update($validated);

        return redirect()
            ->route('external-agents.index')
            ->with('success', 'Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalAgent $externalAgent)
    {
        //
    }
}
