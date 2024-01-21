<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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
    return view('auth.login');
});

route::get('/add_category',[CategoryController::class,'add']);

route::post('/add',[CategoryController::class,'create']);

route::get('/edit/{id}',[CategoryController::class,'edit']);

route::get('/add_category',[CategoryController::class,'add']);

Route::post('/update/{id}', [CategoryController::class, 'update']);

route::get('/delete/{id}',[CategoryController::class,'delete']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
