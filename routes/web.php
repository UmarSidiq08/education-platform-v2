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
use App\Http\Controllers\PostTestController;
use App\Http\Controllers\AchievementController;
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

Route::get('/navbar/achievement', function () {
    return view('navbar.achievement');
})->name('navbar.achievement')->middleware('auth');



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
     Route::get('/achievements/{class}', [AchievementController::class, 'show'])
        ->name('achievements.show');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Support both PATCH and PUT methods for profile update
    Route::match(['patch', 'put'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile routes tambahan (dari File 1)
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update.custom');
    Route::post('/profile/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.upload-avatar');
 Route::put('/profile/update-profile', [ProfileController::class, 'updateProfile'])
        ->name('profile.updateProfile');   

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
    // Route untuk mentor melihat list approval requests - TARUH DI ATAS

    Route::get('/post-tests/approval-requests', [PostTestController::class, 'approvalRequests'])
        ->name('post_tests.approval_requests');

    // Route classes
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
    Route::get('/classes/{id}/learn', [ClassController::class, 'learn'])->name('classes.learn');
    Route::get('/achievements', [AchievementController::class, 'index'])
        ->name('achievements.index');

    // Route materials
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');

    // Route quizzes
    Route::get('materials/{material}/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('materials/{material}/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('materials/{material}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('materials/{material}/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('materials/{material}/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update');
    Route::patch('quizzes/{quiz}/activate', [QuizController::class, 'activate'])->name('quizzes.activate');
    Route::post('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::post('/quizzes/{quiz}/submit-auto', [QuizController::class, 'autoSubmit'])->name('quizzes.auto-submit');
    Route::post('/quizzes/{quiz}/save-progress', [QuizController::class, 'saveProgress'])->name('quizzes.saveProgress');
    Route::get('/quizzes/{quiz}/check-timer', [QuizController::class, 'checkTimer'])->name('quizzes.check-timer');
    Route::post('/quizzes/{quiz}/update-timer', [QuizController::class, 'updateTimer'])->name('quizzes.update-timer');

    // Route post-tests dengan prefix
    Route::prefix('classes/{class}')->group(function () {
        Route::get('/post-tests/create', [PostTestController::class, 'create'])->name('post_tests.create');
        Route::post('/post-tests', [PostTestController::class, 'store'])->name('post_tests.store');
        Route::get('/post-tests/{postTest}/edit', [PostTestController::class, 'edit'])->name('post_tests.edit');
        Route::put('/post-tests/{postTest}', [PostTestController::class, 'update'])->name('post_tests.update');
        Route::delete('/post-tests/{postTest}', [PostTestController::class, 'destroy'])->name('post_tests.destroy');
        Route::patch('/post-tests/{postTest}/toggle-status', [PostTestController::class, 'toggleStatus'])->name('post_tests.toggle_status');
        Route::post('/post-tests/{postTest}/duplicate', [PostTestController::class, 'duplicate'])->name('post_tests.duplicate');
    });

    // Route post-tests individual - TARUH SETELAH ROUTE TANPA PARAMETER
    Route::prefix('post-tests')->group(function () {
        // Route untuk request approval
        Route::get('/{postTest}/request-approval', [PostTestController::class, 'showRequestApprovalForm'])
            ->name('post_tests.request_approval.form');
        Route::post('/{postTest}/request-approval', [PostTestController::class, 'requestApproval'])
            ->name('post_tests.request_approval.submit');

        // Route untuk mentor approve attempt
        Route::post('/{postTest}/approve/{attemptId}', [PostTestController::class, 'approveAttempt'])
            ->name('post_tests.approve_attempt');

        // Route post-tests lainnya

        Route::get('/{postTest}', [PostTestController::class, 'show'])->name('post_tests.show');
        Route::post('/{postTest}/start', [PostTestController::class, 'start'])->name('post_tests.start');
        Route::post('/{postTest}/submit', [PostTestController::class, 'submit'])->name('post_tests.submit');
        Route::post('/{postTest}/activate', [PostTestController::class, 'activate'])->name('post_tests.activate');
        Route::post('/{postTest}/update-timer', [PostTestController::class, 'updateTimer'])->name('post_tests.updateTimer');
        Route::post('/{postTest}/save-progress', [PostTestController::class, 'saveProgress'])->name('post_tests.saveProgress');
    });
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
