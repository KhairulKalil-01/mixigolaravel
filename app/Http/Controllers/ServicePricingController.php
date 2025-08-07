<?php

namespace App\Http\Controllers;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\ServicePricing;
use Illuminate\Http\Request;

class ServicePricingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', PermissionMiddleware::class . ':View Service Pricings'])->only(['index', 'show', 'fetchServicePricings']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Create Service Pricings'])->only(['create', 'store']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Edit Service Pricings'])->only(['edit', 'update']);
        $this->middleware(['auth', PermissionMiddleware::class . ':Delete Service Pricings'])->only(['destroy']);
    }

    public function index()
    {
        $servicePricings = ServicePricing::all();
        return view('service-pricings.index', compact('servicePricings'));
    }

    public function fetchServicePricings(Request $request)
    {
        $servicePricings = ServicePricing::all();

        return response()->json([
            'data' => $servicePricings
        ]);
    }

    public function create()
    {
        return view('service-pricings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:225',
            'service_type' => 'required|string|max:225',
            'number_of_days' => 'nullable|integer|min:1',
            'number_of_hours' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        ServicePricing::create($validated);
        return redirect()->route('service-pricings.index')->with('success', 'Service Pricing created.');
    }

    public function show(string $id)
    {
        $servicePricing = ServicePricing::findOrFail($id);
        return view('service-pricings.show', compact('servicePricing'));
    }


    public function edit(string $id)
    {
        $servicePricing = ServicePricing::findOrFail($id);
        return view('service-pricings.edit', compact('servicePricing'));
    }

    public function update(Request $request, ServicePricing $servicePricing)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:225',
            'service_type' => 'required|string|max:225',
            'number_of_days' => 'nullable|integer|min:1',
            'number_of_hours' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        $servicePricing->update($validated);

        return redirect()->route('service-pricings.index')->with('success', 'Service Pricing updated.');
    }

    public function destroy(string $id)
    {
        $servicePricing = ServicePricing::findOrFail($id);
        $servicePricing->delete();

        return response()->json(['message' => 'Service Pricing deleted successfully.']);
    }
}
