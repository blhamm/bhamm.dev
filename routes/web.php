<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SocialiteController;
use App\Http\Middleware\HandleAiBots;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', HomeController::class)->middleware(HandleAiBots::class)->name('home');

Route::get('/llms.txt', function () {
    $path = public_path('llms.txt');
    if (! file_exists($path)) {
        abort(404);
    }

    return response(file_get_contents($path), 200, [
        'Content-Type' => 'text/markdown; charset=UTF-8',
    ]);
});

Route::get('/llms-full.txt', function () {
    $path = public_path('llms-full.txt');
    if (! file_exists($path)) {
        abort(404);
    }

    return response(file_get_contents($path), 200, [
        'Content-Type' => 'text/markdown; charset=UTF-8',
    ]);
});

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('social.callback');
Route::post('/auth/logout', [SocialiteController::class, 'logout'])->name('signee.logout');

// Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//    Route::redirect('settings', 'settings/profile');
//
//    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//    Volt::route('settings/password', 'settings.password')->name('settings.password');
//    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

// require __DIR__.'/auth.php';
