{{-- 詳細ページ --}}

<x-app-layout>
    <x-slot name="header">
        <h3>{{Auth::user()->name}}さんこんにちは</h3><br>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- {{ __('Dashboard') }} -->
            {{ __('本の管理詳細:Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- ここにtailwind UIを適応 --}}
                    <div>
                        <div class="px-4 sm:px-0">
                            <h3 class="text-base font-semibold leading-7 text-gray-900">本の詳細</h3>
                        </div>
                        <div class="mt-6 border-t border-gray-100">
                            <dl class="divide-y divide-gray-100">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">ID</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->id }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">名前</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->name }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">ステータス</dt>
                                {{-- <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->status }} <p>1;読書中 2;未読 3;読破 4;読みたい</p></dd> --}}
                                {{-- 連想配列のkeyからvalueを呼び出すので$i->statusはリスト型にする --}}
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ App\Models\Book::BOOK_STATUS_OBJECT[$book->status] }} {{--<p>1;読書中 2;未読 3;読破 4;読みたい</p>--}}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">著者</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->author }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">出版</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->publication }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">読み終わった日</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->read_at }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">作成日</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->created_at }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">編集日</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->updated_at }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">メモ</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $book->note }}</dd>
                            </div>
                            </dl>
                        </div>
                    </div>

                    {{-- ここにtailwind UIを適応 --}}

                    {{-- 戻るボタンと変更ボタンの表示 --}}
                    <div class="flex justify-center relative">{{-- relative追加 --}}
                        <button onclick="history.back()" class="mt-4 mr-12 shadow bg-gray-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">{{ __('戻る') }}</button> 
                        <button onclick="location.href='/book/edit/{{ $book->id }}'" class="mt-4 mr-2 shadow bg-gray-500 hover:bg-yellow-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">変更</button>
                        
                        {{-- 削除ボタンの追加 --}}
                        <div class="absolute inset-y-0 right-0"> 
                            <form action="/book/remove/{{ $book->id }}" method="POST"> 
                                @csrf 
                                @method('delete') 
                                <button type="submit" class="mt-4 mr-4 shadow bg-red-400 hover:bg-red-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">削除</button> 
                            </form> 
                        </div>
                        {{-- 削除ボタンの追加 --}}
                    </div>
                    {{-- 戻るボタンと変更ボタンの表示 --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


{{-- 
@foreach($books as $i)
    {{ $i->id }}<br>
    {{ $i->name }}<br>
    {{ $i->status }}<br>
    {{ $i->author }}<br>
    {{ $i->publication }}<br>
    {{ $i->read_at }}<br>
    {{ $i->note }}<br>
    ---------------------<br>
@endforeach
--}}

{{-- コメントアウト --}}
{{-- 
@php
    //blade(html)でphpを直接実行
    //phpinfo();
    //echo 'どすこい';
    $lists = ['cat','dog','tiger','shark'];

    foreach ($lists as $l) {
        echo $l."\n";
    };
@endphp
--}}


{{-- プレイスホルダー$bookが渡されているか確認 --}}

{{-- {{ $book }}<br> --}}

{{-- 
--------------<br>

ID:{{  $book->id}}<br>
Name:{{  $book->name}}<br>
Status:{{  $book->status}}<br>
Publication:{{  $book->publication}}<br>
Read_at:{{  $book->read_at}}<br>
Note:{{  $book->note}}<br>
Created_at:{{  $book->created_at}}<br>
Updated_at:{{  $book->updated_at}}<br>
--}}
