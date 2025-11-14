<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get the attributes for a specific category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAttributes(Category $category)
    {
        // Eager load the attributes relationship
        $category->load('attributes');
        
        // Return the attributes as a JSON response
        return response()->json($category->attributes);
    }
}
