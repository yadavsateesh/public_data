<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\OrderNotificationController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/leave/apply', [LeaveApplicationController::class, 'store'])->name('leave.store');
    Route::get('/leave/create', [LeaveApplicationController::class, 'create'])->name('leave.create');
    Route::get('/leave/list', [LeaveApplicationController::class, 'index'])->name('leave.list');
});



Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/user/create', [AdminController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user/store', [AdminController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/leave/list', [AdminController::class, 'leaveList'])->name('admin.leave.list');
    Route::get('/admin/users/list', [AdminController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/update-status', [AdminController::class, 'updateStatus'])->name('status.update');

});

Route::middleware(['auth', 'user-access:user'])->group(function () {

    // User product list
    Route::get('/products', [OrderController::class, 'products'])
        ->name('products.index');

    // User places an order
    Route::post('/orders', [OrderController::class, 'store'])
        ->name('orders.store');

    // User views own orders
    Route::get('/my-orders', [OrderController::class, 'myOrders'])
        ->name('orders.my');

});

Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index');

    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.status');

    Route::get('/notifications', [OrderNotificationController::class, 'index'])
        ->name('notifications.index');

    Route::patch('/notifications/{id}/read', [OrderNotificationController::class, 'markAsRead'])
        ->name('notifications.read');
});
