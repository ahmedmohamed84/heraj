<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Models\Language;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('layouts.partials.admin-navigation', function ($view) {
            
            // نتحقق من وجود الجدول لتجنب أخطاء الـ migration
            if (Schema::hasTable('languages')) {
                
                // نستخدم الكاش لسرعة الأداء (لأن اللغات لا تتغير كل ثانية)
                $languages = Cache::rememberForever('active_languages', function () {
                    // جلب اللغات المفعلة فقط
                    return Language::where('is_active', true)->get();
                });
                
                // تمرير المتغير إلى العرض
                $view->with('languages', $languages);

            } else {
                // في حال عدم وجود الجدول، نرسل مصفوفة فارغة
                $view->with('languages', []);
            }
        });
    }
}
