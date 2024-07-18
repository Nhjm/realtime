<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('authentication')->group(function () {
    Route::get('chat', [ChatController::class, 'index'])->name('chat');
    Route::post('send_message', [ChatController::class, 'send_message'])->name('send_message');

    Route::get('chat_private/{user}', [ChatController::class, 'chat_private'])->name('chat_private');
    Route::post('send_private_message/{id}', [ChatController::class, 'send_private_message'])->name('send_private_message');

    Route::prefix('users')
        ->as('users.')
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('store', [UserController::class, 'store'])->name('store');
            Route::post('edit', [UserController::class, 'edit'])->name('edit');
            Route::post('destroy', [UserController::class, 'destroy'])->name('destroy');
            Route::post('update', [UserController::class, 'update'])->name('update');
        });

    Route::post('create_group_chat', [ChatController::class, 'create_group_chat'])->name('create_group_chat');
    Route::get('chat_group/{id}', [ChatController::class, 'chat_group'])->name('chat_group');
    Route::post('send_message_group', [ChatController::class, 'send_message_group'])->name('send_message_group');

});


