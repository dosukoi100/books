<?php

//bookアプリの編集・新規作成のバリデーションルール

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//ルールの使用
use Illuminate\Validation\Rule;
//Bookモデルの追加
use App\Models\Book;

class BookValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //ここをtrueにしないとバリデーションが働かない
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //テスト時はmaxを2とかでエラーを出しやすくする
            //テスト終了後はmaxを255に戻す

            //バリデーションルールの記述
            'name' => 'required|max:255',
            //Ruleクラスを使ってBOOK::BOOK_STATUS_ARRAYのルールに従っているか検証
            'status' => ['required', Rule::in(BOOK::BOOK_STATUS_ARRAY)],
            //こちらの形でもOK
            //'status' => 'required|numeric|between:1,2,3',
            'author' => 'max:255',
            'publication' => 'max:255',
            'note' => 'max:255',
            'read_at' => 'nullable|date',

        ];
    }
}
