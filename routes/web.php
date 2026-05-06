<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'head' => redirect()->route('head.dashboard'),
        default => redirect()->route('staff.dashboard'),
    };
})->name('dashboard');


// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// HEAD MODULE

Route::middleware(['auth', 'role:head'])->group(function () {

    Route::get('/head/dashboard', [HeadController::class, 'dashboard'])->name('head.dashboard');

    Route::get('/head/tasks', [HeadController::class, 'tasks'])->name('head.tasks');
    Route::post('/head/tasks', [HeadController::class, 'store'])->name('head.tasks.store');
    Route::put('/head/tasks/{id}', [HeadController::class, 'update'])->name('head.tasks.update');
    Route::delete('/head/tasks/{id}', [HeadController::class, 'destroy'])->name('head.tasks.destroy');

    // Additional head module pages
    Route::get('/head/schedule', [HeadController::class, 'schedule'])->name('head.schedule');
    Route::get('/head/team', [HeadController::class, 'team'])->name('head.team');
    Route::get('/head/issues', [HeadController::class, 'issues'])->name('head.issues');
    Route::post('/head/issues', [HeadController::class, 'storeIssue'])->name('head.issues.store');
    Route::put('/head/issues/{id}', [HeadController::class, 'updateIssue'])->name('head.issues.update');
    Route::delete('/head/issues/{id}', [HeadController::class, 'destroyIssue'])->name('head.issues.destroy');
    Route::get('/head/reports', [HeadController::class, 'reports'])->name('head.reports');
});

Route::middleware(['auth', 'role:admin,head'])->get('/task-assignees', function () {
    return response()->json([
        'housekeepers' => User::where('role', 'housekeeper')->orderBy('name')->get(['id', 'name']),
    ]);
})->name('task.assignees');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/rooms', [AdminController::class, 'rooms'])->name('rooms');
    Route::post('/rooms', [AdminController::class, 'storeRoom'])->name('rooms.store');
    Route::put('/rooms/{room}', [AdminController::class, 'updateRoom'])->name('rooms.update');
    Route::delete('/rooms/{room}', [AdminController::class, 'destroyRoom'])->name('rooms.destroy');

    Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
    Route::post('/tasks', [AdminController::class, 'storeTask'])->name('tasks.store');
    Route::put('/tasks/{task}', [AdminController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [AdminController::class, 'destroyTask'])->name('tasks.destroy');

    Route::get('/teams', [AdminController::class, 'teams'])->name('teams');
    Route::post('/teams', [AdminController::class, 'storeTeamMember'])->name('teams.store');
    Route::put('/teams/{user}', [AdminController::class, 'updateTeamMember'])->name('teams.update');
    Route::delete('/teams/{user}', [AdminController::class, 'destroyTeamMember'])->name('teams.destroy');

    Route::get('/issues', [AdminController::class, 'issues'])->name('issues');
    Route::post('/issues', [AdminController::class, 'storeIssue'])->name('issues.store');
    Route::put('/issues/{issue}', [AdminController::class, 'updateIssue'])->name('issues.update');
    Route::delete('/issues/{issue}', [AdminController::class, 'destroyIssue'])->name('issues.destroy');

    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [AdminController::class, 'exportReport'])->name('reports.export');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});

// STAFF MODULE

Route::middleware(['auth', 'role:housekeeper'])->group(function () {

    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');

    Route::get('/staff/tasks', [TaskController::class, 'index'])->name('staff.tasks');

    Route::get('/staff/tasks/{id}', [TaskController::class, 'show'])->name('staff.tasks.show');

        Route::post('/staff/tasks/{id}/update', [TaskController::class, 'updateStatus'])
        ->name('staff.tasks.update');

    Route::get('/staff/issues/create', [IssueController::class, 'create'])->name('staff.issues.create');
    Route::post('/staff/issues/store', [IssueController::class, 'store'])->name('staff.issues.store');

    Route::get('/staff/notifications', [NotificationController::class, 'index'])->name('staff.notifications');
});

require __DIR__.'/auth.php';