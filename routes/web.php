<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeInfoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[EmployeeInfoController::class,'index'])->name('post.employee-list');

Route::group(['middleware' => ['XSS']], function () {
    Route::get('/add-employee',[EmployeeInfoController::class,'create'])->name('post.add-employee');
    Route::post('/add-employee',[EmployeeInfoController::class,'store'])->name('post.add-employee');
    Route::get('/edit-employee/{id}',[EmployeeInfoController::class,'edit'])->name('post.edit-employee');
    Route::post('/edit-employee/{id}',[EmployeeInfoController::class,'update'])->name('post.edit-employee');
});
Route::get('/delete-employee/{id}',[EmployeeInfoController::class,'destroy'])->name('post.delete-employee');


Route::post('/check-email',[EmployeeInfoController::class,'checkEmail'])->name('post.check-email');
Route::post('/employee-search',[EmployeeInfoController::class,'employeeSearch'])->name('post.employee-search');
Route::get('/employee-record',[EmployeeInfoController::class,'employeeRecord'])->name('post.employee-record');
