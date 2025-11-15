<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::all();
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,select,radio,checkbox',
            'options' => 'nullable|array',
        ]);

        $attribute = Attribute::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        if ($request->has('options')) {
            foreach ($request->options as $option) {
                if($option) {
                    $attribute->options()->create(['value' => $option]);
                }
            }
        }

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,select,radio,checkbox',
            'options' => 'nullable|array',
        ]);

        $attribute->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        $attribute->options()->delete();

        if ($request->has('options')) {
            foreach ($request->options as $option) {
                if($option) {
                    $attribute->options()->create(['value' => $option]);
                }
            }
        }

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted successfully.');
    }
}
