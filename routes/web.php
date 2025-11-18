<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('lang/{code}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Add category show route
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/categories/{category}/attributes', [CategoryController::class, 'getAttributes'])->name('categories.attributes');

    // User's services (Ads) management
    Route::get('my-services', [ServiceController::class, 'myServices'])->name('services.my');
    Route::resource('services', ServiceController::class)->except(['index', 'show']);

    // User-to-user messaging
    Route::post('conversations/start', [ConversationController::class, 'startOrShow'])->name('conversations.start');
    Route::get('conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    
    // API routes for real-time chat
    Route::get('conversations/{conversation}/messages', [ConversationController::class, 'getMessagesJson'])->name('conversations.messages.json');
    Route::post('conversations/{conversation}/messages', [MessageController::class, 'storeJson'])->name('messages.store.json');
});

// Publicly accessible service routes
Route::get('services', [ServiceController::class, 'index'])->name('services.index');
Route::get('services/{service}', [ServiceController::class, 'show'])->name('services.show');



require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::get('services/pending', [\App\Http\Controllers\Admin\ServiceController::class, 'pending'])->name('services.pending');
    Route::post('services/{service}/approve', [\App\Http\Controllers\Admin\ServiceController::class, 'approve'])->name('services.approve');
    Route::delete('services/images/{image}', [\App\Http\Controllers\Admin\ServiceController::class, 'deleteImage'])->name('services.images.delete');
    Route::resource('regions', \App\Http\Controllers\Admin\RegionController::class);
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);
    Route::resource('attributes', \App\Http\Controllers\Admin\AttributeController::class);
    Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
    Route::post('pages/{page}/toggle', [\App\Http\Controllers\Admin\PageController::class, 'toggle'])->name('pages.toggle');
    Route::resource('languages', \App\Http\Controllers\Admin\LanguageController::class);
        Route::get('translations', [\App\Http\Controllers\Admin\TranslationController::class, 'index'])->name('translations.index');
    Route::post('translations', [\App\Http\Controllers\Admin\TranslationController::class, 'store'])->name('translations.store');
    Route::post('translations/update', [\App\Http\Controllers\Admin\TranslationController::class, 'update'])->name('translations.update');
});



Route::get('/debug-translations/{locale}', function ($locale) {
    return response()->json(app('translator')->getLoader()->load($locale, '*', '*'));
});

Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');

// Route:get('/{slug}', [PageController::class, 'show'])->name('page.show');
Route::get('/debug-trans', function () {
    // 1. نجبر النظام على استخدام الإنجليزية للتجربة
    app()->setLocale('en');

    // 2. نستخدم المفتاح الكامل (اسم الجروب + النقطة + الكلمة)
    // تذكر: نحن وضعنا الكلمات العامة تحت "general"
    $key = 'general.Actions'; 

    dd([
        'Current Locale' => app()->getLocale(),
        'Database Translation' => __($key), // هل ستظهر الكلمة؟
        'Is Loaded?' => app('translator')->has($key), // هل يراها الآن؟
    ]);
});
Route::get('lang/{code}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');