<?php

use App\Http\Controllers\ImprestWarrant\AccountController;
use App\Http\Controllers\ImprestWarrant\DepartmentController;
use App\Http\Controllers\ImprestWarrant\ProjectController;
use App\Http\Controllers\ImprestWarrant\StaffController;
use App\Http\Controllers\ImprestWarrant\SurrenderController;
use App\Http\Controllers\ImprestWarrant\WarrantController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// imprest warrant
Route::middleware('auth')->group(function () {
    Route::resource('accounts', AccountController::class)->except(['create', 'edit']);
    Route::resource('departments', DepartmentController::class)->except(['create', 'edit']);
    Route::resource('staff', StaffController::class)->except(['create', 'edit']);
    Route::resource('projects', ProjectController::class)->except(['create', 'edit']);
    Route::resource('warrants', WarrantController::class);
    Route::resource('surrenders', SurrenderController::class);

    // api
    require __DIR__ . '/web_api.php';
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
