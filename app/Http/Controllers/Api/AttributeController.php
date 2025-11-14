<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Fetch the attributes for a given category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Category $category)
    {
        // The 'attributes' relationship on the Category model will be automatically loaded
        // and converted to JSON.
        return response()->json($category->attributes);
    }
}
