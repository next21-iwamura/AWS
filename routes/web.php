<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 売り上げ分析用
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

// 新規アップツール用
    Route::get('/op_create_new','App\Http\Controllers\OpCreateNewsController@op_create_new_view');
    Route::POST('/op_create_new','App\Http\Controllers\OpCreateNewsController@btn_select');
    Route::get('/op_create_new_test','App\Http\Controllers\OpCreateNew_testsController@op_create_new_view');
    Route::POST('/op_create_new_test','App\Http\Controllers\OpCreateNew_testsController@btn_select');

// 関連商品出力用
    Route::get('/connection_search','App\Http\Controllers\Connection_searchController@connection_search_view');
    Route::POST('/connection_search','App\Http\Controllers\Connection_searchController@btn_select');
    Route::get('/connection_test_search','App\Http\Controllers\Connection_test_searchController@connection_search_view');
    Route::POST('/connection_test_search','App\Http\Controllers\Connection_test_searchController@btn_select');

// 買取ページ表示用
    Route::get('/kaitori','App\Http\Controllers\KaitorisController@kaitoriview');
    Route::get('/kaitori_test','App\Http\Controllers\Kaitori_testsController@kaitoriview');
// 買取ページHTML作成用
    Route::POST('/kaitori','App\Http\Controllers\KaitorisController@btn_select');
    Route::POST('/kaitori_test','App\Http\Controllers\Kaitori_testsController@btn_select');
    