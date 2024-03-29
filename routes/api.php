<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\TagController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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


Route::middleware('visitor')->group(function () {

    Route::apiResource('/category', CategoryController::class)->scoped(['category' => 'slug']);
    Route::get('just-categories', [CategoryController::class, 'just_categories'])->name('just-categories');


    Route::apiResource('/tag', TagController::class)->scoped(['tag' => 'slug']);
    Route::get('just-tags', [TagController::class, 'just_tags'])->name('just-tags');

    // Post related routes
    Route::post('/post/execute', [PostController::class, 'execute'])->name('post.action');
    Route::get('/post/months', [PostController::class, 'created_months'])->name('post.months');
    Route::apiResource('/post', PostController::class)->scoped(['post' => 'slug']);

    // Step related routes
    Route::apiResource('/step', StepController::class)->scoped(['step' => 'slug']);

    Route::post('/file-manager/ckeditor/upload', [FileController::class, 'saveCKEditorImage']);

});

// Dashboard resources/statistics api 
Route::prefix('statistic')->group(function () {
    Route::get('post', [DashboardController::class, 'posts']);
    Route::get('user', [DashboardController::class, 'users']);
    Route::get('visitor', [DashboardController::class, 'visitors']);
    Route::get('traffic_chart', [DashboardController::class, 'traffic_chart']);
});

Route::get('rnp', function () {
    $user = User::find(6);
    $user->assignRole(['visitor']);
    
    
    return  $user;
});
