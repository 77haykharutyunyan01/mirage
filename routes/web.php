<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Company\CreateCompanyController;
use App\Http\Controllers\Company\GetCompanyController;
use App\Http\Controllers\Company\UpdateCompanyController;
use App\Http\Controllers\TaskCreateController;
use App\Http\Controllers\User\CreateUserInCompanyController;
use App\Http\Controllers\User\GetUsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    if (request()->user()?->roles->first()->name === 'root') {
        return redirect('/admin/companies');
    }

    return redirect('dash/user');
});

Route::prefix('login')->group(function () {
    Route::get('', function () {
        return view('Login');
    });
    Route::post('', LoginController::class)->name('login');
});

Route::middleware('auth')->get('/logout', function () {
    Auth::logout();

    return view('Login');
})->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::prefix('user')->group(function () {
        Route::get('', GetUsersController::class)->name('get_user');
        Route::post('/', CreateUserInCompanyController::class)->name('create_user_in_company');
        Route::get('/create', function () {
            return view('User/CreateUser', ['owner' => request()->user()]);
        })->name('create_user_view');
    });

    Route::prefix('companies')->group(function () {
        Route::post('/', CreateCompanyController::class)->name('create_company');
        Route::get('/', GetCompanyController::class)->name('get_company');
        Route::put('/', UpdateCompanyController::class)->name('update_company');
        Route::get('/create', function () {
            return view('Company/CreateCompany', ['owner' => request()->user()]);
        })->name('create_company_view');
    });
});

Route::post('task', TaskCreateController::class)->name('task_create');
