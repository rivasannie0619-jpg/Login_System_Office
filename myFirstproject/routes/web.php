<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;
use App\Models\Visitor; // ✅ Added this line

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // ✅ Calculate visitor statistics
    $stats = [
        'today' => Visitor::whereDate('time_in', today())->count(),
        'currently_in' => Visitor::whereNull('time_out')->count(),
        'this_week' => Visitor::whereBetween('time_in', [now()->startOfWeek(), now()->endOfWeek()])->count(),
    ];

    // ✅ Pass stats to dashboard view
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
    Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
    Route::patch('/visitors/{visitor}/checkout', [VisitorController::class, 'checkout'])->name('visitors.checkout');
    Route::delete('/visitors/{visitor}', [VisitorController::class, 'destroy'])->name('visitors.destroy');
    Route::get('/visitors-print', [VisitorController::class, 'print'])->name('visitors.print');
    Route::get('/visitors-report', [VisitorController::class, 'report'])->name('visitors.report');
});

require __DIR__.'/auth.php';