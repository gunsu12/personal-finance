<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spendings = \App\Models\Spending::with(['budgetItem', 'budgetItem.budget', 'merchant'])->latest('spending_date')->get();
        return view('spendings.index', compact('spendings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get budgets ordered by period (Year desc, Month desc)
        $budgets = \App\Models\Budget::where('user_id', auth()->id())
            ->with('budgetItems')
            ->orderBy('year', 'desc')
            ->orderBy('month_periode', 'desc')
            ->get();
            
        // Attempt to find a default budget item from the current month's budget
        $currentDate = now();
        $currentBudget = $budgets->first(function ($budget) use ($currentDate) {
            return $budget->year == $currentDate->year && $budget->month_periode == $currentDate->month;
        });

        $defaultBudgetItemId = null;
        if ($currentBudget && $currentBudget->budgetItems->isNotEmpty()) {
            $defaultBudgetItemId = $currentBudget->budgetItems->first()->id;
        }

        $merchants = \App\Models\Merchant::where('user_id', auth()->id())->orderBy('name')->get();

        return view('spendings.create', compact('budgets', 'defaultBudgetItemId', 'merchants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'spending_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'merchant_id' => 'nullable|exists:merchants,id',
            'transaction_methods' => 'required|in:cash,credit_card,debit_card,transfer,ewallet,qris',
        ]);

        \App\Models\Spending::create($request->all());

        return redirect()->route('spendings.index')->with('success', 'Spending recorded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $spending = \App\Models\Spending::findOrFail($id);
        return view('spendings.show', compact('spending'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $spending = \App\Models\Spending::findOrFail($id);
        $budgets = \App\Models\Budget::where('user_id', auth()->id())->with('budgetItems')->latest()->get();
        $merchants = \App\Models\Merchant::where('user_id', auth()->id())->orderBy('name')->get();
        return view('spendings.edit', compact('spending', 'budgets', 'merchants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $spending = \App\Models\Spending::findOrFail($id);

        $request->validate([
            'spending_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'merchant_id' => 'nullable|exists:merchants,id',
            'transaction_methods' => 'required|in:cash,credit_card,debit_card,transfer,ewallet,qris',
        ]);

        $spending->update($request->all());

        return redirect()->route('spendings.index')->with('success', 'Spending updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $spending = \App\Models\Spending::findOrFail($id);
        $spending->delete();

        return redirect()->route('spendings.index')->with('success', 'Spending deleted successfully');
    }
}
