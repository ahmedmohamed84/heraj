<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeLanguages = Cache::rememberForever('active_languages', function () {
            return Language::where('is_active', true)->pluck('code')->all();
        });

        $locale = $request->segment(1);

        if ($locale && in_array($locale, $activeLanguages)) {
            session()->put('locale', $locale);
        }

        $sessionLocale = session('locale');

        if ($sessionLocale && in_array($sessionLocale, $activeLanguages)) {
            App::setLocale($sessionLocale);
        } else {
            // Fallback to default locale if session locale is not set or not active
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}