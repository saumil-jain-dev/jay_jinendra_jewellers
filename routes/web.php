<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\GuarantorController;
use App\Http\Controllers\BillingHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GstBillController;
use App\Http\Controllers\PartyController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('test-password', function () {
    return bcrypt('Admin@123');
});
Route::get('login', function () {
    return view('welcome');
})->name('login');
Route::post('login-user', [AuthController::class, 'loginPost'])->name('login-post');
Route::middleware( ['auth'])->group(callback: function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Override the default update route
    Route::resource('users', UserController::class)->except(['update']);
    Route::put('users/{user}/update', [UserController::class, 'update'])->name('users.update');

    Route::resource('parties', PartyController::class)->except(['update']);
    Route::put('parties/{party}', [PartyController::class, 'update'])->name('parties.update');

    Route::delete('/guarantors/{id}', [GuarantorController::class, 'destroy'])->name('guarantors.destroy');

    Route::resource('guarantors', GuarantorController::class);
    Route::resource('cash-recept', BillingHistoryController::class)->except('update','show','destroy','edit');
    Route::get('cash-recept/{id}/show', [BillingHistoryController::class, 'show'])->name('cash-recept.show');
    Route::delete('cash-recept/{id}/destroy', [BillingHistoryController::class, 'destroy'])->name('cash-recept.destroy');
    Route::get('cash-recept/{id}/edit', [BillingHistoryController::class, 'edit'])->name('cash-recept.edit');
    Route::post('invoices/update', [BillingHistoryController::class, 'update'])->name('cash-recept.update');

    Route::resource('invoices', InvoiceController::class)->except(['update']);
    Route::put('invoices/{invoice}/update', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::get('print-invoices/{id}',[InvoiceController::class,'printInvoice'])->name('invoices.print');

    Route::resource('gst-bill', GstBillController::class)->except(['update']);
    Route::put('invoices/{invoice}/update', [GstBillController::class, 'update'])->name('gst-bill.update');
    Route::get('print-invoices/{id}',[GstBillController::class,'printInvoice'])->name('gst-bill.print');

    Route::post('check-user-invoice',[InvoiceController::class,'checkUserInvoice'])->name('users.check-invoice');
    Route::post('get-invoice-details',[BillingHistoryController::class,'getUserInvoice'])->name('users.check-invoice');
    Route::post('get-payment-history',[PartyController::class,'getPaymentHistory'])->name('parties.payment-history');

    Route::get('online-payment', [DashboardController::class, 'onlinePayment'])->name('online-payment.index');
    Route::get('/payments/export', [DashboardController::class, 'exportPayments'])->name('payments.export');
});
