<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 売上・在庫・回転率分析ツール
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

// 新規アップツール
Route::get('/op_create_new','App\Http\Controllers\OpCreateNewsController@op_create_new_view');
Route::POST('/op_create_new','App\Http\Controllers\OpCreateNewsController@btn_select');
Route::get('/op_create_new_test','App\Http\Controllers\OpCreateNew_testsController@op_create_new_view');
Route::POST('/op_create_new_test','App\Http\Controllers\OpCreateNew_testsController@btn_select');

