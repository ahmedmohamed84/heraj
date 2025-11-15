<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class DatabaseTranslationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('languages') && Schema::hasTable('translations')) {
            try {
                $activeLanguages = Cache::rememberForever('active_languages_for_translator', function () {
                    return Language::where('is_active', true)->pluck('code')->all();
                });

                foreach ($activeLanguages as $locale) {
                    $translations = Cache::rememberForever('translations_' . $locale, function () use ($locale) {
                        $lines = [];
                        $dbTranslations = Translation::where('locale', $locale)->get();
                        foreach ($dbTranslations as $translation) {
                            $key = $translation->group ? $translation->group . '.' . $translation->key : $translation->key;
                            $lines[$key] = $translation->value;
                        }
                        return $lines;
                    });

                    app('translator')->addLines($translations, $locale);
                }
            } catch (\Exception $e) {
                // This can happen when migrations are not run yet.
                // You can log the error if you want.
            }
        }
    }
}