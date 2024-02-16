<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UpsertController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
 
  Route::middleware(['auth:sanctum'])-> group(function () {
        Route::get('show', [UpsertController::class, 'show']);
        Route::get('students', [UpsertController::class, 'index']);
        Route::get('getUserCode', [UpsertController::class, 'show']);
        Route::get('edit-student/{id}', [UpsertController::class, 'edit']);
        Route::put('update', [UpsertController::class, 'update']);
        Route::post('addnew', [UpsertController::class, 'store']); 
        Route::delete('/api/delete/{id}', [UpsertController::class, 'destroy']);
        Route::post('/api/saveData', [UpsertController::class, 'save']);
        Route::post('logout', [AuthController::class, 'logout']);
      });


     
    

   

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
