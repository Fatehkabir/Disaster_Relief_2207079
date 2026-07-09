<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReliefRequestController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['post', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
    Route::resource('incidents', IncidentController::class)->only(['index', 'create', 'store', 'show']);

    Route::get('/requests', [ReliefRequestController::class, 'myRequests'])->name('requests.my');
    Route::resource('requests', ReliefRequestController::class)->only(['create', 'store', 'show']);

    Route::get('/donations/my', [DonationController::class, 'myDonations'])->name('donations.my');
    Route::resource('donations', DonationController::class)->only(['index', 'create', 'store', 'show']);

    Route::get('/volunteers/tasks', [VolunteerController::class, 'tasks'])->name('volunteers.tasks');
    Route::get('/volunteers/my-tasks', [VolunteerController::class, 'myTasks'])->name('volunteers.my-tasks');
    Route::get('/volunteers/task/{task}', [VolunteerController::class, 'showTask'])->name('volunteers.task');
    Route::post('/volunteers/task/{task}/apply', [VolunteerController::class, 'applyTask'])->name('volunteers.apply');
    Route::post('/volunteers/task/{task}/withdraw', [VolunteerController::class, 'withdrawTask'])->name('volunteers.withdraw');

    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('index');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
        Route::get('/incidents', [AdminController::class, 'incidents'])->name('incidents');
        Route::patch('/incidents/{incident}/status', [AdminController::class, 'updateIncidentStatus'])->name('incidents.status');
        Route::get('/requests', [AdminController::class, 'requests'])->name('requests');
        Route::patch('/requests/{reliefRequest}/status', [AdminController::class, 'updateRequestStatus'])->name('requests.status');
        Route::get('/donations', [AdminController::class, 'donations'])->name('donations');
        Route::patch('/donations/{donation}/status', [AdminController::class, 'updateDonationStatus'])->name('donations.status');
        Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
        Route::get('/tasks/create', [AdminController::class, 'createTask'])->name('tasks.create');
        Route::post('/tasks', [AdminController::class, 'storeTask'])->name('tasks.store');
        Route::patch('/tasks/{task}/status', [AdminController::class, 'updateTaskStatus'])->name('tasks.status');
    });
});

require __DIR__.'/auth.php';
