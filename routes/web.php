<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\MyJobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'index']);

Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::middleware('auth')->group(function () {
Route::get('/applications/{applicationId}/download-cv', [JobController::class, 'downloadCv'])->name('applications.download-cv');
});
Route::get('/search', SearchController::class);
Route::get('/tags/{tag:name}', TagController::class);
Route::get('/myjobs', [MyJobController::class,'index']);
Route::middleware('auth')->group(function () {
    Route::get('/jobs/{job}/apply', [JobController::class, 'showApplicationForm'])->name('jobs.apply');
    Route::post('/jobs/{job}/apply', [JobController::class, 'storeApplication'])->name('jobs.storeApplication');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
