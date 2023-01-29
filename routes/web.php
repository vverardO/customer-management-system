<?php

use App\Http\Livewire\Authentication\Login;
use App\Http\Livewire\Authentication\Register;
use App\Http\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Users\Profile as UsersProfile;
use App\Http\Livewire\Companies\Edit as CompaniesEdit;

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/profile', UsersProfile::class)->name('profile');

    Route::prefix('companies')->group(function () {
        Route::get('/edit', CompaniesEdit::class)->name('companies.edit');
    });
});
