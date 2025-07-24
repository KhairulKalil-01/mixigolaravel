<?php

namespace App\Http\Controllers;

use App\Models\BankList;
use App\Models\Refund;
use Illuminate\Http\Request;
use App\Models\CreditNote;
use Barryvdh\DomPDF\Facade\Pdf;

class RefundController extends Controller
{
    public function index()
    {
        $refunds =  Refund::all();
        return view('refunds.index', compact('refunds'));
    }

    public function fetchRefund()
    {
        $refunds = Refund::with('invoice.client')->orderBy('created_at', 'desc')->get();

        $refunds = $refunds->map(function ($refund) {
            return [
                'id' => $refund->id,
                'refund_number' => $refund->refund_number,
                'client_name' => $refund->invoice->client->name ?? '-',
                'amount' => $refund->amount,
                'status' => $refund->status,
            ];
        });

        return response()->json(['data' => $refunds]);
    }

    public function create()
    {
        $credit_notes = CreditNote::all();
        $banks = BankList::all();
        return view('refunds.create', compact('credit_notes', 'banks'));
    }

    public function store(Request $request)
    {
        $year = now()->year;

        // Generate refund number
        $lastRefund = Refund::whereYear('created_at', $year)->orderBy('refund_number', 'desc')->first();

        if ($lastRefund && preg_match('/Refund-' . $year . '-(\d+)/', $lastRefund->refund_number, $matches)) {
            $sequence = (int) $matches[1] + 1;
        } else {
            $sequence = 1;
        }

        $refund_number = 'Refund-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Validate input based on form fields
        $validated = $request->validate([
            'credit_note_id' => 'required|exists:credit_notes,id',
            'status' => 'required|in:1,2',
            'refund_date' => 'required|date',
            'reason_type' => 'required|integer|in:1,2,3',
            'bank_id' => 'nullable|exists:bank_lists,id',
            'bank_account' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        $validated['invoice_id'] = CreditNote::findOrFail($validated['credit_note_id'])->invoice_id;
        $validated['refund_number'] = $refund_number;

        Refund::create($validated);

        return redirect()->route('refunds.index')->with('success', 'Refund created successfully.');
    }

    public function show($id)
    {
        $refund = Refund::with('creditNote')->findOrFail($id);
        return view('refunds.show', compact('refund'));
    }

    // Generate PDF
    public function downloadPdf($id)
    {
        $refund = Refund::with('creditNote')->findOrFail($id);
        $pdf = Pdf::loadView('refunds.pdf', compact('refund'))->setPaper('A4');

        //return $pdf->download("Quotation-{$quotation->quotation_number}.pdf");
        return $pdf->stream('Refund-' . $refund->refund_number . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $refund = Refund::findOrFail($id);
        $credit_notes = CreditNote::with('client')->get();
        $banks = BankList::all();

        return view('refunds.edit', compact('refund', 'credit_notes', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $refund = Refund::findOrFail($id);

        // Validate input based on form fields
        $validated = $request->validate([
            'credit_note_id' => 'required|exists:credit_notes,id',
            'status' => 'required|in:1,2',
            'refund_date' => 'required|date',
            'reason_type' => 'required|integer|in:1,2,3',
            'bank_id' => 'nullable|exists:bank_lists,id',
            'bank_account' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        $validated['invoice_id'] = CreditNote::findOrFail($validated['credit_note_id'])->invoice_id;

        $refund->update($validated);

        return redirect()->route('refunds.index')->with('success', 'Refund updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Refund $refund)
    {
        //
    }
}
