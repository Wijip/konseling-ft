<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CounselingController as AdminCounselingController;
use App\Http\Controllers\Admin\MeetingScheduleController;
use App\Http\Controllers\Admin\MeetingBookingController;
use App\Http\Controllers\Admin\CounselorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Counseling (Protected by Auth & Prevent Admin - Hanya Pengguna Non-Admin)
Route::prefix('counseling')->name('counseling.')->middleware(['auth', 'prevent_admin'])->group(function () {
    Route::get('/mode', [CounselingController::class, 'mode'])->name('mode');
    Route::get('/identity', [CounselingController::class, 'identity'])->name('identity');
    Route::get('/form/{type}', [CounselingController::class, 'create'])->name('create');
    Route::post('/', [CounselingController::class, 'store'])->name('store');
    Route::get('/{code}/confirmation', [CounselingController::class, 'confirmation'])->name('confirmation');
    Route::get('/{code}/chat', [CounselingController::class, 'chat'])->name('chat');
    Route::post('/{code}/message', [CounselingController::class, 'sendMessage'])->name('message');
    // Polling route
    Route::get('/{code}/messages', [CounselingController::class, 'getMessages'])->name('messages');
});

// Meeting (Protected by Auth & Prevent Admin - Hanya Pengguna Non-Admin)
Route::prefix('meeting')->name('meeting.')->middleware(['auth', 'prevent_admin'])->group(function () {
    Route::get('/', [MeetingController::class, 'index'])->name('index'); // Landing for meeting choice? Or redirect to calendar?
    Route::get('/calendar', [MeetingController::class, 'calendar'])->name('calendar');
    Route::get('/book/{schedule}', [MeetingController::class, 'create'])->name('create');
    Route::post('/', [MeetingController::class, 'store'])->name('store');
});

// Tracking
Route::prefix('tracking')->name('tracking.')->group(function () {
    Route::get('/', [TrackingController::class, 'index'])->name('index');
    Route::post('/', [TrackingController::class, 'check'])->name('check');
    Route::get('/{code}', [TrackingController::class, 'show'])->name('show');
});

// Auth Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
    
    // Route Registrasi
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes (Protected by Auth & Admin Role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Custom route for reply MUST be before resource or handled specifically
    Route::post('counseling/{id}/reply', [AdminCounselingController::class, 'reply'])->name('counseling.reply');

    // Route Export Excel & PDF Konseling Admin
    Route::get('counseling/export', [AdminCounselingController::class, 'export'])->name('counseling.export');
    Route::get('counseling/export-pdf', [AdminCounselingController::class, 'exportPdf'])->name('counseling.exportPdf');

    Route::get('bookings/export', [MeetingBookingController::class, 'export'])->name('bookings.export');

    Route::resource('counseling', AdminCounselingController::class);
    Route::resource('schedules', MeetingScheduleController::class);
    Route::resource('bookings', MeetingBookingController::class);
    Route::resource('counselors', CounselorController::class);
});