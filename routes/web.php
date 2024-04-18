<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ChatController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/chat-messages', [ChatController::class, 'Messages'])->name('messages');
Route::get('/get-messages', [ChatController::class, 'getMessages'])->name('get-messages');
Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send-message');

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

Route::group(['middleware' => 'admin'], function() {
// Reports
    Route::get('/admin/reports',[DashboardController::class, 'reports'])->name('admin-reports');
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
    Route::get('/admin/tracking-document',[AdminController::class, 'track'])->name('admin-track');
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
// Dashboard
    Route::get('/user/dashboard',[DashboardController::class, 'dashboard'])->name('user-dashboard');
// Add Document
    Route::get('/user/add',[DocumentController::class, 'drs_add'])->name('drs-add');
    Route::post('/user/add-document',[DocumentController::class, 'addDocument'])->name('addDocument');
// Receive Document
    Route::get('/user/receive-document', function () {
        return view('user.receive');
    })->name('drs-receive');
// Release Document
    Route::get('/user/release-document', function () {
        return view('user.release');
    })->name('drs-release');
// Tracking Document
    Route::get('/user/tracking-document', function () {
        return view('user.track');
    })->name('drs-track');
// Tag as Terminal
    Route::get('/user/tag-as-terminal', function () {
        return view('user.tag');
    })->name('drs-tag');
// Finalized Document
    Route::get('/user/finalized-document/{id}',[DocumentController::class, 'finalized'])->name('drs-final');
// View Document
    Route::get('/user/view-document',[DocumentController::class, 'view'])->name('drs-view');
// Office Documents
    Route::get('/user/office-documents', function () {
        return view('user.office.docs');
    })->name('user-office-docs');

// For Receiving
    Route::get('/user/office-documents/for-receiving',[DocumentController::class, 'forReceived'])->name('user-for-receiving');
    Route::post('/user/received-document/{tracking_number}',[DocumentController::class, 'receiveDocument'])->name('receiveDocument');

// For Releasing
    Route::get('/user/office-documents/for-releasing', function () {
        return view('user.office.releasing');
    })->name('user-office-releasing');
// Tagged as Terminal
    Route::get('/user/office-documents/tagged-as-terminal', function () {
        return view('user.office.terminal');
    })->name('user-office-terminal');
// Office Reports
    Route::get('/user/office-documents/office-reports', function () {
        return view('user.office.reports');
    })->name('user-office-reports');
// DRS Users
    Route::get('/user/office-documents/drs-users', function () {
        return view('user.office.guides');
    })->name('user-office-guides');
// My Documents
    Route::get('/user/my-documents', function () {
        return view('user.my.docs');
    })->name('user-my-docs');
// Received
    Route::get('/user/my-documents/received', function () {
        return view('user.my.received');
    })->name('user-my-received');
// Released
    Route::get('/user/my-documents/released', function () {
        return view('user.my.released');
    })->name('user-my-released');
// Tag as Terminal
    Route::get('/user/my-documents/tagged-as-terminal', function () {
        return view('user.my.terminal');
    })->name('user-my-terminal');
// My Tracking Numbers
    Route::get('/user/my-documents/my-tracking-numbers', function () {
        return view('user.my.numbers');
    })->name('user-my-numbers');
// My Reports
    Route::get('/user/my-documents/my-reports', function () {
        return view('user.my.reports');
    })->name('user-my-reports');
// Settings
    Route::get('/user/settings', [SettingsController::class, 'user_settings'])->name('user-settings');
    Route::post('/user/settings/update-password', [SettingsController::class, 'user_updatePassword'])->name('user-update-password');
// DRS Guides
    Route::get('/user/drs-guides', function () {
        return view('user.guides');
    })->name('user-guides');
});
