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
        // Prevent errors during migrations
        if (!Schema::hasTable('translations')) {
            return;
        }

        try {
            // Use a single cache key for all translations
            $translations = Cache::rememberForever('db_translations', function () {
                $groupedTranslations = [];
                // Fetch all translations and group them by locale
                Translation::all()->each(function ($translation) use (&$groupedTranslations) {
                    $key = $translation->group ? $translation->group . '.' . $translation->key : $translation->key;
                    $groupedTranslations[$translation->locale][$key] = $translation->value;
                });
                return $groupedTranslations;
            });

            // Load the translations into the application
            foreach ($translations as $locale => $lines) {
                app('translator')->addLines($lines, $locale);
            }
        } catch (\Exception $e) {
            // Log the error if needed, but prevent the application from crashing
        }
    }
}