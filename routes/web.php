<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;   
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

//  Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('form/{edits}', [FormController::class, 'edit'])->name('form.edit');
// Route::put('user', [FormController::class, 'update'])->name('user.update');
//home
Route::get('/', function () {
    return view('welcome');
});




//calender
Route::get('/show', [EventController::class, 'index']);
Route::get('/home', [LoginController::class, 'login']);
Route::post('/manage-event', [EventController::class, 'manageEvent']);


//login
Auth::routes();

//show data
Route::post('users.index', [UserController::class, 'index'])->name('users.index');
Route::get('showdata', [UserController::class, 'index'])->name('show');


//ajax edit, delete , update and store
Route::resource('crud', UserController::class);

// Route::group(['middleware' => ['auth']], function() {
//     Route::resource('roles', RoleController::class);
//  //ajax edit, delete , update and store
// Route::resource('crud', UserController::class);
// });


//MultiRole staff
Route::middleware(['user-role:staff'])->group(function()
{
    Route::get("staff/home",[HomeController::class,'staffHome'])->name('home.staff');
});

//MultiRole student
Route::middleware(['user-role:student'])->group(function()
{
    Route::get("/student/home",[HomeController::class,'studentHome'])->name('home.student');
});

//MultiRole admin
Route::middleware(['user-role:Admin'])->group(function()
{
    Route::get("/admin/home",[HomeController::class,'adminHome'])->name('home.admin');
});

