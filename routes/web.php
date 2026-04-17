<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\MainClassController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});


Route::prefix('admin')->name('admin.')->controller(AuthController::class)->group(function () {
        Route::get('login/', 'loginPage')->name('login');
        Route::post('user/login', 'login')->name('login.user');
        Route::get('user/logout', 'logout')->name('logout.user');

});
Route::prefix('admin/dashboard')->name('admin.')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'dashboard')->name('dashboard');
});
Route::prefix('admin/dashboard/class')->name('class.')->controller(MainClassController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/toggleStatus/{id}', 'toggleStatus')->name('toggleStatus');
});