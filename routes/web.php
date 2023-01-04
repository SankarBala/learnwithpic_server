<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

Route::get('login', function () {
    Auth::login(User::find(1));
})->name('login');



Route::get('/file-manager', function () {
    return view("admin.filemanager");
});



// Route::post('file-manager/ckeditor/upload', function (Request $request) {
//     return response()->json([
//         "uploaded" => 1,
//         "fileName" => "ddddd.png",
//         "url" => "http://localhost:8000/storage/sujon.jpg"
//     ]);
// });


// Route::get('file-manager/ckeditor/select', function (Request $request) {
//     return "http://localhost:8000/storage/sujon.jpg";
//     return response()->json([
//         "uploaded" => 1,
//         "fileName" => "ddddd.png",
//         "url" => "http://localhost:8000/storage/sujon.jpg"
//     ]);
// });
