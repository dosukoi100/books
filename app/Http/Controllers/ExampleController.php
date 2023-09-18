<?php

namespace App\Http\Controllers;

//Exampleモデル(examplesテーブル)を呼び出す
use App\Models\Example;
use Illuminate\Http\Request;

//直接SQLを使うときに呼び出す
//use Illuminate\Support\Facades\DB;

//Djangoのviews.pyに似ている

class ExampleController extends Controller
{
    //関数を作成する
    public function example()
    {
        //---クエリビルダ----
        $examples = Example::all();//全てのレコード
        //$examples = Example::find(2);//idを指定して取得
        //$examples = Example::where('id',3) -> get() ;//where文
        //$examples = Example::wherein('id',[1,3]) -> get();//複数条件

        //return view(view: 'example', ['examples' => $examples] );
        return view('example', ['examples' => $examples]);

        //---クエリビルダ----

        //Eroqent
        //$examples = Examples.all();

        //----SQL文直接の場合-------
        //$examples = DB::select('select * from examples where id = 1 ;');

        //$examplesは配列構造なので値をオブジェクト型に変更
        //$example = $examples[0];

        //検証用にvar_dumpを使う
        //var_dump($examples);
        //var_dump($example);

        //SQL用のviewの指定
        //return view('example',['example' => $example]);
        //----SQL文直接の場合-------

        //return view(view: 'example', ['examples' => $examples] );
        return view('example', ['examples' => $examples]);
    }
}
