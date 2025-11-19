<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskConfirmController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('draft')->group(function(){
    //新規登録機能用
    Route::post('/create', [TaskConfirmController::class, 'storeCreate']);
    Route::get('/create', [TaskConfirmController::class, 'showCreate']);
    Route::post('/create/clear', [TaskConfirmController::class, 'clearCreate']);
    
    //登録内容編集機能用
    Route::post('/edit', [TaskConfirmController::class, 'storeEdit']);
    Route::get('/edit', [TaskConfirmController::class, 'showEdit']);
    Route::post('/edit/clear', [TaskConfirmController::class, 'clearEdit']);

});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');