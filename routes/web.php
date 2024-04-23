<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/analysis','App\Http\Controllers\AnalysisController@analysis_view');
Route::POST('/analysis','App\Http\Controllers\AnalysisController@btn_select');
