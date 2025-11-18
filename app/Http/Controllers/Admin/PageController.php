<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // This now needs to join translations to be searchable
        $pages = Page::with('translation')->latest();

        if ($request->has('search')) {
            $pages->whereHas('translations', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $pages = $pages->paginate(10);
        
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $languages = Language::all();
        $rules = [
            'is_published' => 'nullable|boolean',
        ];

        $translationData = [];
        $hasAtLeastOneTranslation = false;

        // First pass: check for input and build rules
        foreach ($languages as $language) {
            $locale = $language->code;
            if ($request->has($locale) && (
                $request->input($locale.'.title') ||
                $request->input($locale.'.slug') ||
                $request->input($locale.'.content')
            )) {
                $hasAtLeastOneTranslation = true;
                $rules[$locale . '.title'] = 'required|string|max:255';
                // Unique slug per locale
                $rules[$locale . '.slug'] = 'required|string|max:255|unique:page_translations,slug,NULL,id,locale,' . $locale;
                $rules[$locale . '.content'] = 'required|string';
                
                $translationData[$locale] = $request->input($locale);
            }
        }

        // If no language has any data, return with an error
        if (!$hasAtLeastOneTranslation) {
            return redirect()->back()
                ->withErrors(['general_error' => __('You must fill in the details for at least one language.')])
                ->withInput();
        }
        
        $request->validate($rules);

        $page = Page::create([
            'is_published' => $request->has('is_published'),
            'published_at' => $request->has('is_published') ? now() : null,
        ]);

        // Second pass: create translations from validated data
        foreach ($translationData as $locale => $data) {
            $page->translations()->create([
                'locale' => $locale,
                'title' => $data['title'],
                'slug' => Str::slug($data['slug']),
                'content' => $data['content'],
            ]);
        }

        return redirect()->route('admin.pages.index')->with('success', __('Page created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $languages = Language::all();
        // Eager load translations to avoid N+1 problem in the view
        $page->load('translations'); 
        return view('admin.pages.edit', compact('page', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        // You might want to add more robust validation here
        $request->validate([
            'is_published' => 'nullable|boolean',
        ]);

        $page->update([
            'is_published' => $request->has('is_published'),
            'published_at' => $request->has('is_published') && !$page->is_published ? now() : $page->published_at,
        ]);

        // Loop through the submitted language data
        foreach ($request->except(['_token', '_method', 'is_published']) as $locale => $data) {
            // Ensure all required fields for a translation are present
            if (isset($data['title']) && isset($data['slug']) && isset($data['content'])) {
                $page->translations()->updateOrCreate(
                    ['locale' => $locale], // Match by locale
                    [
                        'title'   => $data['title'],
                        'slug'    => Str::slug($data['slug']), // Ensure slug is URL-friendly
                        'content' => $data['content'],
                    ]
                );
            }
        }

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->back()->with('success', 'Page deleted successfully.');
    }

    /**
     * Toggle the published status of the specified resource.
     */
    public function toggle(Page $page)
    {
        $page->update([
            'is_published' => !$page->is_published,
            'published_at' => $page->is_published ? null : now(),
        ]);

        return redirect()->back()->with('success', 'Page status updated successfully.');
    }
}
