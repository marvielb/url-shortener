<?php

use App\Http\Controllers\ShortenController;
use App\Http\Controllers\UrlMappingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ShortenController::class, 'create'])->name('shorten.create');
Route::post('/', [ShortenController::class, 'store'])->name('shorten.store');
Route::get('/{shortUrl}', [UrlMappingController::class, 'redirect'])->name('shorten.redirect');
