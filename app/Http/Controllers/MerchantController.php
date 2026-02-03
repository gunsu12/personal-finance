<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merchants = Merchant::where('user_id', auth()->id())->latest()->get();
        return view('merchants.index', compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merchants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        Merchant::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return redirect()->route('merchants.index')->with('success', 'Merchant created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant)
    {
        return view('merchants.show', compact('merchant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merchant $merchant)
    {
        return view('merchants.edit', compact('merchant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Merchant $merchant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $merchant->update($request->only('name', 'category'));

        return redirect()->route('merchants.index')->with('success', 'Merchant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merchant $merchant)
    {
        $merchant->delete();

        return redirect()->route('merchants.index')->with('success', 'Merchant deleted successfully');
    }
}
