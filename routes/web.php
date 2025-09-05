<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailDashboardController;
use App\Http\Controllers\EmailProcessingController;
use App\Http\Controllers\OAuthController;

Route::get('/', function () {
    $response = response()->view('welcome');
    
    // Add cache-busting headers
    $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
    
    return $response;
});

// Dashboard Routes
Route::get('/dashboard', [EmailDashboardController::class, 'index'])->name('dashboard.index');
Route::get('/connect', [EmailDashboardController::class, 'connect'])->name('dashboard.connect');
Route::post('/dashboard/test-connection', [EmailDashboardController::class, 'testConnection'])->name('dashboard.test-connection');
Route::get('/dashboard/session/{sessionId}/status', [EmailDashboardController::class, 'sessionStatus'])->name('dashboard.session.status');
Route::get('/dashboard/session/{sessionId}/analytics', [EmailDashboardController::class, 'sessionAnalytics'])->name('dashboard.session.analytics');
Route::get('/dashboard/processing/{sessionId}', [EmailDashboardController::class, 'processingDashboard'])->name('dashboard.processing');
Route::get('/dashboard/results/{sessionId}', [EmailDashboardController::class, 'resultsDashboard'])->name('dashboard.results');

// Email Access Routes
Route::get('/dashboard/emails/{sessionId}', [EmailDashboardController::class, 'viewEmails'])->name('dashboard.emails');
Route::get('/dashboard/emails/{sessionId}/fetch', [EmailDashboardController::class, 'fetchEmails'])->name('dashboard.emails.fetch');
Route::get('/dashboard/emails/{sessionId}/content/{uid}', [EmailDashboardController::class, 'getEmailContent'])->name('dashboard.emails.content');
Route::get('/dashboard/emails/{sessionId}/folders', [EmailDashboardController::class, 'getFolders'])->name('dashboard.emails.folders');
Route::get('/dashboard/emails/{sessionId}/folder/{folderName}', [EmailDashboardController::class, 'getEmailsFromFolder'])->name('dashboard.emails.folder');

// OAuth Routes
Route::get('/oauth/{provider}/redirect', [OAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('/oauth/{provider}/callback', [OAuthController::class, 'callback'])->name('oauth.callback');
Route::post('/oauth/{sessionId}/disconnect', [OAuthController::class, 'disconnect'])->name('oauth.disconnect');
Route::post('/oauth/{sessionId}/refresh', [OAuthController::class, 'refreshTokens'])->name('oauth.refresh');

// Processing Routes
Route::post('/processing/start/{sessionId}', [EmailProcessingController::class, 'startProcessing'])->name('processing.start');
Route::post('/processing/pause/{sessionId}', [EmailProcessingController::class, 'pauseProcessing'])->name('processing.pause');
Route::post('/processing/resume/{sessionId}', [EmailProcessingController::class, 'resumeProcessing'])->name('processing.resume');
Route::get('/processing/download/{sessionId}', [EmailProcessingController::class, 'downloadResults'])->name('processing.download');
Route::get('/processing/download/{sessionId}/file/{logId}', [EmailProcessingController::class, 'downloadIndividualFile'])->name('processing.download.file');
Route::get('/processing/logs/{sessionId}', [EmailProcessingController::class, 'getProcessingLogs'])->name('processing.logs');
Route::get('/processing/images/{sessionId}', [EmailProcessingController::class, 'getImageGallery'])->name('processing.images');
Route::get('/processing/attachments/{sessionId}', [EmailProcessingController::class, 'getAttachmentsList'])->name('processing.attachments');
