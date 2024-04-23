<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/analysis','App\Http\Controllers\AnalysisController@analysis_view');
Route::POST('/analysis','App\Http\Controllers\AnalysisController@btn_select');

Route::get('/analysis_search','Analysis_searchController@analysis_view');
Route::POST('/analysis_search','Analysis_searchController@btn_select');
Route::get('/analysis_test_search','Analysis_test_searchController@analysis_view');
Route::POST('/analysis_test_search','Analysis_test_searchController@btn_select');
Route::get('/analysis2_search','Analysis2_searchController@analysis2_view');
Route::POST('/analysis2_search','Analysis2_searchController@btn_select');
Route::get('/analysis2_test_search','Analysis2_test_searchController@analysis2_view');
Route::POST('/analysis2_test_search','Analysis2_test_searchController@btn_select');
