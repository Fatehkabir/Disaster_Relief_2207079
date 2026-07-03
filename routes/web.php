<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ReliefRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'create'])->name('login');
    Route::post('/login',   [LoginController::class,    'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register',[RegisterController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',  [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/incidents',        [IncidentController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents',       [IncidentController::class, 'store'])->name('incidents.store');
    Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incidents.show')->whereNumber('incident');
    Route::get('/requests/create',  [ReliefRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests',        [ReliefRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/my',      [ReliefRequestController::class, 'myRequests'])->name('requests.my');
    Route::get('/requests/{reliefRequest}', [ReliefRequestController::class, 'show'])->name('requests.show')->whereNumber('reliefRequest');
    Route::get('/donations',        [DonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations',       [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/my',     [DonationController::class, 'myDonations'])->name('donations.my');
    Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('donations.show')->whereNumber('donation');
    Route::get('/volunteer-tasks',   [VolunteerController::class, 'tasks'])->name('volunteers.tasks');
    Route::get('/my-tasks',          [VolunteerController::class, 'myTasks'])->name('volunteers.my-tasks');
    Route::get('/volunteer-tasks/{task}',         [VolunteerController::class, 'showTask'])->name('volunteers.task')->whereNumber('task');
    Route::post('/volunteer-tasks/{task}/apply',  [VolunteerController::class, 'applyTask'])->name('volunteers.apply');
    Route::post('/volunteer-tasks/{task}/withdraw',[VolunteerController::class, 'withdrawTask'])->name('volunteers.withdraw');
    
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/',         [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users',    [AdminController::class, 'users'])->name('users');
        Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
        Route::get('/incidents', [AdminController::class, 'incidents'])->name('incidents');
        Route::patch('/incidents/{incident}/status', [AdminController::class, 'updateIncidentStatus'])->name('incidents.status');
        Route::get('/requests',  [AdminController::class, 'requests'])->name('requests');
        Route::patch('/requests/{reliefRequest}/status', [AdminController::class, 'updateRequestStatus'])->name('requests.status');
        Route::get('/donations', [AdminController::class, 'donations'])->name('donations');
        Route::patch('/donations/{donation}/status', [AdminController::class, 'updateDonationStatus'])->name('donations.status');
        Route::get('/tasks',         [AdminController::class, 'tasks'])->name('tasks');
        Route::get('/tasks/create',  [AdminController::class, 'createTask'])->name('tasks.create');
        Route::post('/tasks',        [AdminController::class, 'storeTask'])->name('tasks.store');
        Route::patch('/tasks/{task}/status', [AdminController::class, 'updateTaskStatus'])->name('tasks.status');
    });
});
