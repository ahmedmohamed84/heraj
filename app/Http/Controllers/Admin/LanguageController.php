<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages,code',
            'direction' => 'required|in:ltr,rtl',
        ]);

        Language::create([
            'name' => $request->name,
            'code' => $request->code,
            'direction' => $request->direction,
            'is_active' => $request->has('is_active'),
        ]);

        Cache::forget('active_languages_for_translator');
        Cache::forget('active_languages');

        return redirect()->route('admin.languages.index')->with('success', 'Language created successfully.');
    }

    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages,code,' . $language->id,
            'direction' => 'required|in:ltr,rtl',
        ]);

        $language->update([
            'name' => $request->name,
            'code' => $request->code,
            'direction' => $request->direction,
            'is_active' => $request->has('is_active'),
        ]);

        Cache::forget('active_languages_for_translator');
        Cache::forget('active_languages');

        return redirect()->route('admin.languages.index')->with('success', 'Language updated successfully.');
    }

    public function destroy(Language $language)
    {
        // Clear translation cache for the deleted language
        Cache::forget('translations_' . $language->code);

        $language->delete();

        Cache::forget('active_languages_for_translator');
        Cache::forget('active_languages');

        return redirect()->route('admin.languages.index')->with('success', 'Language deleted successfully.');
    }
}
