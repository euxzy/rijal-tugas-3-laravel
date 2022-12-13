<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');


Route::prefix('/product')
    ->name('product.')
    ->controller(ProductController::class)
    ->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add', 'create')->name('add');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('delete');
    });


Route::prefix('/posts')
    ->name('post.')
    ->controller(ArticleController::class)
    ->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::get('/{slug}', 'show')->name('show');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('delete');
    });

Route::prefix('/auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::any('/login', 'login')->name('login');
    });
