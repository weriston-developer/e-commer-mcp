<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/chat', [\App\Http\Controllers\ChatController::class, 'chat']);

Route::get('/healthCheck', function (Request $request) {
    return response()->json(['status' => 'ok']);
});
