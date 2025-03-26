<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Import\ImportController;
use App\Http\Controllers\Quote\QuoteController;
use App\Http\Controllers\Order\OrderController;
use App\Models\AssociateCustomer;
use App\Models\User;
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
Route::get('/category/{name}/{subCategorySlug?}', [CategoryController::class, 'index'])->name('category');
Route::get('/product/{name}', [ProductController::class, 'index'])->name('product');
Route::post('/getNextAttribute', [ProductController::class, 'getNextAttribute'])->name('product-next-attribute');
Route::post('/search', [ProductController::class, 'productSearch'])->name('product-search');
Route::get('/search', [ProductController::class, 'productSearch'])->name('product-search-get');
Route::post('/getVariationPrice', [ProductController::class, 'getVariationPrice'])->name('get-variation-price');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified.email'])->name('dashboard');

Route::middleware(['auth', 'verified.email'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/link-account', [ProfileController::class, 'linkAccount'])->name('link-account');
    Route::post('/link-account', [ProfileController::class, 'postLinkAccount'])->name('post-link-account');
    Route::delete('/unlink-account/{id}', [ProfileController::class, 'unlinkAccount'])->name('unlink-account');

    Route::post('/cart', [CartController::class, 'index'])->name('cart.save');
    Route::get('/cart', [CartController::class, 'quickEntry'])->name('cart');
    Route::post('/update-cart-item', [CartController::class, 'updateCartItem'])->name('update-cart-item');
    Route::post('/update-cart-item-marked', [CartController::class, 'updateCartItemMarked'])->name('update-cart-item-marked');
    Route::post('/delete-cart', [CartController::class, 'deleteCart'])->name('delete-cart');
    Route::post('/search-product', [CartController::class, 'searchProduct'])->name('search-product');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/add-to-cart-attachment', [CartController::class, 'addToCartAttachment'])->name('add-to-cart-attachment');
    Route::get('/get-cart-count', [CartController::class, 'getCartCount'])->name('get-cart-count');
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/quote', [CheckoutController::class, 'quote'])->name('quote');

    //Quote Routes
    Route::post('/generate-quote',[QuoteController::class, 'store'])->name('generateQuote');
    Route::get('/quotes',[QuoteController::class, 'index'])->name('quotes');
    Route::get('/quote/{quote}/edit', [QuoteController::class, 'edit'])->name('quote.edit');
    Route::get('/quote/{quote}', [QuoteController::class, 'update'])->name('quote.update');
    Route::post('/update-quote-item', [QuoteController::class, 'updateQuoteItem'])->name('update-quote-item');
    Route::post('/add-to-quote/{id}', [QuoteController::class, 'addToQuote'])->name('add-to-quote');
    Route::post('/update-quote-item-marked', [QuoteController::class, 'updateQuoteItemMarked'])->name('update-quote-item-marked');
    Route::post('/quotes', [QuoteController::class, 'index'])->name('quote-search');
    Route::get('/pdf/{quote_id}', [QuoteController::class, 'pdfDownloadQuote'])->name('pdf-download-quote');
    Route::get('/save-shipping-address', [QuoteController::class, 'saveShippingAddress'])->name('saveShippingAddress');

    //Order Routes
    Route::post('/place-order/{order_id}',[OrderController::class,'PlaceOrder'])->name('place-order');

    Route::post('/confirm-order', [CheckoutController::class, 'saveOrder'])->name('confirm-order');
    Route::get('/confirm-order', function () {
        return redirect('/order');
    });
    Route::get('/order', [CheckoutController::class, 'myOrder'])->name('order');
    Route::post('/order', [CheckoutController::class, 'myOrder'])->name('order-search');
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');
    Route::get('/shipping', [CheckoutController::class, 'index'])->name('shipping');
    Route::get('/pdf', [CheckoutController::class, 'pdfDownload'])->name('pdf-download-get');
    Route::post('/pdf', [CheckoutController::class, 'pdfDownload'])->name('pdf-download');
    Route::post('/receipt-download', [CheckoutController::class, 'receiptDownload'])->name('receipt-download');
    Route::post('/update-purchase-no', [CheckoutController::class, 'updatePurchaseNo'])->name('update-purchase-no');
    Route::post('/add-success-story', [ProductController::class, 'addStory'])->name('add-success-story');

    //Import Customers
    Route::get('/import-csv-customers', [ImportController::class, 'indexImportCustomer'])->name('import-customers-index');
    Route::post('/import-csv', [ImportController::class, 'importCustomers'])->name('import-customers');

    Route::post('/change-customer', [HomeController::class,'changeCustomer'])->name('change-customer');
    Route::get('/vault', [HomeController::class,'vault'])->name('vault');
    Route::post('/vault', [HomeController::class,'postVault'])->name('post-vault');

});

require __DIR__ . '/auth.php';
