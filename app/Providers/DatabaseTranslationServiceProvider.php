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
    // public function boot(): void
    // {
    //     // Prevent errors during migrations
    //     if (!Schema::hasTable('translations')) {
    //         return;
    //     }

    //     try {
    //         // Use a single cache key for all translations
    //         $translations = Cache::rememberForever('db_translations', function () {
    //             $groupedTranslations = [];
    //             // Fetch all translations and group them by locale
    //             Translation::all()->each(function ($translation) use (&$groupedTranslations) {
    //                 $key = $translation->group ? $translation->group . '.' . $translation->key : $translation->key;
    //                 $groupedTranslations[$translation->locale][$key] = $translation->value;
    //             });
    //             return $groupedTranslations;
    //         });

    //         // Load the translations into the application
    //         foreach ($translations as $locale => $lines) {
    //             app('translator')->addLines($lines, $locale);
    //         }
    //     } catch (\Exception $e) {
    //         // Log the error if needed, but prevent the application from crashing
    //     }
    // }
    
    public function boot()
    {
        // 1. حماية من أخطاء الـ Migration
        if (!Schema::hasTable('translations')) {
            return;
        }

        // 2. جلب البيانات من الكاش أو قاعدة البيانات
        $formattedTranslations = Cache::rememberForever('db_translations', function () {
            $allTranslations = \App\Models\Translation::all();
            $grouped = [];

            foreach ($allTranslations as $translation) {
                // الحالة الأولى: الكلمات المباشرة (JSON Keys) مثل "Actions"
                // الشرط: الجروب اسمه general أو فارغ
                if ($translation->group === 'general' || empty($translation->group)) {
                    
                    // 🟢 التغيير الجوهري هنا:
                    // نضيف "*. " قبل الكلمة.
                    // لارافيل سيحذف النجمة والنقطة ويخزن الكلمة في خانة JSON
                    $key = '*.' . $translation->key; 
                    
                    // نخزنها في مصفوفة خاصة
                    $grouped[$translation->locale]['json'][$key] = $translation->value;
                } 
                // الحالة الثانية: المجموعات العادية مثل "auth.failed"
                else {
                    $key = $translation->group . '.' . $translation->key;
                    $grouped[$translation->locale]['groups'][$key] = $translation->value;
                }
            }
            return $grouped;
        });

        // 3. تحميل البيانات إلى المترجم
        foreach ($formattedTranslations as $locale => $types) {
            
            // أولاً: تحميل كلمات JSON (التي تبدأ بـ *.)
            if (isset($types['json'])) {
                app('translator')->addLines($types['json'], $locale);
            }

            // ثانياً: تحميل المجموعات العادية
            if (isset($types['groups'])) {
                app('translator')->addLines($types['groups'], $locale);
            }
        }
    }

}
