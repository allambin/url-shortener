<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:shortening'])->group(function () {
    Route::post('/encode', [UrlController::class, 'encode']);
});

Route::controller(UrlController::class)->group(function () {
    Route::get('/urls', 'showAll');
    Route::post('/decode', 'decode');
    Route::get('/{alias}', 'redirect');
});
