<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return redirect('/login');
// });

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// // DASHBOARD
// Route::get('/dashboard', function () {
//     $user = auth()->user();

//     if ($user->role === 'admin') return redirect('/admin');
//     if ($user->role === 'manager') return redirect('/manager');
//     return redirect('/staff');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/api/dashboard-data', [BarangController::class, 'dashboardData'])
    ->middleware('auth')
    ->name('api.dashboard-data');

Route::post('/chatbot', [BarangController::class, 'chatbot'])
    ->middleware('auth')
    ->name('chatbot');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ROLE ADMIN
Route::middleware(['auth','role:admin'])->get('/admin', function () {
    return view('admin.dashboard');
});

Route::middleware(['auth','role:manager'])->get('/manager', function () {
    return view('manager.dashboard');
});

Route::middleware(['auth','role:staff'])->get('/staff', function () {
    return view('staff.dashboard');
});


// BARANG
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::resource('barang', BarangController::class);
});


// MONITORING
Route::get('/monitoring', [DashboardController::class, 'monitoring'])
    ->middleware('auth')
    ->name('monitoring');

require __DIR__.'/auth.php';
