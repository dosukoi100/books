<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    //フィラブル追加
    //教材だとname,status,read_at,timestamp以外
    //レコードに入らないのでauthor,publication,read_at,note追加
    //read_atを入れないと作成日の日付が入る
    protected $fillable = ['name', 'status','author','publication','read_at','note'];
    //protected $fillable = ['name', 'status'];

    /* 本来ならyamlファイルなどでBookモデルのカラムの詳細を
    するが、今回はここに記述していく */

    /*
    id: 一意(atuoincrement),not null,unique
    name: length 255,not null
    status: tinyInteger (1~255), not null,1;読書中 2;未読 3;読破 4;読みたい
    author: 著者 length 255, null ok
    publication: 出版, length 255, null ok
    read_at: 読み終わった日,date (日付 yyyy-mm-dd), null ok
    note: メモ(備考), text,null ok
    timestamps:(created_at,updated_at)

    ＊できたらTRY
    cover_image:本の画像(画像パス)

    */

    /*--- 定数を定義する--- */

    /* keyを設定 */
    public const BOOK_STATUS_READING = 1;
    public const BOOK_STATUS_UNREAD = 2;
    public const BOOK_STATUS_DONE = 3;
    public const BOOK_STATUS_WANT_READ = 4;

    /* valueを設定 */
    public const BOOK_STATUS_NAME_READING = '読書中';
    public const BOOK_STATUS_NAME_UNREAD = '未読';
    public const BOOK_STATUS_NAME_DONE = '読破';
    public const BOOK_STATUS_NAME_WANT_READ = '読みたい';

    /* keyとvalueで辞書型(連想配列)を設定 */
    public const BOOK_STATUS_OBJECT = [
        self::BOOK_STATUS_READING => self::BOOK_STATUS_NAME_READING,
        self::BOOK_STATUS_UNREAD => self::BOOK_STATUS_NAME_UNREAD,
        self::BOOK_STATUS_DONE => self::BOOK_STATUS_NAME_DONE,
        self::BOOK_STATUS_WANT_READ => self::BOOK_STATUS_NAME_WANT_READ,
    ];

    /* keyだけの配列を設定 */
    public const BOOK_STATUS_ARRAY = [
        self::BOOK_STATUS_READING,
        self::BOOK_STATUS_UNREAD,
        self::BOOK_STATUS_DONE,
        self::BOOK_STATUS_WANT_READ,
    ];

    /* バリデーションのテスト時はself::BOOK_STATUS_WANT_READ,コメントアウト */
    /* バリデーションのテスト終了したらself::BOOK_STATUS_WANT_READ,コメントアウトを外す */
    /*--- 定数を定義する--- */

    /* 検索機能 ローカルスコープ */


    //ローカルスコープの関数は必ず第一引数に$queryをとる
    //コントローラーファイルで使うBookモデルのsearch関数(=scopeSearch)を定義
    public function scopeSearch($query, $search)
    {

        //リスト(リスト-辞書型)のnameが無ければ空を返す
        $name = $search['name'] ?? '';
        $status = $search['status'] ?? '';
        $author = $search['author'] ?? '';
        $publication = $search['publication'] ?? '';
        $note = $search['note'] ?? '';

        //$nameがあれば$nameを中間一致を探す
        $query->when($name, function ($query, $name) {
            $query->where('name', 'like', "%$name%");
        });

        //$publicationがあれば$publicationを探す
        $query->when($publication, function ($query, $publication) {
            $query->where('publication', $publication);
        });

        $query->when($note, function ($query, $note) {
            $query->where('note', 'like', "%$note%");
        });

        $query->when($status, function ($query, $status) {
            $query->where('status', $status);
        });

        //著者追加
        $query->when($author, function ($query, $author) {
            $query->where('author', $author);
        });


        //条件に一致したQueryを返す
        return $query;
    }
    /* 検索機能 ローカルスコープ */
}
