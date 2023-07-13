<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('/user/{id}',[\App\Http\Controllers\User::class,'info']);
Route::get('/user/{id}/projects',[\App\Http\Controllers\Projects::class,'info']);
Route::get('/projects/{id}',[\App\Http\Controllers\Projects::class,'getProject']);
Route::get('/projects/{id}/simple-tasks-list',[\App\Http\Controllers\Projects::class,'tasksList']);
Route::post('/projects',[\App\Http\Controllers\Projects::class,'validate']);
