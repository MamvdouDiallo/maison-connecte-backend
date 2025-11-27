<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


use App\Http\Controllers\{
    CategoryController,
    SubCategoryController,
    ProductController,
    PackController,
    PackProductController,
    ServiceController,
    QuoteController,
    SupportTicketController,
    ContactController,
    OrderController,
    UserController
};

Route::prefix('public')->group(function () {

    // Categories & Subcategories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::get('/categories/{id}/subcategories', [SubCategoryController::class, 'fromCategory']);

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    // Packs
    Route::get('/packs', [PackController::class, 'index']);
    Route::get('/packs/{id}', [PackController::class, 'show']);

    // Services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);

    // Contact
    Route::post('/contact', [ContactController::class, 'store']);

    // Quote
    Route::post('/quote', [QuoteController::class, 'store']);
});



Route::middleware(['auth:sanctum'])->group(function () {

    // Profile
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'update']);

    // Orders
    Route::get('/orders', [OrderController::class, 'userOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);

    // Support tickets
    Route::get('/support', [SupportTicketController::class, 'userTickets']);
    Route::post('/support', [SupportTicketController::class, 'store']);
    Route::get('/support/{id}', [SupportTicketController::class, 'show']);

});



Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {

    // Users
    Route::apiResource('users', UserController::class);

    // Categories
    Route::apiResource('categories', CategoryController::class);

    // Subcategories
    Route::apiResource('subcategories', SubCategoryController::class);

    // Products
    Route::apiResource('products', ProductController::class);

    // Packs
    Route::apiResource('packs', PackController::class);
    Route::post('packs/{id}/products', [PackProductController::class, 'attach']);
    Route::delete('packs/{id}/products/{productId}', [PackProductController::class, 'detach']);

    // Services
    Route::apiResource('services', ServiceController::class);

    // Quotes
    Route::get('quotes', [QuoteController::class, 'index']);
    Route::put('quotes/{id}', [QuoteController::class, 'update']);
    Route::delete('quotes/{id}', [QuoteController::class, 'destroy']);

    // Support Tickets
    Route::get('support', [SupportTicketController::class, 'index']);
    Route::put('support/{id}', [SupportTicketController::class, 'update']);

    // Orders
    Route::get('orders', [OrderController::class, 'index']);
    Route::put('orders/{id}', [OrderController::class, 'update']);
});
