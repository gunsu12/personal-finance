<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashFlows = \App\Models\CashFlow::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('cash-flows.index', compact('cashFlows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cash-flows.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:debit,credit',
            'group' => 'required|in:revenue,spending,bonds,others',
            'amount' => 'required|numeric|min:0',
            'transaction_notes' => 'nullable|string',
            'transaction_refference' => 'nullable|string',
        ]);

        \App\Models\CashFlow::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'group' => $request->group,
            'amount' => $request->amount,
            'transaction_notes' => $request->transaction_notes,
            'transaction_refference' => $request->transaction_refference,
        ]);

        return redirect()->route('cash-flows.index')
            ->with('success', 'Cash Flow record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cashFlow = \App\Models\CashFlow::where('user_id', auth()->id())->findOrFail($id);
        return view('cash-flows.show', compact('cashFlow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cashFlow = \App\Models\CashFlow::where('user_id', auth()->id())->findOrFail($id);
        return view('cash-flows.edit', compact('cashFlow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cashFlow = \App\Models\CashFlow::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'type' => 'required|in:debit,credit',
            'group' => 'required|in:revenue,spending,bonds,others',
            'amount' => 'required|numeric|min:0',
            'transaction_notes' => 'nullable|string',
            'transaction_refference' => 'nullable|string',
        ]);

        $cashFlow->update([
            'type' => $request->type,
            'group' => $request->group,
            'amount' => $request->amount,
            'transaction_notes' => $request->transaction_notes,
            'transaction_refference' => $request->transaction_refference,
        ]);

        return redirect()->route('cash-flows.index')
            ->with('success', 'Cash Flow record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cashFlow = \App\Models\CashFlow::where('user_id', auth()->id())->findOrFail($id);
        $cashFlow->delete();

        return redirect()->route('cash-flows.index')
            ->with('success', 'Cash Flow record deleted successfully.');
    }
}
