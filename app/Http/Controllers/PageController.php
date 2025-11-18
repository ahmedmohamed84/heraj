<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the specified page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug)
    {
        // Find the translation based on the slug and current language
        $translation = PageTranslation::where('slug', $slug)
            ->where('locale', app()->getLocale())
            ->firstOrFail();

        // Get the parent page
        $page = $translation->page;

        // Ensure the page is published before showing it
        if (!$page || !$page->is_published) {
            abort(404);
        }

        // The view will receive both the page and its specific translation
        return view('page', compact('page', 'translation'));
    }
}
