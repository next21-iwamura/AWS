<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//use app\Http\Controllers\TestController;

//Route::get('/test/', 'TestController@test' );
//Route::get('/test', [\app\Http\Controllers\TestController::class, 'index']);

Route::get('/test', 'App\Http\Controllers\TestController@index');
//Route::POST('/test/', 'TestController@btn_select' );


// オペレーション(新規UP)用
//Route::get('/op_create_new_test','App\Http\Controllers\OpCreateNew_testsController@op_create_new_view');
//Route::POST('/op_create_new_test','App\Http\Controllers\OpCreateNew_testsController@btn_select');
Route::get('/op_create_new_test','App\Http\Controllers\OpCreateNew_testsController@op_create_new_view');
Route::POST('/op_create_new_test','App\Http\Controllers\OpCreateNew_testsController@btn_select');

//use App\Http\Controllers\OpCreateNew_testsController;

//Route::get('/op_create_new_test/', 'OpCreateNew_testsController@op_create_new_view' );
//Route::POST('/op_create_new_test/', 'OpCreateNew_testsController@btn_select' );
