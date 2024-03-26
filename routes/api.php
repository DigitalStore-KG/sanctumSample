<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Controllers\API\PasswordResetController;

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
Route::post('/user/login',[BaseApiController::class,'login']);
Route::post('/user/passwordResetEmail',[PasswordResetController::class,'passwordResetSendMail']);
Route::post('/user/passwordReset/{token}',[PasswordResetController::class,'passwordReset']);

Route::prefix('/user')->middleware(['auth:sanctum'])->group(function(){
    Route::get('/details/{id}',[BaseApiController::class,'show']);
    Route::put('/update/{id}',[BaseApiController::class,'update']);
    Route::delete('/delete/{id}',[BaseApiController::class,'destroy']);
    Route::post('/logout',[BaseApiController::class,'logout']);
    Route::get('/loggedUser',[BaseApiController::class,'loggedUser']);
    Route::post('/changePassword',[BaseApiController::class,'changePassword']);
});