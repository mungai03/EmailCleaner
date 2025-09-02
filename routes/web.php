<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailDashboardController;
use App\Http\Controllers\EmailProcessingController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Routes
Route::get('/dashboard', [EmailDashboardController::class, 'index'])->name('dashboard.index');
Route::post('/dashboard/test-connection', [EmailDashboardController::class, 'testConnection'])->name('dashboard.test-connection');
Route::get('/dashboard/session/{sessionId}/status', [EmailDashboardController::class, 'sessionStatus'])->name('dashboard.session.status');
Route::get('/dashboard/session/{sessionId}/analytics', [EmailDashboardController::class, 'sessionAnalytics'])->name('dashboard.session.analytics');
Route::get('/dashboard/processing/{sessionId}', [EmailDashboardController::class, 'processingDashboard'])->name('dashboard.processing');
Route::get('/dashboard/results/{sessionId}', [EmailDashboardController::class, 'resultsDashboard'])->name('dashboard.results');

// Processing Routes
Route::post('/processing/start/{sessionId}', [EmailProcessingController::class, 'startProcessing'])->name('processing.start');
Route::post('/processing/pause/{sessionId}', [EmailProcessingController::class, 'pauseProcessing'])->name('processing.pause');
Route::post('/processing/resume/{sessionId}', [EmailProcessingController::class, 'resumeProcessing'])->name('processing.resume');
Route::get('/processing/download/{sessionId}', [EmailProcessingController::class, 'downloadResults'])->name('processing.download');
Route::get('/processing/download/{sessionId}/file/{logId}', [EmailProcessingController::class, 'downloadIndividualFile'])->name('processing.download.file');
Route::get('/processing/logs/{sessionId}', [EmailProcessingController::class, 'getProcessingLogs'])->name('processing.logs');
Route::get('/processing/images/{sessionId}', [EmailProcessingController::class, 'getImageGallery'])->name('processing.images');
Route::get('/processing/attachments/{sessionId}', [EmailProcessingController::class, 'getAttachmentsList'])->name('processing.attachments');
