<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with active categories and services.
     */
    public function index()
    {
        // Fetch active parent categories
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        // Fetch latest 12 active services with eager loading
        $services = Service::where('is_active', true)
            ->where('status', 'approved')
            ->with(['city', 'category', 'user'])
            ->latest()
            ->limit(12)
            ->get();

        return view('welcome', compact('categories', 'services'));
    }
}