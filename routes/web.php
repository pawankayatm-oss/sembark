<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CompanyController,DashboardController,InvitationController,ShortUrlController};

Route::get('/', function () {
    return redirect('login');
});

Route::get('dashboard',[DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/accept-invitation/{token}', [InvitationController::class, 'accept_invitation']);
Route::post('/accept-invitation', [InvitationController::class, 'complete_invitation']);

// Company Routes
Route::middleware(['auth', 'role:SuperAdmin'])->group(function() {

    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{company}', [CompanyController::class, 'update'])->name('companies.update');

});

// Invitation Routes
Route::middleware(['auth', 'role:SuperAdmin|Admin'])->group(function() {

    Route::get('/invitation/index', [InvitationController::class, 'index'])->name('invitation.index');
    Route::get('/invitation/create', [InvitationController::class, 'create'])->name('invitation.create');
    Route::post('/invitation/store', [InvitationController::class, 'store'])->name('invitation.store');

});

// shorturls routes
Route::get('/shorturl',[ShortUrlController::class,'index'])->name('shorturl.index')->middleware('auth');
Route::get('/u/{shorturl_code}',[ShortUrlController::class,'openShortCode'])->name('open_shortcode');
Route::middleware(['auth','role:Admin|Member'])->group(function(){

    Route::get('/shorturl/create',[ShortUrlController::class,'create'])->name('shorturl.create');
    Route::post('/shorturl/store',[ShortUrlController::class,'store'])->name('shorturl.store');
    Route::delete('/shorturl/destroy/{id}',[ShortUrlController::class,'destroy'])->name('shorturl.destroy');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
