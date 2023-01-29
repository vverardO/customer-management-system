<?php

use App\Http\Livewire\Authentication\Login;
use App\Http\Livewire\Authentication\Register;
use App\Http\Livewire\Companies\Edit as CompaniesEdit;
use App\Http\Livewire\Customers\Create as CustomersCreate;
use App\Http\Livewire\Customers\Edit as CustomersEdit;
use App\Http\Livewire\Customers\Index as CustomersIndex;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Orders\Create as OrdersCreate;
use App\Http\Livewire\Orders\Edit as OrdersEdit;
use App\Http\Livewire\Orders\Index as OrdersIndex;
use App\Http\Livewire\Services\Create as ServicesCreate;
use App\Http\Livewire\Services\Edit as ServicesEdit;
use App\Http\Livewire\Services\Index as ServicesIndex;
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

    Route::prefix('orders')->group(function () {
        Route::get('/', OrdersIndex::class)->name('orders.index');
        Route::get('/create', OrdersCreate::class)->name('orders.create');
        Route::get('/edit/{id}', OrdersEdit::class)->name('orders.edit');
    });

    Route::prefix('services')->group(function () {
        Route::get('/', ServicesIndex::class)->name('services.index');
        Route::get('/create', ServicesCreate::class)->name('services.create');
        Route::get('/edit/{id}', ServicesEdit::class)->name('services.edit');
    });
});
