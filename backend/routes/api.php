<?php

use Illuminate\Http\Request;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Staff\AuthController as StaffAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StaffLogController;

// ---------------------------
// CUSTOMER ROUTES
// ---------------------------
Route::prefix('customer')->group(function () {
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::post('/login', [CustomerAuthController::class, 'login']);

    Route::middleware('auth:customer')->group(function () {
        Route::get('/user', [CustomerAuthController::class, 'user']);
        Route::post('/logout', [CustomerAuthController::class, 'logout']);

        Route::get('/books', [BookController::class, 'index']);
        Route::get('/books/{id}', [BookController::class, 'show']);


        Route::get('/loan-history', [LoanController::class, 'customerHistory']);
    });
});

// ---------------------------
// STAFF ROUTES
// ---------------------------
Route::prefix('staff')->group(function () {
    Route::post('/login', [StaffAuthController::class, 'login']);

    Route::middleware('auth:staff')->group(function () {
        Route::get('/user', [StaffAuthController::class, 'user']);
        Route::post('/logout', [StaffAuthController::class, 'logout']);

        Route::apiResource('/books', BookController::class);
        Route::apiResource('/loans', LoanController::class);
        Route::get('/overdue-alerts', [LoanController::class, 'overdueAlerts']);
    });
});

// ---------------------------
// ADMIN ROUTES (must also be staff with 'admin' role)
// ---------------------------
Route::prefix('admin')->middleware(['auth:staff', 'role:admin'])->group(function () {
    Route::post('/staff', [AdminController::class, 'createStaff']);
    Route::get('/staff', [AdminController::class, 'listStaff']);
    Route::get('/staff-logs', [StaffLogController::class, 'index']);
});
