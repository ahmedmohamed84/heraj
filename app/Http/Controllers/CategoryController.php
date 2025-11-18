<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Category $category)
    {
        // Get IDs of the category and all its descendants
        $categoryIds = $category->getDescendantIdsAndSelf();

        // Fetch active services within this category hierarchy
        $services = \App\Models\Service::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->with(['city', 'category']) // Eager load for performance
            ->latest()
            ->paginate(20);

        return view('categories.show', compact('category', 'services'));
    }

    /**
     * Get the attributes for a specific category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAttributes(Category $category)
    {
        return response()->json($category->getInheritedAttributes());
    }
}
