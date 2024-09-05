<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LawwyerController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        if (auth()->user()->isLawyer()) {
            return redirect()->route('lawyer.dashboard');
        }
        return redirect()->route('client.dashboard');
    })->name('dashboard');

    Route::middleware(['role:client'])->group(function () {
        Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    });

    Route::middleware(['role:lawyer'])->group(function () {
        Route::get('/lawyer/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
    });

});

require __DIR__.'/auth.php';
