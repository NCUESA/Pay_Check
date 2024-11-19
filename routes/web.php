<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\IPController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', ['js_name' => 'index']);
});
Route::middleware(['ipAuth'])->group(function () {
    Route::get('/checklist', function () {
        return view('checklist', ['js_name' => 'checklist']);
    });
    
    Route::get('/person', function () {
        return view('person', ['js_name' => 'person']);
    });

    Route::get('/ip', function () {
        return view('ip', ['js_name' => 'ip']);
    });
});


// Person
Route::prefix('user')->group(function () {
    Route::post('/add', [PersonController::class, 'addUser']);
    Route::post('/show', [PersonController::class, 'showUserFull']);
    Route::post('/check', [PersonController::class, 'checked']);
});

// CheckList
Route::group([],function(){
    Route::post('/check', [JobController::class, 'checkInOrOut']);
    Route::post('/show-list', [JobController::class, 'showList']);
    Route::post('/show-list-condition', [JobController::class, 'showListCondition']);
    Route::post('/update-list', [JobController::class, 'manualUpdateList']);
    Route::post('/gen-month-table',[JobController::class,'genMonthTable']);
});

// IP
Route::group([],function(){
    Route::post('/show-ip', [IPController::class, 'showIP']);
    Route::post('/add-ip', [IPController::class, 'addIP']);
    Route::post('/delete-ip',[IPController::class,'deleteIP']); 
});

Route::get('/refresh-csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});





