<?php

use App\Http\Controllers\ProfileController;
//App/Http/Controllers/BookController.phpの利用
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

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
    /* ミドルウェアを使って再度パスワード確認をする */
//})->middleware(['password.confirm']);
});

//----Breezeインストール後追加----------------

//ダッシュボード
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard')->middleware('verified');

//ミドルウェアでプロフィール作成・編集・削除
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//URLパス、URL/bookの場合の処理
Route::middleware('auth')->prefix('book')->group(function () {
    Route::get('/', [BookController::class,'index'])->name('book');
    Route::get('/detail/{id}', [BookController::class,'detail'])->name('book.detail');
    Route::get('/edit/{id}', [BookController::class,'edit'])->name('book.edit');
    Route::get('/new', [BookController::class,'new'])->name('book.new');//新規登録画面を表示する

    Route::delete('/remove/{id}', [BookController::class,'remove'])->name('book.remove');//削除処理のURLパスと関数を指定
    //Route::delete('/remove/{id}','BookController@remove',[BookController::class,'remove'])->name('book.remove');

    Route::post('/create', [BookController::class,'create'])->name('book.create');//新規登録の処理はcreate関数がする

    Route::patch('/update', [BookController::class,'update'])->name('book.update');
});

//認証。メインのディレクトリに繋ぐ
require __DIR__.'/auth.php';

//----Breezeインストール後追加----------------
