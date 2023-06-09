<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/user-login',[UserController::class, 'userlogin']);
Route::post('/logout',[UserController::class, 'userlogout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'getUser']);
    Route::post('/create-user', [UserController::class, 'createUser']);
    Route::post('/update-user', [UserController::class, 'updateUser']);
    Route::get('/delete-user/{id}', [UserController::class, 'deleteUser']);
    Route::get('/user-data/{id}', [UserController::class, 'uniquedata']);

    Route::post('/blogs', [BlogController::class, 'getBlogs']);
    Route::post('/create-blog', [BlogController::class, 'createBlog']);
    Route::post('/update-blog', [BlogController::class, 'updateBlog']);

});
