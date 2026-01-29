<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController; // Import ProfileController
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Store Routes ---

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Search Functionality
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Filter by Category
Route::get('/category/{id}', [HomeController::class, 'category'])->name('category.show');

// --- Shop Routes (Products) ---
Route::get('/products', [ShopController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ShopController::class, 'show'])->name('products.show');

// --- Authentication (Login/Logout) ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Registration ---
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// --- Profile & Dashboard Routes (Protected) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Category Management (Admin actions inside Profile)
    Route::put('/profile/category/{id}', [ProfileController::class, 'updateCategory'])->name('profile.category.update');
    Route::delete('/profile/category/{id}', [ProfileController::class, 'deleteCategory'])->name('profile.category.delete');
});

// --- Cart Routes ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

// --- Static Pages ---
Route::view('/about', 'about')->name('about');

// --- Admin Routes ---
Route::prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});