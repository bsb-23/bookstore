<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\TransactionController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/books', BookController::class);
Route::resource('/authors', AuthorController::class);
Route::resource('/publishers', PublisherController::class);
Route::resource('/genres', GenreController::class);
Route::get('/sell', [TransactionController::class, 'showSellForm'])->name('books.sell');
Route::get('/purchases', [TransactionController::class, 'showPurchaseForm'])->name('books.purchase');
Route::post('/sales', [TransactionController::class, 'createSale'])->name('sales.create');
Route::post('/purchases', [TransactionController::class, 'createPurchase'])->name('purchases.create');