<?php

use Illuminate\Support\Facades\Route;
//コントローラーを呼び出す
use App\http\Controllers\ExampleController;
use App\http\Controllers\TmpController;

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

//＊＊＊Laravelでは***.blade.phpがhtmlファイルとなる＊＊＊

//書式1
/* 
Route::メソッド('URLパス',関数{
    return view('***');
    return books/resources/views/***.blade.phpの意味
});
*/

Route::get('/', function () {
    return view('welcome');
});

//書式2
/*
Route::get('URLパス',[コントローラーの指定::class,'コントローラーの関数名']);
Djangoのurls.py的に似ている
*/

//Route::get(uri:'/',[ExampleController::class,'index']);
//Laravel10では上のuri:を指定するとエラーとなるのでこちら
Route::get('/example', [ExampleController::class, 'example']);


//URLパス/testとするとbooks/resources/views/test.blade.php
//を表示する
Route::get('/test',function () {
    return view('test');
});

Route::get('/tmp',[TmpController::class,'tmp']);

