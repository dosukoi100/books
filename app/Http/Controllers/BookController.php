<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Bookモデルの追加
use App\Models\Book;
//ファサードの利用
use Illuminate\Support\Facades\DB;
//バリデーターの利用
//use App\Http\Controllers\Validator;

//バリデーションファサードを利用
use Illuminate\Support\Facades\Validator;
//ルールの使用
//use Illuminate\Foundation\Console\stubs\rule;
use Illuminate\Validation\Rule;
//Request(BookValidationRequest)クラスを使ったバリデーション利用
use App\Http\Requests\BookValidationRequest;

class BookController extends Controller
{
    //一覧の処理
    // public function index(Request $request)
    public function index(Request $request)
    {
        //ページネーションの追加 ()内で表示数を指定
        // $books = Book::paginate(10);
        //$books = Book::all();
        //$books = '今は値がありません';

        // return view('book.index',['books'=>$books]);

        //----検索機能----

        //検索するリクエストをname,status,author,publication,noteに限定する
        $input = $request->only('name', 'status', 'author', 'publication', 'note');
        //モデルファイルのscopeSearch関数の検索ルールに沿ってidを基準に降順ソートしページネーション
        $books = Book::search($input)->orderBy('id', 'desc')->paginate(10);
        //Bookモデルから'publication'の値から検索してグループ化してリスト化(pluck)する
        $publications = Book::select('publication')->groupBy('publication')->pluck('publication');
        $authors = Book::select('author')->groupBy('author')->pluck('author');

        //ステータスは$bookに入っている

        return view(
            //表示するビューファイル
            'book.index',
            //リスト型でプレースホルダーを渡す
            ['books' => $books,
                // selectboxの値
                'publications' => $publications,
                'authors' => $authors,
                //ステータスは＄bookに入っている

                // 検索する値
                //??以降は、値が無ければ空にすると言う意味
                'name' => $input['name'] ?? '',
                'publication' => $input['publication'] ?? '',
                'author' => $input['author'] ?? '',
                'status' => $input['status'] ?? '',
                'note' => $input['note'] ?? '',
            ]
        );
        //----検索機能----
    }

    //詳細の処理
    public function detail($id)
    {
        // $book = Book::find($id);
        //$idがあれば$id
        //なければ404エラーを返すメソッドfindOrFail()
        $book = Book::findOrFail($id);

        return view('book.detail', ['book'=>$book]);
    }

    //編集の処理
    public function edit($id)
    {
        // $book = Book::find($id);
        $book = Book::findOrFail($id);

        return view('book.edit', ['book'=>$book]);
    }

    //編集の処理(辞書型使用(連想配列))
    // public function edit($id)
    // {
    //     $book = Book::find($id);

    //     $dic = array(
    //         '読書中' => 1,
    //         '未読' => 2,
    //         '読破' => 3,
    //         '読みたい' => 4
    //     );

    //     return view('book.edit',['book'=>$book,'dic'=>$dic]);

    // }

    //編集のデータのアップデートの処理
    //public function update(Request $request)

    //BookValidationRequestの利用
    //BookValidationRequestはRequestクラスを継承しているので
    //バリデーション以外のRequestも可能
    public function update(BookValidationRequest $request)
    {
        try {
            //----コントローラーファイルにバリデーションをする方法-----
            //リクエストの全てを変数validatedに格納 []内で条件定義
            // $validated = Validator::make($request->all(), [
            //     'name' => 'required|max:255',
            //     //Ruleクラスを使ってBOOK::BOOK_STATUS_ARRAYのルールに従っているか検証
            //     'status' => ['required', Rule::in(BOOK::BOOK_STATUS_ARRAY)],
            //     //こちらの形でもOK
            //     //'status' => 'required|numeric|between:1,2,3',
            //     'author' => 'max:255',
            //     'publication' => 'max:255',
            //     'note' => 'max:255',
            //     'read_at' => 'nullable|date',
            // ]);

            // //変数validetedが失敗したらルート名book.editに戻してエラー表示する
            // if($validated->fails()) {
            //     return redirect()->route('book.edit', ['id' => $request->input('id')])->withErrors($validated)->withInput();
            // }
            //----コントローラーファイルにバリデーションをする方法-----

            // バリデーションを実行
            // $validated = $request->validate([
            //     'name' => 'required|max:255',
            //     'status' => ['required', Rule::in(BOOK::BOOK_STATUS_ARRAY)],
            //     // 他のルールをここに追加
            // ]);

            // // バリデーションが失敗した場合、リダイレクトとエラーメッセージを返す
            // if ($validated) {
            //     return redirect()->route('book.edit', ['id' => $request->input('id')])
            //         ->withErrors($validated)
            //         ->withInput();
            // }

            //トランザクション開始
            DB::beginTransaction();
            //idを基準にBookモデルからレコードを取得して$bookに格納
            //requestされたidをBookモデルのidに格納
            $book = Book::find($request->input('id'));
            //requestされたnameをBookモデルのnameに格納
            $book->name = $request->input('name');
            $book->status = $request->input('status');
            $book->author = $request->input('author');
            $book->publication = $request->input('publication');
            $book->read_at = $request->input('read_at');
            $book->note = $request->input('note');
            //$bookをセーブ
            $book->save();
            //DBに確定
            DB::commit();
            //処理がここまできたらURLパスURL/bookに戻す
            //フラッシュメッセージの処理
            return redirect('book')->with('status', '本の情報を更新しました。');
        } catch (\Exception $ex) {
            //ロールバック処理
            DB::rollback();
            //ログファイルにメッセージを出力
            logger($ex->getMessage());
            //処理がここまできたらURLパスURL/bookに戻す
            //フラッシュメッセージの処理(エラーメッセージ)
            return redirect('book')->withErrors($ex->getMessage());
        }
    }

    //新規登録画面の処理(表示のみ)
    public function new()
    {
        return view('book.new');//
    }

    //新規登録処理(フォームをBookモデルに登録する処理)
    //public function create(Request $request)
    //BookValidationRequestの利用
    public function create(BookValidationRequest $request)
    {
        try {
            //Bookモデルにフォームからの値を入れる(create)
            Book::create($request->all());
            //成功したらリダイレクトでURL/book(一覧画面)に遷移
            //フラッシュメッセージを表示
            return redirect('book')->with('status', '本の情報を作成しました。');
        } catch (\Exception $ex) {
            //ログファイルにメッセージを出力
            logger($ex->getMessage());
            //
            //失敗したらリダイレクトでURL/bookに遷移
            //フラッシュメッセージ表示
            return redirect('book')->withErrors($ex->getMessage());
        }

       //これだけではエラー(表面にはエラーでは無いがerrlogでエラーとなる)ので
       //モデルファイルでフィラブルを追加する
       //protected $fillable = ['name', 'status'];など
    }

    // //削除処理の関数を定義
    public function remove($id)
    {
        try {
            //Bookモデルのidを起点にそのレコードを削除
            // Book::find($id)->delete();
            Book::findOrFail($id)->delete();
            //echo 'tryが発動しました'."\n";
            //成功したらURL/book(一覧画面)に遷移してフラッシュメッセージを表示
            return redirect('book')->with('status', '本の情報を削除しました。');
        } catch (\Exception $ex) {
            //失敗したらログファイルに出力
            logger($ex->getMessage());
            //echo $ex->getmessage()."\n";
            //echo 'catchが発動しました'."\n";
            //一覧画面に遷移してフラッシュメッセージを表示
            //return redirect('book')->withErrors($ex->getMessage());

            //処理を中断してステータス404を返す
            abort(404);
        }
    }


    // public function remove($id)
    // {
    //     try {
    //         $book = Book::findOrFail($id);
    //         if ($book) {
    //             echo 'tryが発動しました'."\n";
    //             $book->delete();
    //             return redirect('book')->with('status', '本の情報を削除しました。');
    //         }
    //     } catch (\Exception $ex) {
    //         logger($ex->getMessage());
    //         echo 'catchが発動しました'."\n";
    //         abort(404);
    //     }
    // }

    // public function remove($id)
    // {
    //     try {
    //         Book::findOrFail($id);
    //         $book = Book::findOrFail($id);
    //         echo 'tryが発動しました'."\n";
    //         shell_exec("curl -X DELETE http://127.0.0.1/book/remove/$book->$id");
    //         return redirect('book')->with('status', '本の情報を削除しました。');
    //     } catch (\Exception $ex) {
    //         logger($ex->getMessage());
    //         echo 'catchが発動しました'."\n";
    //         abort(404);
    //     }
    // }
}
