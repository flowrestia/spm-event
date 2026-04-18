<?php
// routes/web.php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

// ─── PUBLIC FORM ──────────────────────────────────────────────────────────────
Route::get('/', [FormController::class, 'index'])->name('form.index');
Route::post('/register', [FormController::class, 'store'])->name('form.store');

// ─── ADMIN AUTH ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Participants
        Route::get('/participants', [AdminController::class, 'participants'])->name('participants');
        Route::post('/participants/{participant}/accept', [AdminController::class, 'accept'])->name('participants.accept');
        Route::post('/participants/{participant}/reject', [AdminController::class, 'reject'])->name('participants.reject');
        Route::get('/participants/{participant}/proof', [AdminController::class, 'showProof'])->name('participants.proof');
        Route::get('/participants/{participant}/email-confirmation', [AdminController::class, 'emailConfirmation'])->name('participants.email-confirmation');
        Route::post('/participants/{participant}/confirm-email-sent', [AdminController::class, 'confirmEmailSent'])->name('participants.confirm-email-sent');
        Route::get('/participants/{participant}/download-pdf', [AdminController::class, 'downloadPdf'])->name('participants.download-pdf');

        // Attendance
        Route::get('/attendance', [AdminController::class, 'attendance'])->name('attendance');
        Route::get('/scan', [AdminController::class, 'scanPage'])->name('scan');
        Route::post('/scan/process', [AttendanceController::class, 'scan'])->name('scan.process');

        // Settings
        Route::post('/settings/toggle-form', [AdminController::class, 'toggleForm'])->name('settings.toggle-form');
        Route::post('/settings/upload-header', [AdminController::class, 'uploadHeader'])->name('settings.upload-header');
    });
});
