<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FinePaymentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ScanController;



Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('member.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('books', BookController::class);
        Route::resource('members', MemberController::class);
        Route::resource('borrowings', BorrowingController::class);
        Route::resource('reservations', ReservationController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('fine-payments', FinePaymentController::class);
        Route::post('/borrowings/{borrowing}/payments', [FinePaymentController::class, 'store'])
            ->name('borrowings.payments.store');
        Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
        Route::post('/scan', [ScanController::class, 'lookup'])->name('scan.lookup');
        Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
            ->name('borrowings.return');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::patch('/reservations/{reservation}/claimed', [ReservationController::class, 'markClaimed'])
            ->name('reservations.claimed');
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])
            ->name('reservations.destroy');
        Route::get('/reports/borrowings/export', [ReportController::class, 'exportBorrowings'])
            ->name('reports.borrowings.export');
        Route::get('/reports/members/export', [ReportController::class, 'exportMembers'])
            ->name('reports.members.export');
    });

Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('member.dashboard');
        })->name('dashboard');
        Route::get('/books', [BookController::class, 'memberIndex'])->name('books.index');
        Route::get('/history', [BorrowingController::class, 'memberHistory'])->name('history');
        Route::post('/books/{book}/reserve', [ReservationController::class, 'store'])
            ->name('books.reserve');
        Route::patch('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
            ->name('reservations.cancel');
    });
