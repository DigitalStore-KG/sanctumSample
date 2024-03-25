<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BaseApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/',[BaseApiController::class,'index']);
Route::post('/user/store',[BaseApiController::class,'store']);
Route::get('/user/details/{id}',[BaseApiController::class,'show']);
Route::put('/user/update/{id}',[BaseApiController::class,'update']);
Route::delete('/user/delete/{id}',[BaseApiController::class,'destroy']);
