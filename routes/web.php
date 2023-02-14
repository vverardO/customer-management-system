<?php

use App\Http\Livewire\Authentication\Login;
use App\Http\Livewire\Authentication\Register;
use App\Http\Livewire\Companies\Edit as CompaniesEdit;
use App\Http\Livewire\Customers\Create as CustomersCreate;
use App\Http\Livewire\Customers\Edit as CustomersEdit;
use App\Http\Livewire\Customers\Index as CustomersIndex;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Financial\Products\Create as ProductsCreate;
use App\Http\Livewire\Financial\Products\Edit as ProductsEdit;
use App\Http\Livewire\Financial\Products\Index as ProductsIndex;
use App\Http\Livewire\Financial\Services\Create as ServicesCreate;
use App\Http\Livewire\Financial\Services\Edit as ServicesEdit;
use App\Http\Livewire\Financial\Services\Index as ServicesIndex;
use App\Http\Livewire\Orders\Create as OrdersCreate;
use App\Http\Livewire\Orders\Edit as OrdersEdit;
use App\Http\Livewire\Orders\Index as OrdersIndex;
use App\Http\Livewire\Stock\Entries\Create as EntriesCreate;
use App\Http\Livewire\Stock\Entries\Index as EntriesIndex;
use App\Http\Livewire\Stock\Outputs\Create as OutputsCreate;
use App\Http\Livewire\Stock\Outputs\Index as OutputsIndex;
use App\Http\Livewire\Users\Create as UsersCreate;
use App\Http\Livewire\Users\Edit as UsersEdit;
use App\Http\Livewire\Users\Index as UsersIndex;
use App\Http\Livewire\Users\Profile as UsersProfile;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/profile', UsersProfile::class)->name('profile');
    Route::get('/company', CompaniesEdit::class)->name('company');

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

    Route::prefix('users')->group(function () {
        Route::get('/', UsersIndex::class)->name('users.index');
        Route::get('/create', UsersCreate::class)->name('users.create');
        Route::get('/edit/{id}', UsersEdit::class)->name('users.edit');
    });

    Route::prefix('financial')->group(function () {
        Route::prefix('services')->group(function () {
            Route::get('/', ServicesIndex::class)->name('services.index');
            Route::get('/create', ServicesCreate::class)->name('services.create');
            Route::get('/edit/{id}', ServicesEdit::class)->name('services.edit');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', ProductsIndex::class)->name('products.index');
            Route::get('/create', ProductsCreate::class)->name('products.create');
            Route::get('/edit/{id}', ProductsEdit::class)->name('products.edit');
        });
    });

    Route::prefix('stock')->group(function () {
        Route::prefix('entries')->group(function () {
            Route::get('/', EntriesIndex::class)->name('entries.index');
            Route::get('/create', EntriesCreate::class)->name('entries.create');
        });

        Route::prefix('outputs')->group(function () {
            Route::get('/', OutputsIndex::class)->name('outputs.index');
            Route::get('/create', OutputsCreate::class)->name('outputs.create');
        });
    });
});
