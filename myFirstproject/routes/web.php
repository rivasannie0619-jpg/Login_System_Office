<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;
use App\Models\Visitor;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $stats = [
        'today' => Visitor::whereDate('time_in', today())->count(),
        'currently_in' => Visitor::whereNull('time_out')->count(),
        'this_week' => Visitor::whereBetween('time_in', [now()->startOfWeek(), now()->endOfWeek()])->count(),
    ];
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ⬇️ ILIPAT DITO — bago ang resource route
    Route::get('/visitors/report', [VisitorController::class, 'report'])->name('visitors.report');
    Route::get('/visitors/print', [VisitorController::class, 'print'])->name('visitors.print');
    Route::patch('/visitors/{visitor}/checkout', [VisitorController::class, 'checkout'])->name('visitors.checkout');

    Route::resource('visitors', VisitorController::class); // ⬅️ itong nasa huli na
});

require __DIR__.'/auth.php';