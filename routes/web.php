<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(PostController::class)->middleware(['auth'])->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/posts', 'store')->name('store');
    Route::get('/posts/create', 'create')->name('create');
    Route::get('/posts/{post}', 'show')->name('show');
    Route::put('/posts/{post}', 'update')->name('update');
    Route::delete('/posts/{post}', 'delete')->name('delete');
    Route::get('/posts/{post}/edit', 'edit')->name('edit');
    Route::get('/map', 'map');
});

Route::get('/autocomplete',  [MapController::class, 'autocomplete'])->name('autocomplete');
Route::get('/route',  [MapController::class, 'route']);
Route::get('/recipe',  [RecipeController::class, 'recipe'])->name('recipe');
Route::get('/nutrient',  [RecipeController::class, 'nutrient'])->name('nutrient');
Route::post('/nutrientSerch',  [RecipeController::class, 'nutrientSerch'])->name('nutrientSerch');
Route::post("/recipeCategory",  [RecipeController::class, 'recipeCategory'])->name('recipeCategory');
Route::get('/categories/{category}', [CategoryController::class, 'index'])->middleware("auth");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
