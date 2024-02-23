<?php
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{name}', [CategoryController::class, 'index'])->name('category');
Route::get('/product/{name}', [ProductController::class, 'index'])->name('product');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::post('/cart', [CartController::class, 'index'])->name('cart.save');
	Route::get('/cart', [CartController::class, 'index'])->name('cart');
	Route::post('/quick-entry', [CartController::class, 'quickEntry'])->name('quick-entry');
	Route::get('/quick-entry', [CartController::class, 'quickEntry'])->name('quick-entry.edit');
	Route::post('/update-cart-item', [CartController::class, 'updateCartItem'])->name('update-cart-item');
	Route::post('/delete-cart', [CartController::class, 'deleteCart'])->name('delete-cart');
	Route::post('/search-product', [CartController::class, 'searchProduct'])->name('search-product');
	Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
	Route::get('/get-cart-count', [CartController::class, 'getCartCount'])->name('get-cart-count');
	Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
});

require __DIR__.'/auth.php';
