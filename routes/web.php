<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/analysis','App\Http\Controllers\AnalysisController@analysis_view');
Route::POST('/analysis','App\Http\Controllers\AnalysisController@btn_select');

Route::get('/analysis_search','App\Http\Controllers\Analysis_searchController@analysis_search_view');
Route::POST('/analysis_search','App\Http\Controllers\Analysis_searchController@btn_select');
Route::get('/analysis_test_search','App\Http\Controllers\Analysis_test_searchController@analysis_search_view');
Route::POST('/analysis_test_search','App\Http\Controllers\Analysis_test_searchController@btn_select');
Route::get('/analysis2_search','App\Http\Controllers\Analysis2_searchController@analysis2_search_view');
Route::POST('/analysis2_search','App\Http\Controllers\Analysis2_searchController@btn_select');
Route::get('/analysis2_test_search','App\Http\Controllers\Analysis2_test_searchController@analysis2_search_view');
Route::POST('/analysis2_test_search','App\Http\Controllers\Analysis2_test_searchController@btn_select');

