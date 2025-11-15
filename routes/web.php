<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/categories/{category}/attributes', [\App\Http\Controllers\CategoryController::class, 'getAttributes'])->name('categories.attributes');
    Route::resource('services', ServiceController::class);
});


require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
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



Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');

