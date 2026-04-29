<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SafeController;
use App\Http\Controllers\AuditLogController;
use App\Models\Loan;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'customerCount' => Customer::count(),
        'activeLoansCount' => Loan::where('status', 'active')->count(),
        'itemsCount' => Item::count(),
        'totalLoanAmount' => Loan::where('status', 'active')->sum('loan_amount'),
        'recentLoans' => Loan::with('customer')->latest()->limit(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pawnshop Management
    Route::resource('customers', CustomerController::class);
    Route::resource('items', ItemController::class);
    Route::resource('loans', LoanController::class);
    Route::post('/loans/{loan}/mark-as-paid', [LoanController::class, 'markAsPaid'])->name('loans.mark-as-paid');
    Route::post('/loans/{loan}/mark-as-forfeited', [LoanController::class, 'markAsForfeited'])->name('loans.mark-as-forfeited');
    
    // Payments
    Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('/payments/loan/{loanId}', [PaymentController::class, 'create'])->name('payments.create.for-loan');

    // Categories and Safes (for item management)
    Route::resource('categories', CategoryController::class);
    Route::resource('safes', SafeController::class);
});

// Admin Only Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index')->middleware('admin');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show')->middleware('admin');
});

require __DIR__.'/auth.php';
