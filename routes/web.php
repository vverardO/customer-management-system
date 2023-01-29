<?php

use App\Http\Livewire\Authentication\Login;
use App\Http\Livewire\Authentication\Register;
use App\Http\Livewire\Companies\Edit as CompaniesEdit;
use App\Http\Livewire\Customers\Create as CustomersCreate;
use App\Http\Livewire\Customers\Edit as CustomersEdit;
use App\Http\Livewire\Customers\Index as CustomersIndex;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Users\Profile as UsersProfile;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/profile', UsersProfile::class)->name('profile');

    Route::prefix('companies')->group(function () {
        Route::get('/edit', CompaniesEdit::class)->name('companies.edit');
    });

    Route::prefix('customers')->group(function () {
        Route::get('/', CustomersIndex::class)->name('customers.index');
        Route::get('/create', CustomersCreate::class)->name('customers.create');
        Route::get('/edit/{id}', CustomersEdit::class)->name('customers.edit');
    });
});
