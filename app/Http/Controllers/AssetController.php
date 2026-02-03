<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = \App\Models\Asset::where('user_id', auth()->id())->latest()->get();
        // Calculate Total Assets Value
        $totalWealth = $assets->sum('sub_total');
        
        return view('assets.index', compact('assets', 'totalWealth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:gold,fund,stock,bonds,deposito,saving,cash',
            'title' => 'required|string|max:255',
            'qty' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:0',
            'expected_return' => 'nullable|numeric',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['expected_return'] = $request->expected_return ?? 0;

        \App\Models\Asset::create($data);

        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $asset = \App\Models\Asset::where('user_id', auth()->id())->with('logs')->findOrFail($id);
         return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asset = \App\Models\Asset::where('user_id', auth()->id())->findOrFail($id);
        return view('assets.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asset = \App\Models\Asset::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'type' => 'required|in:gold,fund,stock,bonds,deposito,saving,cash',
            'title' => 'required|string|max:255',
            'qty' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:0',
            'expected_return' => 'nullable|numeric',
        ]);

        $asset->update($request->all());

        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asset = \App\Models\Asset::where('user_id', auth()->id())->findOrFail($id);
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
    }
}
