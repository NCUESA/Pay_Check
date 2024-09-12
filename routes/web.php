<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', ['js_name' => 'index']);
});
Route::get('/checklist', function () {
    return view('checklist', ['js_name' => 'checklist']);
});

Route::get('/person', function () {
    return view('person', ['js_name' => 'person']);
});

// Person
Route::post('/add-user', [PersonController::class, 'addUser']);
Route::post('/show-user', [PersonController::class, 'showUserFull']);

// CheckList
Route::post('/check', [JobController::class, 'checkInOrOut']);
Route::post('/show-list', [JobController::class, 'showList']);
Route::post('/update-list', [JobController::class, 'manualUpdateList']);