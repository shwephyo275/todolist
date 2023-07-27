<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('create');
// });

// Route::get('testing', function(){
//     return "this is the testing...";
// })->name('test');


// Route::redirect($uri, $destination, $status = 302)
Route::redirect('/', 'customer/createPage')->name('post#home');

// Route::get('/', [PostController::class, 'create'])->name('post#home');

Route::get('customer/createPage', [PostController::class, 'create'])->name('post#createPage');

Route::post('post/create', [PostController::class, 'postCreate'])->name('post#create');

//Delete Datas
Route::get('post/delete/{id}', [PostController::class, 'postDelete'])->name('post#delete');
// Route::delete('post/delete/{id}', [PostController::class, 'postDelete'])->name('post#delete');

//post update show
Route::get('post/updatePage/{id}', [PostController::class, 'updatePage'])->name('post#updatePage');

//post edit
Route::get('post/editPage/{id}', [PostController::class, 'editPage'])->name('post#editPage');

Route::post('post/update', [PostController::class, 'update'])->name('post#update');
