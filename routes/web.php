<?php

use App\Http\Middleware\SetLocale;
use App\Http\Controllers\AuthController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', function (string $locale) {
    if (! in_array($locale, SetLocale::SUPPORTED, true)) {
        abort(404);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('locale.switch');

Route::get('/theme/{theme}', function (string $theme) {
    if (! in_array($theme, ['light', 'dark', 'system'], true)) {
        abort(404);
    }

    session(['theme' => $theme]);

    return redirect()->back();
})->name('theme.switch');

Route::get('/', function () {
    $products = Product::query()
        ->withMin('offers', 'price')
        ->latest('id')
        ->take(8)
        ->get();

    return view('home', [
        'popularProducts' => $products->take(4),
        'otherProducts' => $products->slice(4, 4)->values(),
    ]);
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
