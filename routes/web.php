<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomePageController::class, 'index'])->name('welcome');
Route::get('about', [HomePageController::class, 'about'])->name('about');
Route::get('menu',[MenuController::class,'index'])->name('menu.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



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

    //subcategory routes
    Route::get('subcategory/{id}', [SubcategoryController::class, 'index'])->name('admin.subcategory.index');  
    Route::get('subcategory/create', [SubcategoryController::class, 'create'])->name('admin.subcategory.create');
    Route::post('subcategory', [SubcategoryController::class, 'store'])->name('admin.subcategory.store');
    Route::get('subcategory/{id}/edit', [SubcategoryController::class, 'edit'])->name('admin.subcategory.edit');
    Route::patch('subcategory/{id}', [SubcategoryController::class, 'update'])->name('admin.subcategory.update');
    Route::delete('subcategory/{id}', [SubcategoryController::class, 'destroy'])->name('admin.subcategory.destroy');

    //banner routes
    Route::get('banner', [BannerController::class, 'index'])->name('admin.banner.index');
    Route::get('banner/create', [BannerController::class, 'create'])->name('admin.banner.create');
    Route::post('banner', [BannerController::class, 'store'])->name('admin.banner.store');
    Route::get('banner/{id}', [BannerController::class, 'show'])->name('admin.banner.show');
    Route::get('banner/{id}/edit', [BannerController::class, 'edit'])->name('admin.banner.edit');
    Route::patch('banner/{id}', [BannerController::class, 'update'])->name('admin.banner.update');
    Route::delete('banner/{id}', [BannerController::class, 'destroy'])->name('admin.banner.destroy');

});

require __DIR__.'/auth.php';
