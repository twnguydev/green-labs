<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChatMessageController;
use App\Models\Category;

Route::get('/', [HomeController::class, 'showHome'])->name('home');
Route::get('/services', [HomeController::class, 'showServices'])->name('services');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
Route::get('/confirm/{token}', [AuthController::class, 'confirmAccount'])->name('confirm.account');
Route::post('/login/register', [AuthController::class, 'login'])->name('login.post');
Route::post('/signup/register', [AuthController::class, 'register'])->name('signup.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile/{firstname}-{lastname}', [UserController::class, 'showProfile'])
    ->middleware('auth')
    ->name('profile');
Route::post('/profile/{firstname}-{lastname}/update', [UserController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('profile.update');
Route::post('/profile/{firstname}-{lastname}/update/biography', [UserController::class, 'updateBiography'])
    ->middleware('auth')
    ->name('profile.update.biography');
Route::post('/profile/{firstname}-{lastname}/delete', [UserController::class, 'deleteProfile'])
    ->middleware('auth')
    ->name('profile/delete');

Route::get('/categories/{category_route}', function ($category_route) {
    $category = Category::where('route', $category_route)->firstOrFail();
    $categoryName = $category->name;
    $products = $category->products;
    return view('category_products', ['category' => $category, 'products' => $products, 'categoryName' => $categoryName]);
})->name('categories');

Route::get('/dashboard', [UserController::class, 'showDashboard'])
    ->middleware('auth')
    ->name('dashboard');
Route::get('/dashboard/new', [ProductController::class, 'showNewAd'])
    ->middleware('auth')
    ->name('dashboard.new');
Route::post('/dashboard/new', [ProductController::class, 'createAd'])
    ->middleware('auth')
    ->name('dashboard.new.post');

Route::get('/categories/{category}/{ad_id}', [ProductController::class, 'showAd'])
    ->name('ad.show');
Route::post('/categories/{category}/{ad_id}/review', [ProductController::class, 'createReview'])
    ->middleware('auth')
    ->name('ad.review.post');
Route::post('/categories/{category}/{ad_id}/delete', [ProductController::class, 'deleteAd'])
    ->middleware('auth')
    ->name('ad.delete');
Route::get('/categories/{category}/{ad_id}/edit', [ProductController::class, 'showUpdateAd'])
    ->middleware('auth')
    ->name('ad.edit');
Route::post('/categories/{category}/{ad_id}/edit', [ProductController::class, 'updateAd'])
    ->middleware('auth')
    ->name('ad.edit.post');

Route::post('/chat/{firstname}-{lastname}/send', [ChatMessageController::class, 'sendMessage'])
    ->middleware('auth')
    ->name('chat.send');
Route::get('/chat', [ChatMessageController::class, 'showChat'])
    ->middleware('auth')
    ->name('chat');
Route::get('/chat/{firstname}-{lastname}', [ChatMessageController::class, 'showChatWith'])
    ->middleware('auth')
    ->name('chat.user');