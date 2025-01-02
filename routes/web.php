<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/about', function () {
//     return view('about');
// });

Route::get('/', [HomePageController::class, 'index'])->name('welcome');
Route::get('/about', [HomePageController::class, 'about'])->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/menu',[MenuController::class,'index'])->name('menu.index');

Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');


    //category routes   
    Route::get('admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('admin/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('admin/category', [CategoryController::class, 'store'])->name('admin.category.store');  
    Route::get('admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::patch('admin/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('admin/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

    //subcategory routes
    Route::get('admin/subcategory', [SubcategoryController::class, 'index'])->name('admin.subcategory.index');  
    Route::get('admin/subcategory/create', [SubcategoryController::class, 'create'])->name('admin.subcategory.create');
    Route::post('admin/subcategory', [SubcategoryController::class, 'store'])->name('admin.subcategory.store');
    Route::get('admin/subcategory/{id}/edit', [SubcategoryController::class, 'edit'])->name('admin.subcategory.edit');
    Route::patch('admin/subcategory/{id}', [SubcategoryController::class, 'update'])->name('admin.subcategory.update');
    Route::delete('admin/subcategory/{id}', [SubcategoryController::class, 'destroy'])->name('admin.subcategory.destroy');
});

require __DIR__.'/auth.php';
