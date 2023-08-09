<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\SexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sex', [SexController::class, 'list']);

Route::post(    'person',       [PersonController::class, 'store']);
Route::put(     'person/{id}',  [PersonController::class, 'update']);
Route::get(     'person',       [PersonController::class, 'list']);
Route::get(     'person/{id}',  [PersonController::class, 'get']);
Route::delete(  'person/{id}',  [PersonController::class, 'delete']);
