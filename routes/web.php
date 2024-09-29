<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Import the Mail facade
use App\Http\Controllers\AuthManager; // Import the AuthManager class
use App\Http\Controllers\SocialWorkerController; // Import the SocialWorkerController class
use App\Http\Controllers\SocialWorkerAccountController; // Import the SocialWorkerAccountController class
use App\Http\Controllers\FamilyMemberController; // Import the FamilyMemberController class
use App\Http\Controllers\HomeController; // Import the HomeController class
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\LogController; // Import the LogController class


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::post('/preregisters', [ClientController::class, 'store'])->name('preregisters.store');
Route::get('/preregistration', [AuthManager::class, 'preregistration'])->name('preregistration');
Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register.form');
Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register');
Route::get('/logs', [LogController::class, 'index'])->middleware('auth')->name('logs.index');

Route::middleware(['auth'])->group(function () {
    //admin profile
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changepassword'])->name('profile.change-password');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('/register', [App\Http\Controllers\HomeController::class, 'blank'])->name('blank');

    //fetching social worker
    Route::get('/social-worker', [ClientController::class, 'caselist'])->name('social-worker.index')->middleware('social');

    Route::get('/social-worker/{clientId}', [ClientController::class, 'show'])->name('social-worker.index')->middleware('social');
    // generate pdf
    Route::get('/generate-pdf/{id}', [ClientController::class, 'generatePdf'])->name('generate.pdf');
    /*    Route::get('/clients-by-barangay', [ClientController::class, 'home']); */

    Route::get('/income-brackets', [HomeController::class, 'getIncomeBrackets']);
    Route::get('/most-requested-services', [HomeController::class, 'getMostRequestedServices']);


    Route::get('/gender-distribution', [HomeController::class, 'getGenderDistribution']);
    Route::get('/age-group-services', [HomeController::class, 'getAgeGroupServices']);

    // web.php
    Route::get('/view-closed-clients', [ClientController::class, 'viewClosedClients'])->name('social-worker.view-closed-clients')->middleware('social');
    Route::get('/view-ongoing-clients', [ClientController::class, 'viewOngoingClients'])->name('social-worker.view-ongoing-clients')->middleware('social');

    //for family members
    Route::post('/social-worker/family/store', [FamilyMemberController::class, 'store'])->name('social-worker.family.store');
    Route::put('/social-worker/family/update/{id}', [FamilyMemberController::class, 'update'])->name('social-worker.family.update');
    Route::delete('/social-worker/family/{id}', [FamilyMemberController::class, 'destroy'])->name('social-worker.family.destroy');

    Route::delete('/social-worker/delete/{id}', [App\Http\Controllers\ClientController::class, 'destroy'])->name('social-worker.delete')->middleware('social-worker');
    Route::get('/search', [ClientController::class, 'search'])->name('clients.search');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('social-worker.delete');

    /*  Route::get('/admin', [App\Http\Controllers\SocialWorkerController::class, 'index'])->name('admin.index')->middleware('admin'); */


    Route::put('/social-worker/update/{client}', [ClientController::class, 'update']);


    //managing social worker account

    Route::put('/social-worker/update/{id}', [App\Http\Controllers\SocialWorkerController::class, 'update'])->name('social-worker.update')->middleware('social-worker');
    Route::get('/social-worker/edit/{id}', [App\Http\Controllers\SocialWorkerController::class, 'edit'])->name('social-worker.edit')->middleware('social-worker');
    Route::put('/social-worker/update/{id}', [App\Http\Controllers\SocialWorkerController::class, 'update'])->name('social-worker.update')->middleware('social-worker');
    Route::delete('/social-worker/delete/{id}', [App\Http\Controllers\SocialWorkerController::class, 'destroy'])->name('social-worker.delete')->middleware('social-worker');

    // managing admin account
    Route::get('/admin', [SocialWorkerAccountController::class, 'index'])
        ->name('admin.index')
        ->middleware('auth');
    Route::put('/admin/update/{id}', [SocialWorkerAccountController::class, 'update'])->name('admin.update')->middleware('auth');
    Route::delete('/admin/delete/{id}', [SocialWorkerAccountController::class, 'destroy'])->name('admin.delete')->middleware('auth');
});
