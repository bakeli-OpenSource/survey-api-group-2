<?php

use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\SondageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get("/users", [Usercontroller::class,'getUsers']);
Route::get("/users/{id}", [Usercontroller::class,'getUser']);
Route::post("/users/register",[Usercontroller::class,'register']);
Route::post("/users/login",[Usercontroller::class,'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/all/sondages', [SondageController::class, 'index']);
Route::get('/sondages/{id}', [SondageController::class, 'show']);
Route::post('/sondages', [SondageController::class, 'store']);
Route::put('/update/sondages/{id}', [SondageController::class, 'update']);
Route::delete('/delete/sondages/{id}', [SondageController::class, 'destroy']);
