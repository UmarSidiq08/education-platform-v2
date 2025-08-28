<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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
use App\Http\Controllers\TeacherClassController;
use App\Http\Controllers\MentorRequestController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PublicTeacherClassController;
use Dom\Implementation;


Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// PERBAIKAN: Pindahkan route API check-name ke bagian atas dan ubah path
// Route untuk check name availability (tidak perlu auth)
Route::post('/api/check-name', [RegisteredUserController::class, 'checkName'])
    ->name('api.check-name');

// Route untuk get teacher classes (tidak perlu auth untuk registrasi)
Route::get('/api/teacher-classes', [TeacherClassController::class, 'getForDropdown'])
    ->name('api.teacher-classes');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verify.mentor'])
    ->name('dashboard');

Route::get('/admin/dashboard', [TeacherClassController::class, 'index'])
    ->middleware(['auth', 'role:guru'])
    ->name('admin.dashboard');

Route::get('/mentor/waiting', function () {
    return view('mentor.waiting');
})->name('mentor.waiting')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/navbar/classes', [ClassController::class, 'index'])
        ->name('navbar.classes');

    Route::get('/navbar/mentor', function () {
        return view('navbar.mentor');
    })->name('navbar.mentor');

    Route::get('/navbar/achievement', function () {
        return view('navbar.achievement');
    })->name('navbar.achievement');
});


Route::middleware('auth')->controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile.index');
    Route::get('/profile/edit', 'edit')->name('profile.edit');
    Route::match(['patch', 'put'], '/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
    Route::post('/profile/update', 'updateProfile')->name('profile.update.custom');
    Route::post('/profile/upload-avatar', 'uploadAvatar')->name('profile.upload-avatar');
    Route::put('/profile/update-profile', 'updateProfile')->name('profile.updateProfile');
    Route::get('/user/{id}', 'show')->name('user.show');
});

Route::middleware('auth')->controller(AchievementController::class)->group(function () {
    Route::get('/achievements', 'index')->name('achievements.index');
    Route::get('/achievements/{class}', 'show')->name('achievements.show');
});

Route::middleware('auth')->controller(MentorController::class)->group(function () {
    Route::get('/mentor', 'index')->name('mentor.index');
    Route::get('/mentor/{id}', 'show')->name('mentor.show');
    Route::get('/navbar/mentor', 'index')->name('navbar.mentor');
    Route::get('/navbar/mentor/{id}', 'show')->name('mentor.show');
});

Route::middleware('auth')->controller(ClassController::class)->group(function () {
    Route::get('/classes', 'index')->name('classes.index');
    Route::get('/classes/{id}', 'show')->name('classes.show');
    Route::get('/classes/{id}/learn', 'learn')->name('classes.learn');
});
Route::middleware('auth')->controller(MaterialController::class)->group(function () {
    Route::get('/materials/{material}', 'show')->name('materials.show');
});
Route::middleware('auth')->prefix('materials/{material}')->controller(QuizController::class)->group(function () {
    Route::get('/quizzes', 'index')->name('quizzes.index');
    Route::get('/quizzes/create', 'create')->name('quizzes.create');
    Route::post('/quizzes', 'store')->name('quizzes.store');
    Route::get('/quizzes/{quiz}/edit', 'edit')->name('quizzes.edit');
    Route::put('/quizzes/{quiz}', 'update')->name('quizzes.update');
});
Route::middleware('auth')->prefix('quizzes')->controller(QuizController::class)->group(function () {
    Route::get('/{quiz}', 'show')->name('quizzes.show');
    Route::patch('/{quiz}/activate', 'activate')->name('quizzes.activate');
    Route::post('/{quiz}/start', 'start')->name('quizzes.start');
    Route::post('/{quiz}/submit', 'submit')->name('quizzes.submit');
    Route::post('/{quiz}/submit-auto', 'autoSubmit')->name('quizzes.auto-submit');
    Route::post('/{quiz}/save-progress', 'saveProgress')->name('quizzes.saveProgress');
    Route::get('/{quiz}/check-timer', 'checkTimer')->name('quizzes.check-timer');
    Route::post('/{quiz}/update-timer', 'updateTimer')->name('quizzes.update-timer');
});

Route::middleware('auth')->controller(PostTestController::class)->group(function () {
    Route::get('/post-tests/approval-requests', 'approvalRequests')
        ->name('post_tests.approval_requests');
});
Route::middleware('auth')->prefix('classes/{class}')->controller(PostTestController::class)->group(function () {
    Route::get('/post-tests/create', 'create')->name('post_tests.create');
    Route::post('/post-tests', 'store')->name('post_tests.store');
    Route::get('/post-tests/{postTest}/edit', 'edit')->name('post_tests.edit');
    Route::put('/post-tests/{postTest}', 'update')->name('post_tests.update');
    Route::delete('/post-tests/{postTest}', 'destroy')->name('post_tests.destroy');
    Route::patch('/post-tests/{postTest}/toggle-status', 'toggleStatus')->name('post_tests.toggle_status');
    Route::post('/post-tests/{postTest}/duplicate', 'duplicate')->name('post_tests.duplicate');
});
Route::middleware('auth')->prefix('post-tests')->controller(PostTestController::class)->group(function () {
    Route::get('/{postTest}/request-approval', 'showRequestApprovalForm')
        ->name('post_tests.request_approval.form');
    Route::post('/{postTest}/request-approval', 'requestApproval')
        ->name('post_tests.request_approval.submit');
    Route::post('/{postTest}/approve/{attemptId}', 'approveAttempt')
        ->name('post_tests.approve_attempt');
    Route::get('/{postTest}', 'show')->name('post_tests.show');
    Route::post('/{postTest}/start', 'start')->name('post_tests.start');
    Route::post('/{postTest}/submit', 'submit')->name('post_tests.submit');
    Route::post('/{postTest}/activate', 'activate')->name('post_tests.activate');
    Route::post('/{postTest}/update-timer', 'updateTimer')->name('post_tests.updateTimer');
    Route::post('/{postTest}/save-progress', 'saveProgress')->name('post_tests.saveProgress');
});
Route::middleware('auth')->prefix('mata-pelajaran')->name('public.teacher-classes.')->controller(PublicTeacherClassController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/search', 'search')->name('search');
    Route::get('/filter', 'filterBySubject')->name('filter');
    Route::get('/{teacherClass}',  'show')->name('show');
    Route::get('/{teacherClass}/mentor/{mentor}',  'showMentorClasses')->name('mentor-classes');
});

/*
|--------------------------------------------------------------------------
| Mentor Role Routes (Role: mentor)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mentor'])->group(function () {
    Route::controller(ClassController::class)->group(function () {
        Route::get('/my-classes', 'my')->name('classes.my');
        Route::get('/create', 'create')->name('classes.create');
        Route::post('/classes', 'store')->name('classes.store.new');
        Route::get('/classes/{id}/edit', 'edit')->name('classes.edit');
        Route::put('/classes/{id}', 'update')->name('classes.update');
        Route::delete('/classes/{id}', 'destroy')->name('classes.destroy');
    });
    Route::controller(MaterialController::class)->group(function () {
        Route::get('/materials/create/{class}', 'create')->name('materials.create');
        Route::get('/materials/{material}/edit', 'edit')->name('materials.edit');
        Route::put('/materials/{material}', 'update')->name('materials.update');
        Route::delete('/materials/{material}', 'destroy')->name('materials.destroy');
        Route::post('/materials', 'store')->name('materials.store');
    });

    Route::post('/quizzes/{quiz}/activate', [QuizController::class, 'activate'])->name('quizzes.activate');

    Route::post('/mentor-requests', [MentorRequestController::class, 'store'])
        ->name('mentor-requests.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: guru)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->group(function () {
    // Teacher Class Resource
    Route::resource('teacher-classes', TeacherClassController::class);

    // Additional Teacher Class Routes
    Route::controller(TeacherClassController::class)->group(function () {
        Route::get('teacher-classes/{id}', 'implementation')->name('teacher-classes.implementation');
        Route::get('teacher-classes/{teacherClass}/implementation', 'implementation')
            ->name('teacher-classes.implementation');
    });

    // Mentor Request Management
    Route::controller(MentorRequestController::class)->group(function () {
        Route::get('/mentor-requests/pending', 'pendingRequests')
            ->name('mentor-requests.pending');
        Route::post('/mentor-requests/{mentorRequest}/approve', 'approve')
            ->name('mentor-requests.approve');
        Route::post('/mentor-requests/{mentorRequest}/reject', 'reject')
            ->name('mentor-requests.reject');
        Route::get('/mentor-requests/class/{teacherClass}', 'byClass')
            ->name('mentor-requests.by-class');
    });

    // Nested routes for teacher class management
    Route::prefix('teacher-classes/{teacherClass}')->controller(TeacherClassController::class)->group(function () {
        // Mentor Class Management
        Route::get('/classes/{class}', 'showMentorClass')
            ->name('teacher-classes.mentor-class.show');
        Route::get('/classes/{class}/edit', 'editMentorClass')
            ->name('teacher-classes.mentor-class.edit');
        Route::put('/classes/{class}', 'updateMentorClass')
            ->name('teacher-classes.mentor-class.update');
        Route::delete('/classes/{class}', 'destroyMentorClass')
            ->name('teacher-classes.mentor-class.destroy');
        Route::patch('/classes/{class}/toggle-status', 'toggleClassStatus')
            ->name('teacher-classes.mentor-class.toggle-status');

        // Material Management
        Route::get('/classes/{class}/materials/{material}', 'showMaterial')
            ->name('teacher-classes.mentor-class.material.show');
        Route::get('/classes/{class}/materials/{material}/edit', 'editMaterial')
            ->name('teacher-classes.mentor-class.material.edit');
        Route::put('/classes/{class}/materials/{material}', 'updateMaterial')
            ->name('teacher-classes.mentor-class.material.update');
        Route::delete('/classes/{class}/materials/{material}', 'destroyMaterial')
            ->name('teacher-classes.mentor-class.material.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Dummy/Placeholder Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/projects/create', function () {
        return redirect()->route('profile.index')->with('info', 'Fitur create project akan segera hadir!');
    })->name('projects.create');

    Route::get('/reports', function () {
        return redirect()->route('profile.index')->with('info', 'Fitur reports akan segera hadir!');
    })->name('reports.index');
});

// Auth routes
require __DIR__ . '/auth.php';
