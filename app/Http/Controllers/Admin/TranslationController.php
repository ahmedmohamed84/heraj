<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $languages = Language::all();
        $selectedLocale = $request->get('locale', $languages->first()->code ?? config('app.locale'));
        $groups = Translation::where('locale', $selectedLocale)->distinct()->pluck('group');
        $selectedGroup = $request->get('group');

        $translationsQuery = Translation::where('locale', $selectedLocale);

        if ($selectedGroup) {
            $translationsQuery->where('group', $selectedGroup);
        }

        $translations = $translationsQuery->orderBy('group')->orderBy('key')->paginate(20);

        return view('admin.translations.index', compact('languages', 'selectedLocale', 'groups', 'selectedGroup', 'translations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|exists:languages,code',
            'group' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'value' => 'nullable|string',
        ]);

        // Check if key already exists for this locale and group
        $exists = Translation::where('locale', $request->locale)
            ->where('group', $request->group)
            ->where('key', $request->key)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This translation key already exists for the selected language and group.');
        }

        Translation::create($request->all());

        Cache::forget('translations_' . $request->locale);

        return redirect()->route('admin.translations.index', ['locale' => $request->locale, 'group' => $request->group])
            ->with('success', 'Translation created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'translations' => 'required|array',
            'translations.*.value' => 'nullable|string',
            'locale' => 'required|string|exists:languages,code'
        ]);

        foreach ($request->translations as $id => $data) {
            $translation = Translation::find($id);
            if ($translation && isset($data['value'])) {
                $translation->value = $data['value'];
                $translation->save();
            }
        }

        Cache::forget('translations_' . $request->locale);

        return back()->with('success', 'Translations updated successfully.');
    }
}