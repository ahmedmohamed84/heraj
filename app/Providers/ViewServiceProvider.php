<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        View::composer('layouts.new_app', function ($view) {
            $view->with('pages', Page::where('is_published', true)->get());
        });

        View::composer('layouts.navigation', function ($view) {
            $view->with('languages', Language::where('is_active', true)->get());
        });
    }
}