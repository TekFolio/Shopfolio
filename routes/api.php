<?php

use Illuminate\Support\Facades\Route;
use Shopfolio\Http\Controllers\Api\BrandController;

/*
|--------------------------------------------------------------------------
| Backend API Routes
|--------------------------------------------------------------------------
|
|
*/

Route::get('/brands', BrandController::class)->name('brands');
