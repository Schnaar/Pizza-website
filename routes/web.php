<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/pizza', [App\Http\Controllers\PizzaController::class, 'index'])->name('pizza.index');
Route::get('/pizza/create', [App\Http\Controllers\PizzaController::class, 'create'])->name('pizza.create');
Route::get('/pizza/{id}/edit', [App\Http\Controllers\PizzaController::class, 'edit'])->name('pizza.edit');
Route::post('/pizza/add_to_order',[App\Http\Controllers\PizzaController::class,'addToOrder'])->name(('addToOrder'));
Route::post('/pizza/store', [App\Http\Controllers\PizzaController::class, 'store'])->name('pizza.store');
Route::delete('/pizza/{key}/remove_from_order',[App\Http\Controllers\PizzaController::class, 'removeFromOrder'])->name('removeFromOrder');
Route::put('/pizza/{id}/update', [App\Http\Controllers\PizzaController::class, 'update'])->name('pizza.update');
Route::get('/admin.index',[App\Http\Controllers\PizzaController::class,'admin'])->name('admin');
Route::delete('/pizza/{id}/delete', [App\Http\Controllers\PizzaController::class, 'destroy'])->name('pizza.destroy');
Route::post('pizza/order',[App\Http\Controllers\PizzaController::class,'makeOrder'])->name('order');
Route::post('/pizza/Reorder',[App\Http\Controllers\PizzaController::class, 'ReOrder'])->name('ReOrder');
