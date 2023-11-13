<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//Factoryを使うのでユーザーモデルを呼び出す。
use App\Models\User;

//Factoryを使うのでBookモデルを呼び出す。
use App\Models\Book;

class BookTest extends TestCase
{
    //フェイカーを使うことを宣言
    use WithFaker;

    //データベースのテストデータをテスト毎に消すことを宣言
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * 
     * @testなら、public function example():となる
     * 
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /*  テスト名について
    LaravelのUnitTestのテスト名は下記のいずれかになります。

    ・「test_」から始める
    ・コメントに「@test」をつける（この場合は「test_」から始める必要はなし）
    
    また、テスト名は、事前に自身でルールを決めておいたほうがいいです。
    そうしないと、あとあとテストケースを探すのに苦労します。

    今回は
    
    test_<url>_<証明する内容>

    とします。
    */

    //-----今回のテストで行うこと-----

    // 1.ログインユーザがbook.indexにアクセスできるか？
    // 2.ログインしてないユーザがbook.indexにアクセスできないかか？
    // 3.book.detailにアクセスできるか？
    // 4.存在しない値でbook.detailにアクセス出来ないことを確認する
    // 5.book.editにアクセスできるか？
    // 6.存在しない値でbook.editにアクセス出来ないことを確認する
    // 7.book.editで正常系のテストを実施する
    // 8.book.editで異常系のテストを実施する
    // 9.book.newで正常系のテストを実施する
    // 10.book.newで異常系のテストを実施する
    // 11.removeで正常系のテストを実施する
    // 12.removeで異常系のテストを実施する
    // 13.検索機能が正常にテスト出来ること

    //-----今回のテストで行うこと-----

    //---  ログインしていないユーザーがbook.index(一覧画面:URL/book)にアクセスできないことを試す  ---
    public function test_book_index_ng()
    {
        // URLパス、URL/bookに対するテスト
        $response = $this->get('/book');
        //ログインしていないとログイン画面にリダイレクトされるので302
        $response->assertStatus(302);
        
    }

    //---  ログインユーザがbook.indexにアクセスできるか？  ----
    public function test_book_index_ok()
    {
        //--Userモデルでファクトリーを使ってログインさせる方法--
        //ファクトリーで$userを作る
        $user = User::factory()->create();
        //$userでログインさせて(actingAs)、 URLパス、URL/bookに対するテスト
        $response = $this->actingAs($user)->get('/book');
        //--Userモデルでファクトリーを使ってログインさせる方法--
        
        /*// URLパス、URL/bookに対するテスト
        $response = $this->get('/book');*/

        //ログインしていると正常に処理されるので200
        $response->assertStatus(200);
    }

    //---  book.detailにアクセスできるか？  ---
    public function test_book_detail_id_exist()
    {
        //ファクトリでダミーユーザーを作成
        $user = User::factory()->create();
        //ファクトリでダミーBookデータを作成
        $book = Book::factory()->create();

        //$userでbook/detail/idにログイン id部分は$bookからidを指定
        $response = $this->actingAs($user)->get("/book/detail/$book->id");
        //ステータスが200なら正常。book.detailにアクセスできる
        $response->assertStatus(200);
    }

    //---  存在しない値でbook.detailにアクセス出来ないことを確認する  ---
    public function test_book_detail_id_notexist()
    {
        //ファクトリを使ってダミーのユーザーを作成
        $user = User::factory()->create();

        //$userでログインして存在しないURLパス、URL/book/datail/9999にアクセス
        $response = $this->actingAs($user)->get("/book/detail/9999");
        //存在しないのでステータスが404なら正常。
        $response->assertStatus(404);
    }

    //---  book.editにアクセス出来るか  ---
    public function test_book_edit_id_exist()
    {
        //ファクトリでダミーユーザーとダミーBookデータを作成
        $user = User::Factory()->create();
        $book = Book::Factory()->create();

        //$userでログイン、$bookのidを指定して
        //URL/book/edit/$book->idでURLパスを通す
        $response = $this->actingAs($user)->get("/book/edit/$book->id");
        //ステータスは正常の200
        $response->assertStatus(200);
    }

    //---  存在しない値でbook.editにアクセス出来ないことを確認する  ---
    public function test_book_edit_id_notexist()
    {
        //ファクトリでダミーユーザーを作成
        $user = User::Factory()->create();
        //こんなやり方もあり
        $book = 9999;

        //ダミーユーザーでログインして$bookを指定してURL/book/edit/$bookにアクセス
        $response = $this->actingAs($user)->get("/book/edit/$book");
        //存在しないページなので404エラーを出して正常なのを確認
        $response->assertStatus(404);
    }

    //---  book.editで正常系のテストを実施する(update) 更新処理 ---
    public function test_book_update_ok()
    {
        //ファクトリでダミーユーザーとダミーBookデータを作成
        $user = User::Factory()->create();
        $book = Book::Factory()->create();

        //更新するデータセットを用意する
        $params = [
            'id' => 1, //$book->idでもOK
            'name' => 'test',
            'status' => 1,
            'author' => 'test',
            'publication' => 'test',
            'read_at' => '2020-10-04',
            'note' => 'test',
        ];  

        //$userでログインして$paramsで更新する
        //更新はpatchで URL/book/updateなので注意
        $response = $this->actingAs($user)->patch("/book/update/",$params);
        //コントローラファイルのupdate関数でリダイレクトされるので302
        $response->assertStatus(302);
        //フラッシュメッセージをセッションで保持しているのでそのキーと値を検証
        $response->assertSessionHas('status','本の情報を更新しました。');
        //echo 'どすこい'."\n";
        //*(注意)*bookテーブルに$paramsが格納されているかを検証
        $this->assertDatabaseHas('books',$params);
        //echo 'どすこい2';

    }

    //---  book.editで異常系のテストを実施する(update) 単体エラーテスト 更新処理---

    //今回はnameとstatusをバリデーションルールの範囲外にします。
    //nameはバリデーションルールmaxを2文字にしたので単体エラーテストが終わったら
    //***バリデーションファイルのルールを元に戻してnameのassertSessionHasErrorsは
    //コメントアウトしておくこと!!***

    //これを１つ１つ追加して全体のエラーテストも可能

    public function test_book_update_ng()
    {
        //ファクトリでダミーユーザーとダミーBookデータを作成
        $user = User::Factory()->create();
        $book = Book::Factory()->create();

        //更新するデータセットを用意する
        //バリデーションファイルのルール範囲外のものを指定する
        $params = [
            'id' => 1, //$book->idでもOK
            'name' => 'test',//２文字以下なのでエラー
            'status' => 9,//正しい値でないものを入れる
            //'status' => 4,
            'author' => 'test',
            'publication' => 'test',
            'read_at' => '2020-10-04',
            'note' => 'test',
        ];  

        //$userでログインして$paramsで更新する
        //更新はpatchで URL/book/updateなので注意
        $response = $this->actingAs($user)->patch("/book/update/",$params);
        //コントローラファイルのupdate関数でリダイレクトされるので302
        $response->assertStatus(302);

        //コントローラーファイルのupdate関数のcatchの部分の$exでエラーの場合のフラッシュメッセージを
        //セッションで保持しているのでそのキーと値を検証。
        //キーはstatus,値は実際にエラーを発生させてエラー表示を確認
        $response->assertSessionHasErrors(['status'=>'選択されたステータスは正しくありません。']);
        //$response->assertSessionHasErrors('status','選択されたステータスは正しくありません。');

        //キーはname,値は実際のエラーを発生させてエラー表示を確認
        //$response->assertSessionHasErrors('name','名前は、2文字以下で指定してください。');
        //$response->assertSessionHasErrors(['name'=>'名前は、2文字以下で指定してください。']);
        
        //*(注意)*bookテーブルに$paramsが格納されていないかを検証
        $this->assertDatabaseMissing('books',$params);
        
    }

    //---  book.editで異常系のテストを実施する(総合エラー)  更新処理---
    public function test_book_update_all_ng()
    {
        //ファクトリでダミーユーザーとダミーBookデータを作成
        $user = User::Factory()->create();
        $book = Book::Factory()->create();

        //フェイカーでrealText形式で300文字作成
        //256文字では英語で作成するのでエラーとならないことがある為300文字
        $val = $this->faker->realText(300);

        // $params = [
        //     'id' => $book -> id,
        //     'name' => $this->faker->realText(300),
        //     'status' => 9,
        //     'author'=> $this->faker->realText(300),
        //     'publication'=>$this->faker->realText(300),
        //     'read_at'=>'2002-08-10xxxx',
        //     'note'=>$this->faker->realText(300),
        // ];

        //パラメーターにid以外不正な値を入れる
        $params = [
                'id' => $book -> id,
                'name' => $val,
                'status' => 9,
                'author'=> $val,
                'publication'=> $val,
                'read_at'=>'2002-08-10xxxx',
                'note'=>$val,
            ];
        //$name1 = $this->faker->text(32);
        
        ///$userでログインして$paramsで更新する
        //更新はpatchで URL/book/updateなので注意
        $response = $this->actingAs($user)->patch('/book/update',$params);
        //コントローラファイルのupdate関数でリダイレクトされるので302
        $response->assertStatus(302);

        //$responseの不正な値の場合のキーと値を検証
        $response->assertInvalid(['name'=>'名前は、255文字以下で指定してください。']);
        //こちらの方法(assertSessionHasErrors)でもいい気はします
        //$response->assertSessionHasErrors(['name'=>'名前は、255文字以下で指定してください。']);
        $response->assertInvalid(['status'=>'選択されたステータスは正しくありません。']);
        $response->assertInvalid(['author'=>'著者は、255文字以下で指定してください。']);
        $response->assertInvalid(['publication'=>'出版は、255文字以下で指定してください。']);
        $response->assertInvalid(['read_at'=>'読み終わった日には有効な日付を指定してください。']);
        $response->assertInvalid(['note'=>'メモは、255文字以下で指定してください。']);

        //echo $name1.'どす'."\n";
        //echo $val.'どすこい'."\n";
        //echo $response['status'].'どすこい2'."\n";

        //*(注意)*bookテーブルに$paramsが格納されていないかを検証
        $this->assertDatabaseMissing('books',$params);
    }

    //---  book.newで正常系のテストを実施する  新規登録処理---
    public function test_book_create_ok()
    {
        //ファクトリでダミーユーザーを作成
        $user = User::Factory()->create();

        //更新するデータセットを用意する
        $params = [
            //idはautoincrimentで用意される
            'name' => 'test',
            'status' => 1,
            'author' => 'test',
            'publication' => 'test',
            'read_at' => '2020-10-04',
            'note' => 'test',
        ];  

        //$userでログインして$paramsで更新する
        //新規登録はpostで URL/book/create
        $response = $this->actingAs($user)->post("/book/create",$params);
        //コントローラファイルのcreate関数でリダイレクトされるので302
        $response->assertStatus(302);
        //フラッシュメッセージをセッションで保持しているのでそのキーと値を検証
        $response->assertSessionHas('status','本の情報を作成しました。');
        //echo 'どすこい'."\n";
        //*(注意)*bookテーブルに$paramsが格納されているかを検証
        $this->assertDatabaseHas('books',$params);
        //echo 'どすこい2';

    }

    //---  book.newで異常系のテストを実施する  新規登録処理  ---
    public function test_book_create_all_ng()
    {
        //ファクトリでダミーユーザーを作成
        $user = User::Factory()->create();

        //フェイカーでrealText形式で300文字作成
        //256文字では英語で作成するのでエラーとならないことがある為300文字
        $val = $this->faker->realText(300);

        //パラメーターに不正な値を入れる
        $params = [
                //id入らない
                'name' => $val,
                'status' => 9,
                'author'=> $val,
                'publication'=> $val,
                'read_at'=>'2002-08-10xxxx',
                'note'=>$val,
            ];
        
        ///$userでログインして$paramsで更新する
        //新規登録はpostで URL/book/create
        $response = $this->actingAs($user)->post('/book/create',$params);
        //コントローラファイルのcreate関数でリダイレクトされるので302
        $response->assertStatus(302);

        //$responseの不正な値の場合のキーと値を検証
        $response->assertInvalid(['name'=>'名前は、255文字以下で指定してください。']);
        //こちらの方法(assertSessionHasErrors)でもいい気はします
        //$response->assertSessionHasErrors(['name'=>'名前は、255文字以下で指定してください。']);
        $response->assertInvalid(['status'=>'選択されたステータスは正しくありません。']);
        $response->assertInvalid(['author'=>'著者は、255文字以下で指定してください。']);
        $response->assertInvalid(['publication'=>'出版は、255文字以下で指定してください。']);
        $response->assertInvalid(['read_at'=>'読み終わった日には有効な日付を指定してください。']);
        $response->assertInvalid(['note'=>'メモは、255文字以下で指定してください。']);

        //echo $name1.'どす'."\n";
        //echo $val.'どすこい'."\n";
        //echo $response['status'].'どすこい2'."\n";

        //*(注意)*bookテーブルに$paramsが格納されていないかを検証
        $this->assertDatabaseMissing('books',$params);
    }

    //---  removeで正常系のテストを実施する 削除  ---
    public function test_book_remove_ok()
    {
        //ファクトリでダミーユーザーとダミーBookデータを作成
        $user = User::Factory()->create();
        $book = Book::Factory()->create();

        //$userでログインして
        //削除はdeleteで URL/book/remove/id番号
        $response = $this->actingAs($user)->delete("/book/remove/$book->id");
        //コントローラファイルのremove関数でリダイレクトされるので302
        $response->assertStatus(302);
        //フラッシュメッセージをセッションで保持しているのでそのキーと値を検証
        $response->assertSessionHas('status','本の情報を削除しました。');
        
        //上までの処理で$bookのレコードは無くなっているので
        //再度Bookモデルからidを指定してレコードを引っ張ってくる
        $book = Book::find($book->id);
        //当然ここでの$bookはからなのでからの場合の証明をする
        $this->assertEmpty($book);  //True
    }

    //---  removeで異常系のテストを実施する 削除  ---
    public function test_book_remove_ng()
    {
        //ファクトリでダミーユーザーを作成
        $user = User::Factory()->create();
        //Book::Factory()->create();

        //$userでログインして
        //削除はdeleteで URL/book/remove/9999(異常な値)
        $response = $this->actingAs($user)->delete("/book/remove/9998");
        //コントローラーファイルのremove関数のcatch部分が働いてリダイレクトするので302
        //$response->assertStatus(302);

        //コントローラーファイルのremove関数のcatch部分が働いてabort(404)を起動する
        $response->assertStatus(404);

        //フラッシュメッセージをセッションで保持しているのでそのキーと値を検証
        //$response->assertSessionHas('status','本の情報を削除しました。');
        //$response->assertSessionHasErrors(['name'=>'名前は、255文字以下で指定してください。']);
        
        //上までの処理で$bookのレコードは無くなっているので
        //再度Bookモデルからidを指定してレコードを引っ張ってくる
        //$book = Book::find($book->id);
        //当然ここでの$bookはからなのでからの場合の証明をする
        //$this->assertEmpty($book);  //True

        //ChatGPTより(ステータスが302などの場合)
        // エラーが発生した場合、リダイレクトとエラーメッセージを確認
        //$response->assertRedirect('/book');
        //$response->assertSessionHasErrors();

        // ログにエラーメッセージが出力されたか確認
        //$this->test_assertLogHas('エラーメッセージの一部または全体');
    }

    //ChatGPTより
    // protected function test_assertLogHas($message)
    //     {
    //         ///Users/yamauchi/vscode/laravelproject/books/storage/logs/laravel-2023-10-30.log
    //         $logContents = file_get_contents(storage_path('logs/laravel-2023-11-01.log'));
    //         echo $message;
    //         echo $logContents;
    //         //$this->assertStringContainsString($message, $logContents);
    //         $this->assertStringContainsString($message,$logContents);
            
    //     }

    //検索機能のテスト
    public function test_book_search_ok()
    {
        //基本的にはChatGPTさんからの流用
        // // Create some sample books in the database
        // $book1 = Book::factory()->create([
        //     'name' => 'Book 1',
        //     'author' => 'Author 1',
        //     'publication' => 'Publication 1',
        //     //'status' => 'Available',
        //     'status' => 4,
        //     'note' => 'Note 1',
        // ]);

        // $book2 = Book::factory()->create([
        //     'name' => 'Book 2',
        //     'author' => 'Author 2',
        //     'publication' => 'Publication 2',
        //     //'status' => 'Borrowed',
        //     'status' => 4,
        //     'note' => 'Note 2',
        // ]);

        // // Perform a search
        // //URLパス、URL/book?name=Book1&status=4で検索
        // $response = $this->get('/book', [
        //     'name' => 'Book1',  //nameのBook1で検索
        //     'status' => 4,  // statusが4で検索
        // ]);

        //オリジナル

        //ダミーユーザーとダミーのbookデータを作成
        $user = User::Factory()->create();
        $book = Book::Factory()->create();

        //ダミーユーザーでログイン。URL/bookのnameとstatusで検索
        $response = $this->actingAs($user)->get('/book',[
            'name' => $book->name,
            //'name' => 'どすこい',
            'status' => $book->status,
        ]);

        //$response->assertRedirect('/book');


        // // Perform a search
        // //URLパス、URL/book?name=Book1&status=4で検索
        // $response = $this->get('/book', [
        //     'name' => 'Book1',  //nameのBook1で検索
        //     'status' => 4,  // statusが4で検索
        // ]);

        //assertSeeは部分一致
        $response->assertSee('DOCTYPE html');
        
        echo $book->name."\n";
        echo $book->status."\n";
        echo $book->author."\n";
        echo $book->publication."\n";
        echo $book->note."\n";
        echo $book->read_at."\n";
        echo 'ここまでは成功'."\n";

        // Assert that the response contains the expected data
        // $response->assertStatus(200)
        //     ->assertSee('Book 1')
        //     ->assertDontSee('Book 2')
        //     ->assertSee(4)
        //     ->assertDontSee(4)
        //     ->assertSee('Publication 1')
        //     ->assertDontSee('Publication 2')
        //     ->assertSee('Note 1')
        //     ->assertDontSee('Note 2');

        //$response->assertSee($book->name);
        //$response->assertDontSee($book->name);
        //$response->assertSee($book->status);
        //$response->assertDontSee($book->status);
        //$response->assertStatus(200);

        $response
            //正常処理されているか
            ->assertStatus(200)
            //->assertSee($book->name)//10
            ->assertDontSee($book->name)//10
            ->assertSee($book->status)
            ->assertSee($book->author)//5
            ->assertSee($book->publication)//5
            //->assertSee($book->note)//30
            ->assertDontSee($book->note)//30
            ->assertDontSee($book->read_at);
        //$response->followRedirects($response)->assertStatus(200);
        
    }

    

}
