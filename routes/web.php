<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\MainClassController;
use App\Http\Controllers\backend\SubClassController;


Route::get('/', function () {
        return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => ['user.role']], function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::prefix('admin/dashboard')->name('admin.')->controller(DashboardController::class)->group(function () {
                Route::get('/', 'dashboard')->name('dashboard');
        });
        Route::prefix('admin/dashboard/class')->name('class.')->controller(MainClassController::class)->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
                Route::get('/toggleStatus/{id}', 'toggleStatus')->name('toggleStatus');
        });
        Route::prefix('admin/dashboard/subclass')->name('subclass.')->controller(SubClassController::class)->group(function () {
                Route::get('/index', 'index')->name('index');
                Route::post('/list', 'list')->name('list');
                Route::get('/create', 'create')->name('create');
                Route::get('/filter', 'filter')->name('filter');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
                Route::get('/toggleStatus/{id}', 'toggleStatus')->name('toggleStatus');
        });
});


Route::prefix('admin')->name('admin.')->controller(AuthController::class)->group(function () {
        Route::get('login/', 'loginPage')->name('login');
        Route::post('user/login', 'login')->name('login.user');
        Route::get('user/logout', 'logout')->name('logout.user');
});
