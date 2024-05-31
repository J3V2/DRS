<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TrackingNumberController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\NotificationController;
use Chatify\ChatifyMessenger;
use Chatify\Http\Controllers\MessagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/chatify',[MessagesController::class, 'index'])->name('chatify');

// Login System
Route::get('/',[AuthController::class, 'login']);
Route::post('/login',[AuthController::class, 'AuthLogin']);
Route::get('/logout',[AuthController::class, 'logout']);
Route::get('/forgot-password',[AuthController::class, 'forgot_password']);
Route::post('/forgot-password',[AuthController::class, 'postForgotPassword']);
Route::get('/reset-password/{token}', [AuthController::class, 'reset_password']);
Route::post('post-reset-password/{token}', [AuthController::class, 'postResetPassword'])->name('post-reset-password');
// Settings
Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
Route::post('/settings/update-password', [SettingsController::class, 'updatePassword'])->name('update-password');


// Notifications
Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('get-notifications');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-notifications-as-read');

Route::group(['middleware' => 'admin'], function() {
// Reports
    Route::get('/admin/reports',[DashboardController::class, 'reports'])->name('admin-reports');
// Download Reports
    Route::get('/download-reports',[AdminController::class, 'downloadReports'])->name('download.reports');
// Office
    Route::get('/admin/offices',[AdminController::class, 'offices'])->name('admin-offices');
    Route::post('/admin/offices/add', [AdminController::class, 'addOffice'])->name('addOffice');
    Route::get('/admin/offices/edit/{id}', [AdminController::class, 'editOffice'])->name('editOffice');
    Route::post('/admin/offices/update/{id}', [AdminController::class, 'updateOffice'])->name('updateOffice');
    Route::get('/admin/offices/delete/{id}', [AdminController::class, 'deleteOffice'])->name('deleteOffice');
// User
    Route::get('/admin/users',[AdminController::class, 'users'])->name('admin-users');
    Route::post('/admin/users/add', [AdminController::class, 'addUser'])->name('addUser');
    Route::get('/admin/users/edit/{id}', [AdminController::class, 'editUser'])->name('editUser');
    Route::post('/admin/users/update/{id}', [AdminController::class, 'updateUser'])->name('updateUser');
    Route::get('/admin/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
// Tracking Documents
    Route::get('/admin/tracking-document', [AdminController::class, 'track'])->name('admin-track');
    Route::post('/admin/tracking-document', [AdminController::class, 'track_docs'])->name('track-docs');
// Document Types
    Route::get('/admin/document-types', [AdminController::class, 'types'])->name('admin-types');
    Route::post('/admin/document-types/add', [AdminController::class, 'addType'])->name('addType');
    Route::get('/admin/document-types/edit/{id}', [AdminController::class, 'editType'])->name('editType');
    Route::post('/admin/document-types/update/{id}', [AdminController::class, 'updateType'])->name('updateType');
    Route::get('/admin/document-types/delete/{id}', [AdminController::class, 'deleteType'])->name('deleteType');
// Document Actions
    Route::get('/admin/document-actions', [AdminController::class, 'actions'])->name('admin-actions');
    Route::post('/admin/document-actions/add', [AdminController::class, 'addAction'])->name('addAction');
    Route::get('/admin/document-actions/edit/{id}', [AdminController::class, 'editAction'])->name('editAction');
    Route::post('/admin/document-actions/update/{id}', [AdminController::class, 'updateAction'])->name('updateAction');
    Route::get('/admin/document-actions/delete/{id}', [AdminController::class, 'deleteAction'])->name('deleteAction');
// Configurations
    Route::get('/admin/configurations',[AdminController::class, 'configs'])->name('admin-configs');
// System Logs
    Route::get('/admin/system-logs',[AdminController::class, 'logs'])->name('admin-logs');
// Settings
    Route::get('/admin/settings', [SettingsController::class, 'admin_settings'])->name('admin-settings');
    Route::post('/admin/settings/update-password', [SettingsController::class, 'admin_updatePassword'])->name('admin-update-password');
// DRS Guides
    Route::get('/admin/drs-guides',[AdminController::class, 'guides'])->name('admin-guides');
});

Route::group(['middleware' => 'user'], function() {
// Download Paper Trail
    Route::get('/download-paper-trail/{documentId}',[DocumentController::class, 'downloadPaperTrail'])->name('download.paper.trail');
// Dashboard
    Route::get('/user/dashboard',[DashboardController::class, 'dashboard'])->name('user-dashboard');
// Add Document
    Route::get('/user/add',[DocumentController::class, 'drs_add'])->name('drs-add');
    Route::post('/user/add-document',[DocumentController::class, 'addDocument'])->name('addDocument');
// Receive Document
    Route::get('/user/receive-document/',[DashboardController::class, 'receive'])->name('receive');
// For Receiving
    Route::get('/user/office-documents/for-receiving',[DocumentController::class, 'forReceived'])->name('user-for-receiving');
    Route::post('/user/received-document/{tracking_number}',[DocumentController::class, 'receiveDocument'])->name('receiveDocument');
// Release Document
    Route::post('/user/release-document/',[DashboardController::class, 'release'])->name('release');
// For Releasing
    Route::get('/user/office-documents/for-releasing',[DocumentController::class, 'forReleased'])->name('user-for-releasing');
    Route::post('/user/release/{tracking_number}',[DocumentController::class, 'drs_release'])->name('drs-release');
    Route::post('/user/released-document/{tracking_number}',[DocumentController::class, 'releaseDocument'])->name('releaseDocument');
    Route::get('/user/released-document/finalized-document/{id}',[DocumentController::class, 'finalizedReleased'])->name('final-release');
// Tracking Document
    Route::get('/user/track-document/',[DashboardController::class, 'track'])->name('track');
    //Route::post('/user/track/{tracking_number}',[DocumentController::class, 'drs_track'])->name('drs-track');
// Tag as Terminal
    Route::post('/user/tag-document/',[DashboardController::class, 'tag'])->name('tag');
    Route::get('/user/office-documents/tagged-as-terminal',[DocumentController::class, 'tagTerminal'])->name('user-office-terminal');
    Route::post('/user/tag-as-terminal/{tracking_number}',[DocumentController::class, 'drs_tag'])->name('drs-tag');
    Route::post('/user/tag-document/{tracking_number}',[DocumentController::class, 'tagDocument'])->name('tagDocument');
    Route::get('/user/tag-document/{id}',[DocumentController::class, 'viewTag'])->name('view-Tag');
// Finalized Document
    Route::get('/user/finalized-document/{id}',[DocumentController::class, 'finalized'])->name('drs-final');
// Office Documents
    Route::get('/user/office-documents',[DocumentController::class, 'office_docs'])->name('user-office-docs');
// Office Reports
    Route::get('/user/office-documents/office-reports',[DocumentController::class, 'officeReports'])->name('user-office-reports');
// DRS Users
    Route::get('/user/office-documents/drs-users',[DocumentController::class, 'drs_users'])->name('user-office-guides');
// My Documents
    Route::get('/user/my-documents',[DocumentController::class, 'myDocs'])->name('user-my-docs');
    Route::post('/user/my-documents/{tracking_number}',[DocumentController::class, 'view'])->name('view');
// My Received
    Route::get('/user/my-documents/received',[DocumentController::class, 'myReceived'])->name('user-my-received');
// My Released
    Route::get('/user/my-documents/released',[DocumentController::class, 'myReleased'])->name('user-my-released');
// My Tag as Terminal
    Route::get('/user/my-documents/tagged-as-terminal',[DocumentController::class, 'myTag'])->name('user-my-terminal');
// My Tracking Numbers
    Route::get('/user/my-documents/my-tracking-numbers', [TrackingNumberController::class, 'trackingnumber'])->name('user-my-numbers');
    Route::get('/generate-tracking-numbers', [TrackingNumberController::class, 'generateTrackingNumbers'])->name('generate-tracking-numbers');
    Route::post('/invalidate-tracking-number', [TrackingNumberController::class, 'invalidateTrackingNumber'])->name('invalidate-tracking-number');
    Route::get('/download-tracking-numbers', [TrackingNumberController::class, 'downloadTrackingNumbers'])->name('download-tracking-numbers');

// My Reports
    Route::get('/user/my-documents/my-reports',[DocumentController::class, 'myReports'])->name('user-my-reports');
// Settings
    Route::get('/user/settings', [SettingsController::class, 'user_settings'])->name('user-settings');
    Route::post('/user/settings/update-password', [SettingsController::class, 'user_updatePassword'])->name('user-update-password');
// DRS Guides
    Route::get('/user/drs-guides',[DocumentController::class, 'drs_guide'])->name('user-guides');
});
