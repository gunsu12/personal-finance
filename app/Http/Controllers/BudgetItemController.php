<?php

namespace App\Http\Controllers;

use App\Models\BudgetItem;
use Illuminate\Http\Request;

class BudgetItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, \App\Models\Budget $budget)
    {
        $request->validate([
            'description' => 'required|string',
            'type' => 'required|in:konsumsi,sewa,pakaian,utilitas,hiburan,lainnya',
            'amount' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
        ]);

        $budget->budgetItems()->firstOrCreate(
            $request->only(['description', 'type', 'amount', 'qty'])
        );

        return redirect()->route('budgets.show', $budget->id)->with('success', 'Item added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetItem $item)
    {
        // $item is implicitly bound due to shallow routing? No, route is 'items/{item}/edit'
        // But the param name in route:resource shallow is tricky.
        // It uses singular of resource name. 'items' -> 'item'. 
        // Laravel default param is {item}.
        return view('budget_items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BudgetItem $item)
    {
        $request->validate([
            'description' => 'required|string',
            'type' => 'required|in:konsumsi,sewa,pakaian,utilitas,hiburan,lainnya',
            'amount' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
        ]);

        $item->update($request->all());

        return redirect()->route('budgets.show', $item->budget_id)->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetItem $item)
    {
        $budget_id = $item->budget_id;
        $item->delete();

        return redirect()->route('budgets.show', $budget_id)->with('success', 'Item deleted successfully');
    }
}
