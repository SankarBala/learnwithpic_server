<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\TagController;
use App\Models\Post;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('/category', CategoryController::class)->scoped(['category' => 'slug']);
Route::apiResource('/tag', TagController::class)->scoped(['tag' => 'slug']);

// Post related routes
Route::post('/post/execute', [PostController::class, 'execute'])->name('post.action');
Route::get('/post/months', [PostController::class, 'created_months'])->name('post.months');
Route::apiResource('/post', PostController::class)->scoped(['post' => 'slug']);

// Step related routes
Route::apiResource('/step', StepController::class)->scoped(['step' => 'slug']);

Route::post('/file-manager/ckeditor/upload', [FileController::class, 'saveCKEditorImage']);


