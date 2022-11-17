<?php

use Illuminate\Support\Facades\Route;
use Shopfolio\Http\Controllers\Ecommerce\ProductController;
use Shopfolio\Http\Controllers\SettingController;
use Shopfolio\Http\Controllers\TemplatesController;

/*
|--------------------------------------------------------------------------
| Backend Web Routes
|--------------------------------------------------------------------------
|
|
*/

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::view('/profile', 'shopfolio::pages.account.profile')->name('profile');

Route::namespace('Ecommerce')->group(function () {
    Route::resource('brands', 'BrandController');
    Route::resource('categories', 'CategoryController');
    Route::resource('collections', 'CollectionController');
    Route::resource('customers', 'CustomerController');
    Route::resource('products', 'ProductController');
    Route::prefix('products')->as('products.')->group(function () {
        Route::get('/{product}/variants/{id}', [ProductController::class, 'variant'])->name('variant');
    });
    Route::resource('orders', 'OrderController')->only(['index', 'show', 'create']);
});

Route::resource('reviews', 'ReviewController');
Route::resource('discounts', 'DiscountController');
Route::resource('inventory-histories', 'InventoryHistoryController');

Route::prefix('setting')->as('settings.')->group(function () {
    Route::view('/', 'shopfolio::pages.settings.index')->name('index');
    Route::view('/management', 'shopfolio::pages.settings.management.index')->name('users');
    Route::view('/legal', 'shopfolio::pages.settings.legal')->name('legal');
    Route::view('/management/user/new', 'shopfolio::pages.settings.management.create')->name('user.new');
    Route::get('/management/roles/{role}', [SettingController::class, 'role'])->name('user.role');
    Route::view('/analytics', 'shopfolio::pages.settings.analytics')->name('analytics');
    Route::view('/payments', 'shopfolio::pages.settings.payments.general')->name('payments');
    Route::view('/general', 'shopfolio::pages.settings.general')->name('shop');
    Route::resource('inventories', 'InventoryController');
    Route::resource('attributes', 'AttributeController')->except('destroy', 'store', 'update');

    Route::prefix('email-setting')->group(function () {
        Route::view('/', 'shopfolio::pages.settings.mails.index')->name('mails');
        Route::view('/templates/select', 'shopfolio::pages.settings.mails.templates.add-template')->name('mails.select-template');
        Route::get('/templates/create/{type}/{name}/{skeleton}', [TemplatesController::class, 'create'])->name('mails.create-template');
        Route::post('/templates/create', [TemplatesController::class, 'store'])->name('mails.store-template');
    });

    Route::prefix('integrations')->group(function () {
        Route::view('/', 'shopfolio::pages.settings.integrations.index')->name('integrations');
        Route::view('/github', 'shopfolio::pages.settings.integrations.github')->name('integrations.github');
        Route::view('/twitter', 'shopfolio::pages.settings.integrations.twitter')->name('integrations.twitter');
    });
});
