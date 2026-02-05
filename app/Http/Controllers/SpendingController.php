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

        // Calculate Totals for Current Month
        $currentMonthBudget = \App\Models\Budget::where('user_id', auth()->id())
            ->where('year', now()->year)
            ->where('month_periode', now()->month)
            ->sum('total_budget');

        $currentMonthSpending = \App\Models\Spending::whereMonth('spending_date', now()->month)
            ->whereYear('spending_date', now()->year)
            ->sum('amount');

        return view('spendings.index', compact('spendings', 'currentMonthBudget', 'currentMonthSpending'));
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
            'budget_item_id' => 'nullable|exists:budget_items,id',
        ]);

        // Validation: Check if budget is for the correct month/year
        if ($request->budget_item_id) {
            $budgetItem = \App\Models\BudgetItem::with('budget')->find($request->budget_item_id);
            $spendingDate = \Carbon\Carbon::parse($request->spending_date);

            if ($budgetItem && $budgetItem->budget) {
                if ((int) $budgetItem->budget->month_periode !== (int) $spendingDate->month ||
                    (int) $budgetItem->budget->year !== (int) $spendingDate->year) {
                    return back()->with('error', 'The selected budget item does not belong to the spending date period ('.$spendingDate->format('M Y').').')->withInput();
                }
            }
        }

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                $spending = \App\Models\Spending::create($request->all());

                // Automatically create (catat) in cashflow
                \App\Models\CashFlow::create([
                    'user_id' => auth()->id(),
                    'type' => 'credit',
                    'group' => 'spending',
                    'amount' => $spending->amount,
                    'transaction_notes' => $spending->notes ? 'Spending: '.$spending->notes : 'Spending',
                    'transaction_refference' => $spending->code,
                ]);
            });

            return redirect()->route('spendings.create')->with('success', 'Spending recorded successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to record spending: '.$e->getMessage())->withInput();
        }
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

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($request, $spending) {
                // 1. Reversal (Debit) of OLD amount BEFORE update
                \App\Models\CashFlow::create([
                    'user_id' => auth()->id(),
                    'type' => 'debit', // Reversal = Money Back
                    'group' => 'spending',
                    'amount' => $spending->amount,
                    'transaction_notes' => 'Correction for '.$spending->code,
                    'transaction_refference' => $spending->code,
                ]);

                // 2. Update Spending
                $spending->update($request->all());

                // 3. New Entry (Credit) of NEW amount
                \App\Models\CashFlow::create([
                    'user_id' => auth()->id(),
                    'type' => 'credit', // New Spending
                    'group' => 'spending',
                    'amount' => $spending->amount,
                    'transaction_notes' => $spending->notes ? 'Spending (Updated): '.$spending->notes : 'Spending (Updated)',
                    'transaction_refference' => $spending->code,
                ]);
            });

            return redirect()->route('spendings.index')->with('success', 'Spending updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update spending: '.$e->getMessage())->withInput();
        }
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
