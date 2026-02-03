<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = \App\Models\Budget::where('user_id', auth()->id())->latest()->get();
        return view('budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('budgets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'month_periode' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
            'description' => 'required|string',
        ]);

        \App\Models\Budget::create([
            'user_id' => auth()->id(),
            'month_periode' => $request->month_periode,
            'year' => $request->year,
            'description' => $request->description,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget plan created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $budget = \App\Models\Budget::with('budgetItems')->where('user_id', auth()->id())->findOrFail($id);
        return view('budgets.show', compact('budget'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $budget = \App\Models\Budget::where('user_id', auth()->id())->findOrFail($id);
        return view('budgets.edit', compact('budget'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $budget = \App\Models\Budget::where('user_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'month_periode' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
            'description' => 'required|string',
        ]);

        $budget->update($request->only('month_periode', 'year', 'description'));

        return redirect()->route('budgets.index')->with('success', 'Budget plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $budget = \App\Models\Budget::where('user_id', auth()->id())->findOrFail($id);
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget plan deleted successfully');
    }
}
