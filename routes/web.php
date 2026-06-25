<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\TaskPageController;
use App\Http\Controllers\CompletionPageController;
use App\Http\Controllers\PeriodPageController;
use App\Http\Controllers\DashboardPageController;



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/dashboard', function () {
//     if (!session()->has('api_token')) {
//         return redirect('/login');
//     }

//     $user = session('user');
//     return view('dashboard', compact('user'));
// });



Route::get('/profile', [ProfilePageController::class, 'index'])->name('profile');
Route::put('/profile/update', [ProfilePageController::class, 'update'])->name('profile.update');
Route::get('/profile/edit', [ProfilePageController::class, 'edit'])->name('profile.edit');


Route::get('/', function () {
    return view('welcome');
});



// USER MANAGEMENT ROUTES
Route::get('/users', [UsersManagementController::class, 'index'])->name('users.list');
Route::get('/users/create', [UsersManagementController::class, 'create'])->name('users.create');
Route::post('/users', [UsersManagementController::class, 'store'])->name('users.store');
Route::delete('/users/{id}', [UsersManagementController::class, 'destroyUser'])->name('users.delete');
Route::get('/users/{id}/edit', [UsersManagementController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');


// TASK MANAGEMENT ROUTES

Route::get('/tasks', [TaskPageController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskPageController::class, 'create'])->name('tasks.create');
Route::post('/tasks/store', [TaskPageController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}/edit', [TaskPageController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TaskPageController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskPageController::class, 'destroy'])->name('tasks.destroy');


// COMPLETION MANAGEMENT ROUTES

// Route::resource('completions', CompletionsPageController::class);

Route::prefix('completions')->name('completions.')->group(function () {
    Route::get('/', [CompletionPageController::class, 'index'])->name('index');
    Route::get('/create', [CompletionPageController::class, 'create'])->name('create');
    Route::post('/', [CompletionPageController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CompletionPageController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CompletionPageController::class, 'update'])->name('update');
    Route::delete('/{id}', [CompletionPageController::class, 'destroy'])->name('destroy');

});


// PERIOD MANAGEMENT ROUTES
Route::get('/periods', [PeriodPageController::class, 'index'])->name('Periods.index');
Route::get('/periods/create', [PeriodPageController::class, 'create'])->name('periods.create');
Route::post('/periods', [PeriodPageController::class, 'store'])->name('periods.store');
Route::get('/periods/{id}/edit', [PeriodPageController::class, 'edit'])->name('periods.edit');
Route::put('/periods/{id}', [PeriodPageController::class, 'update'])->name('periods.update');
Route::delete('/periods/{id}', [PeriodPageController::class, 'destroy'])->name('periods.destroy');
Route::post('/periods/{id}/set-active', [App\Http\Controllers\PeriodPageController::class, 'setActive'])
    ->name('periods.setActive');


Route::get('/dashboard', [DashboardPageController::class, 'index'])->name('dashboard');
