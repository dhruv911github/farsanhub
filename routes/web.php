<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes/web.php

// Authentication Routes
// Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
Route::get('/', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::delete('contents', [App\Http\Controllers\Admin\ContentController::class, 'destroy'])->name('admin.contents.destroy');
Route::delete('expense', [App\Http\Controllers\Admin\ExpenseController::class, 'destroy'])->name('admin.expense.destroy');
Route::delete('customer', [App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('admin.customer.destroy');
Route::delete('product', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.product.destroy');
Route::delete('order', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('admin.order.destroy');


// Admin Routes
// Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    // change language
    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'gu'])) {
            // Store the selected locale in the session
            session()->put('locale', $locale);
        }
        return redirect()->back();
    });

    Route::get('leaflet-map', [App\Http\Controllers\Admin\CustomerController::class, 'leafletMap'])->name('leaflet-map');


    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // Content Routes
    Route::resource('contents', App\Http\Controllers\Admin\ContentController::class)->except('destroy');

    // Expense Routes
    Route::resource('expense', App\Http\Controllers\Admin\ExpenseController::class)->except('destroy');

    // Customer Routes
    Route::resource('customer', App\Http\Controllers\Admin\CustomerController::class)->except('destroy');

    // Product Routes
    Route::resource('product', App\Http\Controllers\Admin\ProductController::class)->except('destroy');

    // Order Routes
    Route::resource('order', App\Http\Controllers\Admin\OrderController::class)->except('destroy');

    // Reports
    Route::get('monthly-report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('monthly-report.index');
    Route::get('monthly-report/expense', [App\Http\Controllers\Admin\ReportController::class, 'expenseReport'])->name('monthly-report.expense');
    Route::get('monthly-report/customer', [App\Http\Controllers\Admin\ReportController::class, 'customerReport'])->name('monthly-report.customer');
    Route::get('monthly-report/product', [App\Http\Controllers\Admin\ReportController::class, 'productReport'])->name('monthly-report.product');
    Route::get('monthly-report/order', [App\Http\Controllers\Admin\ReportController::class, 'orderReport'])->name('monthly-report.order');

    // change password
    Route::get('changePassword', [App\Http\Controllers\Admin\AdminController::class, 'changePassword'])->name('changePassword');
    Route::post('changePassword', [App\Http\Controllers\Admin\AdminController::class, 'changePasswordPost'])->name('changePassword.save');
});
