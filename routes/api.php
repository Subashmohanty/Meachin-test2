<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\BlogsController;
use App\Http\Controllers\Api\CommentsController;
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

Route::post('register', [UsersController::class, 'register']);
Route::post('login', [UsersController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('create-blogs', [BlogsController::class, 'createBlogs']);
    Route::post('update-blogs', [BlogsController::class, 'updateBlogs']);
    Route::post('delete-blogs', [BlogsController::class, 'deleteBlogs']);
    Route::post('show-blogs', [BlogsController::class, 'showBlogs']);
    Route::post('create-comment', [CommentsController::class, 'createComment']);
    Route::post('show-blog-comment', [BlogsController::class, 'showBlogcomments']);
    Route::post('change-role', [UsersController::class, 'changeRole']);
});