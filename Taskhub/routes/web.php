<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

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

route::post('/update/{id}', [CategoryController::class, 'update']);

route::get('/delete/{id}',[CategoryController::class,'delete']);

route::get('dashboard', [HomeController::class, 'index']);

route::get('/add_task/{id}', [HomeController::class, 'add']);

route::post('/add_task',[HomeController::class,'create']);

route::get('/edit_task/{id}',[HomeController::class,'edit']);

route::post('/update_task/{id}',[HomeController::class,'update']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});
