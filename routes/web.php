<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

//show Register Form
Route::get('/',[AuthController::class,'showRegister']);
//Save new register data
Route::post('/register',[AuthController::class,'save']);

// Show Login Page
Route::get('/login', [AuthController::class, 'showLogin']);
//Check login Data
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth')->group(function(){
//logout
Route::post('/logout', [AuthController::class, 'logout']);

//Show Dashboard
Route::get('/dashboard',[AuthController::class,'showHomePage']);

//Orders Page
Route::get('/order',[OrderController::class,'showOrderPage'])->name('orders.index');//Show
Route::get('/orders/createPage',[OrderController::class,'createPage']);//Order Create
Route::post('/orders/store', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

//Items Page
Route::get('/item',[ItemController::class,'showItemPage']);//Show
Route::get('/items/createPage',[ItemController::class,'createPage']);//Item createPage
Route::post('/saveItem',[ItemController::class,'saveItem']);
Route::get('/items/{id}/view',[ItemController::class,'ViewPage']);//view Page
Route::get('/items/{id}/edit',[ItemController::class,'edit']);//edit
Route::put('/item/{id}/update',[ItemController::class,'update']);//update
Route::delete('/item/{id}/delete',[ItemController::class,'delete']);//delete

//Profile
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

