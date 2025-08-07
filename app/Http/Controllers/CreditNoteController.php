<?php

namespace App\Http\Controllers;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\CreditNote;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\CreditNoteStatus;;
use Barryvdh\DomPDF\Facade\Pdf;

class CreditNoteController extends Controller
{

    public function index()
    {
        $credit_notes = CreditNote::all();
        return view('credit-notes.index', compact('credit_notes'));
    }

    public function fetchCreditNote()
    {
        $credit_notes = CreditNote::with('invoice')->orderBy('created_at', 'desc')->get();

        $credit_notes = $credit_notes->map(function ($credit_notes) {
            return [
                'id' => $credit_notes->id,
                'credit_note_number' => $credit_notes->credit_note_number,
                'invoice_number' => $credit_notes->invoice->invoice_number,
                'client_name' => $credit_notes->invoice->client->name ?? '-',
                'credit_amount' => $credit_notes->credit_amount,

            ];
        });

        return response()->json(['data' => $credit_notes]);
    }

    public function create()
    {
        $invoices = Invoice::all();
        $statuses = CreditNoteStatus::cases();
        return view('credit-notes.create', compact('invoices', 'statuses'));
    }


    public function store(Request $request)
    {
        $year = now()->year;

        // Get latest invoice number
        $lastCreditNote = CreditNote::whereYear('created_at', $year)->orderBy('credit_note_number', 'desc')->first();

        if ($lastCreditNote && preg_match('/CN-' . $year . '-(\d+)/', $lastCreditNote->credit_note_number, $matches)) {
            $sequence = (int) $matches[1] + 1;
        } else {
            $sequence = 1;
        }

        $creditNoteNumber = 'CN-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'credit_note_date' => 'required|date',
            'credit_amount' => 'required|numeric|min:0',
            'reason_type' => 'nullable|integer',
            'status' => 'required|integer|in:0,1,2',
            'remarks' => 'nullable|string|max:255',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);
        $validated['client_id'] = $invoice->client_id;
        $validated['credit_note_number'] = $creditNoteNumber;

        $creditNote = CreditNote::create($validated);
    }


    public function show($id)
    {
        $credit_note = CreditNote::with('invoice')->findOrFail($id);
        return view('credit-notes.show', compact('credit_note'));
    }

    // Generate PDF
    public function downloadPdf($id)
    {
        $credit_note = CreditNote::with('invoice')->findOrFail($id);
        $pdf = Pdf::loadView('credit-notes.pdf', compact('credit_note'))->setPaper('A4');

        //return $pdf->download("Quotation-{$quotation->quotation_number}.pdf");
        return $pdf->stream('Credit Note-' . $credit_note->credit_note_number . '.pdf');
    }


    public function edit($id)
    {
        $invoices = Invoice::all();
        $credit_note = CreditNote::findOrFail($id);
        $statuses = CreditNoteStatus::cases();

        return view('credit-notes.edit', compact('invoices', 'credit_note', 'statuses'));
    }


    public function update(Request $request, $id)
    {
        $credit_note = CreditNote::findOrFail($id);

        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'credit_note_date' => 'required|date',
            'credit_amount' => 'required|numeric|min:0',
            'reason_type' => 'nullable|integer',
            'status' => 'required|integer|in:0,1,2',
            'remarks' => 'nullable|string|max:255',
        ]);

        $credit_note->update($validated);
        return redirect()->route('credit-notes.index')->with('success', 'Credit Note updated.');
    }


    public function destroy($id)
    {
        $credit_note = CreditNote::findOrFail($id);
        $credit_note->delete();

        return response()->json(['message' => 'Invoice deleted successfully.']);
    }
}
