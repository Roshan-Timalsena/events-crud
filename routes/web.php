<?php

use App\Http\Controllers\EventController;
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

Route::get('/', [EventController::class, 'showForm']);

Route::post('/add',[EventController::class, 'addEvent'])->name('addEvent');
Route::get('/show', [EventController::class, 'showEvents']);

Route::get('/show/finished', [EventController::class, 'showFinished']);
Route::get('/show/upcoming',[EventController::class, 'showUpcoming']);

Route::get('show/upcoming-within-seven',[EventController::class, 'showUpcomingSeven']);
Route::get('/show/finished-before-seven',[EventController::class, 'showFinishedBeforeSeven']);

Route::get('/delete/{id}',[EventController::class,'deleteEvent']);
