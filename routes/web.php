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
    
    
// オペレーションページ表示(変更依頼)用
    Route::get('/operation','App\Http\Controllers\OperationsController@operationview');
    Route::get('/operation_test','App\Http\Controllers\Operation_testsController@operationview');
// オペレーション(変更依頼)用
    Route::POST('/operation','App\Http\Controllers\OperationsController@btn_select');
    Route::POST('/operation_test','App\Http\Controllers\Operation_testsController@btn_select');

// 社員名表示にサジェスト機能を持たせる為の非同期通信用
    Route::get('/operation', 'App\Http\Controllers\HomeController@select2_ajax');
    Route::get('/operation_test', 'App\Http\Controllers\HomeController@select2_ajax_test');
    Route::get('/operation_status', 'App\Http\Controllers\HomeController@select2_ajax2');
    Route::get('/operation_test_status', 'App\Http\Controllers\HomeController@select2_ajax2_test');
    Route::get('/ajax/user', 'App\Http\Controllers\Ajax\Stuff_nameController@index');

// オペレーションページ表示(変更作業)用
    Route::get('/operation_work','App\Http\Controllers\Operation_worksController@operation_work_view');
    Route::get('/operation_work_test','App\Http\Controllers\Operation_work_testsController@operation_work_view');
// オペレーション(変更作業)用
    Route::POST('/operation_work','App\Http\Controllers\Operation_worksController@btn_select');
    Route::POST('/operation_work_test','App\Http\Controllers\Operation_work_testsController@btn_select');
// スタッフ名編集用
    Route::get('/edit_stuffname','App\Http\Controllers\Edit_stuffnamesController@edit_stuffname_view');
    Route::POST('/edit_stuffname','App\Http\Controllers\Edit_stuffnamesController@btn_select');
// NCスタッフ名編集用
    Route::get('/edit_nc_stuffname','App\Http\Controllers\Edit_nc_stuffnamesController@edit_stuffname_view');
    Route::POST('/edit_nc_stuffname','App\Http\Controllers\Edit_nc_stuffnamesController@btn_select');
// オペレーションページ表示(ステータス確認)用
    Route::get('/operation_status','App\Http\Controllers\Operation_statusesController@operation_status_view');
    Route::get('/operation_status_test','App\Http\Controllers\Operation_status_testsController@operation_status_view');
// オペレーションページ表示(ステータス確認)用
	Route::POST('/operation_status','App\Http\Controllers\Operation_statusesController@btn_select');
	Route::POST('/operation_status_test','App\Http\Controllers\Operation_status_testsController@btn_select');
