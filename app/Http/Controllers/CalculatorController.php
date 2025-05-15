<?php

namespace App\Http\Controllers;

use App\Models\Calculator;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        $calculators = Calculator::all();
        return view('calculators.index', compact('calculators'));
    }

    public function create()
    {
        return view('calculators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:calculators,slug',
            'description' => 'nullable|string',
            'is_visible' => 'boolean',
            'settings' => 'nullable|array',
        ]);

        $validated['settings'] = $request->settings ? json_encode($request->settings) : null;

        Calculator::create($validated);

        return redirect()->route('calculators.index')->with('success', 'Calculator created successfully.');
    }

    public function show(Calculator $calculator)
    {
        $calculators = Calculator::where('is_visible', true)->get();

        return view('calculators.show', compact('calculator'));
    }

    public function edit(Calculator $calculator)
    {
        return view('calculators.edit', compact('calculator'));
    }

    public function update(Request $request, Calculator $calculator)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:calculators,slug,' . $calculator->id,
            'description' => 'nullable|string',
            'is_visible' => 'boolean',
            'settings' => 'nullable|array',
        ]);

        $validated['settings'] = $request->settings ? json_encode($request->settings) : null;

        $calculator->update($validated);

        return redirect()->route('calculators.index')->with('success', 'Calculator updated successfully.');
    }

    public function destroy(Calculator $calculator)
    {
        $calculator->delete();

        return redirect()->route('calculators.index')->with('success', 'Calculator deleted successfully.');
    }
}
