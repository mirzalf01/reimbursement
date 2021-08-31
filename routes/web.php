<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReimburseController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'], function(){
    /* Reimbursement Actions */
    Route::group(['prefix'=>'reimbursements'], function(){
        Route::get('/', [ReimburseController::class, 'index'])->name('reimbursements.index');
        Route::get('/create', [ReimburseController::class, 'create'])->name('reimbursements.create');
        Route::post('/store', [ReimburseController::class, 'store'])->name('reimbursements.store');
    });
});

