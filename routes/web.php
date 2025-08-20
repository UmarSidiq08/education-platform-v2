<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\NavbarMentorController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verify.mentor'])
    ->name('dashboard');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:guru'])
    ->name('admin.dashboard');

Route::get('/mentor/waiting', function () {
    return view('mentor.waiting');
})->name('mentor.waiting')->middleware('auth');

// Navigation Routes
Route::get('/navbar/classes', [ClassController::class, 'index'])
    ->name('navbar.classes')
    ->middleware('auth');

Route::get('/navbar/mentor', function () {
    return view('navbar.mentor');
})->name('navbar.mentor')->middleware('auth');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Profile Routes - BERSIH (dari File 1 yang TIDAK ERROR)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profile routes - HANYA SATU DEFINISI untuk setiap route
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Support both PATCH and PUT methods for profile update
    Route::match(['patch', 'put'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile routes tambahan (dari File 1)
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update.custom');
    Route::post('/profile/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.upload-avatar');

    // User show route
    Route::get('/user/{id}', [ProfileController::class, 'show'])->name('user.show');
});

// Dummy routes - FIXED: redirect ke route yang benar
Route::get('/projects/create', function () {
    return redirect()->route('profile.index')->with('info', 'Fitur create project akan segera hadir!');
})->name('projects.create')->middleware('auth');

Route::get('/reports', function () {
    return redirect()->route('profile.index')->with('info', 'Fitur reports akan segera hadir!');
})->name('reports.index')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Class Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
    Route::get('/classes/{id}/learn', [ClassController::class, 'learn'])->name('classes.learn');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('materials/{material}/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('materials/{material}/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');

    Route::post('materials/{material}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');

    // Tambahkan route edit dan update ini
    Route::get('materials/{material}/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('materials/{material}/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');

    Route::patch('quizzes/{quiz}/activate', [QuizController::class, 'activate'])->name('quizzes.activate');

    // FIXED: Route quiz yang diperbaiki
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');

    // FIXED: Route untuk auto submit dan save progress - ubah method untuk konsistensi
    Route::post('/quizzes/{quiz}/submit-auto', [QuizController::class, 'autoSubmit'])->name('quizzes.auto-submit');
    Route::post('/quizzes/{quiz}/save-progress', [QuizController::class, 'saveProgress'])->name('quizzes.saveProgress');
    Route::get('/quizzes/{quiz}/check-timer', [QuizController::class, 'checkTimer'])->name('quizzes.check-timer');
    Route::post('/quizzes/{quiz}/update-timer', [QuizController::class, 'updateTimer'])->name('quizzes.update-timer');
});

/*
|--------------------------------------------------------------------------
| Mentor Routes (Role: mentor)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mentor'])->group(function () {
    Route::controller(ClassController::class)->group(function () {
        Route::get('/my-classes', 'my')->name('classes.my');
        Route::get('/create', 'create')->name('classes.create');
        Route::post('/classes', 'store')->name('classes.store');
        Route::get('/classes/{id}/edit', 'edit')->name('classes.edit');
        Route::put('/classes/{id}', 'update')->name('classes.update');
        Route::delete('/classes/{id}', 'destroy')->name('classes.destroy');
        Route::post('/quizzes/{quiz}/activate', [QuizController::class, 'activate'])->name('quizzes.activate');
    });

    Route::controller(MaterialController::class)->group(function () {
        Route::get('/materials/create/{class}', 'create')->name('materials.create');
        Route::get('/materials/{material}/edit', 'edit')->name('materials.edit');
        Route::put('/materials/{material}', 'update')->name('materials.update');
        Route::delete('/materials/{material}', 'destroy')->name('materials.destroy');
        Route::post('/materials', 'store')->name('materials.store');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: guru)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/mentor/pending', [MentorController::class, 'pending'])->name('mentor.pending');
    Route::post('/mentor/approve/{user}', [MentorController::class, 'approve'])->name('mentor.approve');
    Route::post('/mentor/reject/{user}', [MentorController::class, 'reject'])->name('mentor.reject');
});

// Mentor profile
Route::get('/mentor/{id}', function ($id) {
    return "Profile mentor ID: " . $id;
})->name('mentor.profile')->middleware('auth');

Route::get('/mentor', [MentorController::class, 'index'])->name('mentor.index');
Route::get('/mentor/{id}', [MentorController::class, 'show'])->name('mentor.show');

Route::get('/navbar/mentor', [MentorController::class, 'index'])->name('mentor.index');
Route::get('/navbar/mentor/{id}', [MentorController::class, 'show'])->name('mentor.show');

Route::get('/mentor', [MentorController::class, 'index'])->name('navbar.mentor');

// Auth routes
require __DIR__ . '/auth.php';
