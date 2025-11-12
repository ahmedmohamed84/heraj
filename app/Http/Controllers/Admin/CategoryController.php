<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attribute; // Import the Attribute model

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parent')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::all(); // Get all attributes
        return view('admin.categories.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'attributes' => ['nullable', 'array'], // Validate attributes as an array
            'attributes.*.id' => ['required_with:attributes', 'exists:attributes,id'],
            'attributes.*.value' => ['nullable', 'string'],
        ]);

        $category = Category::create($request->only(['name', 'description', 'parent_id']));

        // Sync attributes
        if ($request->has('attributes')) {
            $syncData = [];
            foreach ($request->attributes as $attributeData) {
                $syncData[$attributeData['id']] = ['value' => $attributeData['value'] ?? null];
            }
            $category->attributes()->sync($syncData);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
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
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        $attributes = Attribute::all(); // Get all attributes
        $categoryAttributes = $category->attributes->keyBy('id'); // Get attributes already assigned to this category
        return view('admin.categories.edit', compact('category', 'categories', 'attributes', 'categoryAttributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', 'not_in:' . $category->id],
            'attributes' => ['nullable', 'array'], // Validate attributes as an array
            'attributes.*.id' => ['required_with:attributes', 'exists:attributes,id'],
            'attributes.*.value' => ['nullable', 'string'],
        ]);

        $category->update($request->only(['name', 'description', 'parent_id']));

        // Sync attributes
        if ($request->has('attributes')) {
            $syncData = [];
            foreach ($request->attributes as $attributeData) {
                $syncData[$attributeData['id']] = ['value' => $attributeData['value'] ?? null];
            }
            $category->attributes()->sync($syncData);
        } else {
            $category->attributes()->detach(); // If no attributes are sent, detach all
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
