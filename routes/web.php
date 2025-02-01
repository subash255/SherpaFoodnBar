<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FooditemController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SubmealController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/',[HomePageController::class, 'index'])->name('welcome');
Route::get('about', [HomePageController::class, 'about'])->name('about');
Route::get('menu',[MenuController::class,'index'])->name('menu.index');
Route::get('contact',[HomePageController::class,'contact'])->name('contact');

//cart routes
Route::get('cart',[CartController::class,'viewcart'])->name('cart.index');
Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('cart/store', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{fooditemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('cart/success/{orderNumber}', [CartController::class, 'paymentSuccess'])->name('cart.success');
Route::get('cart/cancel/{orderNumber}', [CartController::class, 'paymentCancel'])->name('cart.cancel');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/', [BookingController::class, 'store'])->name('booking.store');
//order
Route::post('order/{id}', [MenuController::class, 'store'])->name('menu.store');






Route::middleware(['auth', 'admin'])->group(function () {
    
    // Admin routes
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //category routes   
    Route::get('category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('category', [CategoryController::class, 'store'])->name('admin.category.store');  
    Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::patch('category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');
    Route::post('category/update-toggle/{categoryId}', [CategoryController::class, 'updateToggle']);



    //subcategory routes
    Route::get('subcategory/{id}', [SubcategoryController::class, 'index'])->name('admin.subcategory.index');  
    Route::get('subcategory/create', [SubcategoryController::class, 'create'])->name('admin.subcategory.create');
    Route::post('subcategory', [SubcategoryController::class, 'store'])->name('admin.subcategory.store');
    Route::get('subcategory/{id}/edit', [SubcategoryController::class, 'edit'])->name('admin.subcategory.edit');
    Route::patch('subcategory/{id}', [SubcategoryController::class, 'update'])->name('admin.subcategory.update');
    Route::delete('subcategory/{id}', [SubcategoryController::class, 'destroy'])->name('admin.subcategory.destroy');

    //fooditem routes
    Route::get('fooditem', [FooditemController::class, 'index'])->name('admin.fooditems.index');
    Route::get('fooditem/create', [FooditemController::class, 'create'])->name('admin.fooditems.create');
    Route::post('fooditem', [FooditemController::class, 'store'])->name('admin.fooditems.store');
    Route::get('fooditem/{id}/edit', [FooditemController::class, 'edit'])->name('admin.fooditems.edit');
    Route::patch('fooditem/{id}', [FooditemController::class, 'update'])->name('admin.fooditems.update');
    Route::delete('fooditem/{id}', [FooditemController::class, 'destroy'])->name('admin.fooditems.destroy');
    Route::post('fooditem/update-toggle/{foodItemId}', [FooditemController::class, 'updateToggleStatus']);


    //banner routes
    Route::get('banner', [BannerController::class, 'index'])->name('admin.banner.index');
    Route::get('banner/create', [BannerController::class, 'create'])->name('admin.banner.create');
    Route::post('banner', [BannerController::class, 'store'])->name('admin.banner.store');
    Route::get('banner/{id}/edit', [BannerController::class, 'edit'])->name('admin.banner.edit');
    Route::patch('banner/{id}', [BannerController::class, 'update'])->name('admin.banner.update');
    Route::delete('banner/{id}', [BannerController::class, 'destroy'])->name('admin.banner.destroy');

    //booking routes
    Route::get('booking', [BookingController::class, 'index'])->name('admin.booking.index');
    Route::delete('booking/{id}', [BookingController::class, 'destroy'])->name('admin.booking.destroy');

   //order routes
    Route::get('order', [OrderController::class, 'index'])->name('admin.order.index');
    Route::delete('order/{id}', [OrderController::class, 'destroy'])->name('admin.order.destroy');

    //meal routes
    Route::get('meal/index', [MealController::class, 'index'])->name('admin.meal.index');
    Route::post('meal', [MealController::class, 'store'])->name('admin.meal.store');
    Route::get('meal/{id}/edit', [MealController::class, 'edit'])->name('admin.meal.edit');
    Route::patch('meal/{id}', [MealController::class, 'update'])->name('admin.meal.update');
    Route::delete('meal/{id}', [MealController::class, 'destroy'])->name('admin.meal.delete');

    //submeal routes
    Route::get('submeal/{id}', [SubmealController::class, 'index'])->name('admin.submeal.index');
    Route::post('submeal', [SubmealController::class, 'store'])->name('admin.submeal.store');
    Route::get('submeal/{id}/edit', [SubmealController::class, 'edit'])->name('admin.submeal.edit');
    Route::patch('submeal/{id}', [SubmealController::class, 'update'])->name('admin.submeal.update');
    Route::delete('submeal/{id}', [SubmealController::class, 'destroy'])->name('admin.submeal.destroy');

});

require __DIR__.'/auth.php';
