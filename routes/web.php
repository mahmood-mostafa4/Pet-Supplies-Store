<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CheckoutController;

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

Route::get('/', [ProjectController::class , 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/products',[ProjectController::class , 'products'] )->name('products');



Route::get('/single_product/{id}',[ProjectController::class , 'single_product'])->name('single_product');

Route::get('/single_product' , function () {
return redirect('/');
});

Route::get('/cart' , [CartController::class , 'cart'])->name('cart');

Route::post('/add_to_cart' , [CartController::class , 'add_to_cart'])->name('add_to_cart');

Route::get('/add_to_cart' , function () {
    return redirect('/');
});


Route::post('/remove_from_cart' , [CartController::class , 'remove_from_cart'])->name('remove_from_cart');

Route::get('/remove_from_cart' , function () {
    return redirect('/');
});


Route::post('/edit_product_quantity' , [CartController::class , 'edit_product_quantity'])->name('edit_product_quantity');

Route::get('/edit_product_quantity' , function () {
    return redirect('/');
});


Route::get('/checkout' , [CheckoutController::class , 'checkout'])->name('checkout');


Route::post('/place_order' , [OrderController::class , 'place_order'])->name('place_order');

Route::get('/payment' , [PaymentController::class , 'payment'])->name('payment');

Route::get('/verify_payment/{transaction_id}' , [PaymentController::class , 'verify_payment'])->name('verify_payment');



Route::get('/complete_payment' , [PaymentController::class , 'complete_payment'])->name('complete_payment');


Route::get('/thank_you' , [PaymentController::class , 'thank_you'])->name('thank_you');
