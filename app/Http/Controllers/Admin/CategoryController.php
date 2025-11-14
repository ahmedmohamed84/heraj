<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('admin.categories.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:attributes,id',
        ]);

        $category = Category::create($validatedData);

        if ($request->has('attributes')) {
            $category->attributes()->sync($request->input('attributes'));
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $attributes = Attribute::all();
        return view('admin.categories.edit', compact('category', 'attributes'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // Validate the request data for the category itself (e.g., name, parent_id)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'attributes' => 'nullable|array', // Expect an array of attribute IDs
            'attributes.*' => 'exists:attributes,id', // Ensure every ID in the array exists
        ]);

        // Update the category's own fields
        $category->update($validatedData);

        // Sync the attributes for the category
        // This will attach only the attributes from the given array.
        // If an attribute ID is not in the array, it will be detached.
        if ($request->has('attributes')) {
            $category->attributes()->sync($request->input('attributes'));
        } else {
            // If no attributes are provided, detach all existing ones.
            $category->attributes()->sync([]);
        }


        // Redirect back with a success message
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
}