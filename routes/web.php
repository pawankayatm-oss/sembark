<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\{CompanyController,UserController,InvitationController};

Route::get('/', function () {
    return redirect('login');
});

Route::get('dashboard',[DashboardController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/accept-invitation/{token}', [InvitationController::class, 'accept']);
Route::post('/accept-invitation', [InvitationController::class, 'complete']);


Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {

    Route::get('/companies/create', [CompanyController::class, 'create'])
        ->name('companies.create');

    Route::post('/companies', [CompanyController::class, 'store'])
        ->name('companies.store');

        Route::get('/companies', [CompanyController::class, 'index'])
        ->name('companies.index');

        Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])
        ->name('companies.edit');
    
    Route::put('/companies/{company}', [CompanyController::class, 'update'])
        ->name('companies.update');
});


Route::middleware(['auth', 'role:SuperAdmin|Admin'])->group(function () {

    // Route::get('/user/create', [UserController::class, 'create'])
    // ->name('user.create');

    Route::get('/invitation/index', [InvitationController::class, 'index'])
    ->name('invitation.index');


    Route::get('/invitation/create', [InvitationController::class, 'create'])
    ->name('invitation.create');

    Route::post('/invitation/store', [InvitationController::class, 'store'])
    ->name('invitation.store');

    //Route::resource('/invitation',InvitationController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
