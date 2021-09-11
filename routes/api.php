<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->group(function(){
   
});

Route::post('/register',[AdminController::class,'register']);
Route::post('/login',[AdminController::class,'login']);

Route::get('/brandall',[BrandController::class,'index']);
Route::post('/brandstore',[BrandController::class,'store']);
Route::get('/brandedit/{id}',[BrandController::class,'edit']);
Route::post('/brandupdate/{id}',[BrandController::class,'update']);
Route::post('/branddelete/{id}',[BrandController::class,'destroy']);

// Route::get('/getadmin',[AdminController::class,'getAdmin']);

Route::middleware(['auth:api-admin'])->group(function(){
    Route::get('/getadmin',[AdminController::class,'getAdmin']);
    Route::post('/logout',[AdminController::class,'logout']);
});