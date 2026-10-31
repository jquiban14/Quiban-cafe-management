<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::get('/dashboard', function () {
    return view('dashboard', [
        'categoryCount' => \App\Models\Category::count(),
        'productCount' => \App\Models\Product::count(),
        'customerCount' => \App\Models\Customer::count(),
        'orderCount' => \App\Models\Order::count(),
        'recentOrders' => \App\Models\Order::latest()->take(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'staff'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Café management pages
    //Route::view('/categories', 'categories.index')
      //  ->name('categories.index');

    Route::resource('categories', CategoryController::class);

   Route::resource('products', ProductController::class);

   Route::resource('customers', CustomerController::class);


   Route::resource('orders', OrderController::class);

   Route::get('/payments', [PaymentController::class, 'index'])
    ->name('payments.index');

Route::get('/payments/create', [PaymentController::class, 'create'])
    ->name('payments.create');

Route::post('/payments', [PaymentController::class, 'store'])
    ->name('payments.store');
});

require __DIR__.'/auth.php';
