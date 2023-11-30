<?php

use App\Http\Controllers\Controller;
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

Route::get('/', [Controller::class, 'index'])->name('index');
Route::post('/messages/send', [Controller::class, 'sendMessage'])->name('send_message');
Route::get('/messages/all', [Controller::class, 'getAllMessages'])->name('get_all_messages');
Route::get('/server/sent/event', [Controller::class, 'serverSentEvent'])->name('server_sent_event');