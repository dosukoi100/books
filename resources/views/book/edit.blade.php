{{-- 変更ページ --}}

<x-app-layout>
    <x-slot name="header">
        <h3>{{Auth::user()->name}}さんこんにちは</h3><br>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- {{ __('Dashboard') }} -->
            {{ __('本の管理変更画面:Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <form class="w-full" action="{{ route('book.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
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
                                <input value="{{ $book->id }}" name="id" type="hidden">
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">名前</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{-- tailwind UIからのinputタグ --}}
                                    <!-- <div class="sm:col-span-3"> -->
                                    <!-- <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First name</label> -->
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name" autocomplete="given-name" value="{{ old('name',$book->name) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        {{-- バリデーションのエラー表示 --}}
                                        @error('name')
                                            <div class="text-red-600">{{ $message }}</div>
                                        @enderror
                                        {{-- バリデーションのエラー表示 --}}
                                    </div>
                                    <!-- </div> -->
                                    {{-- tailwind UIからのinputタグ --}}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">ステータス</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <div class="mt-2">
                                        <select id="status" name="status" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                            {{-- app/Models/Book.phpに定数を定義したやり方 --}}

                                            {{-- app/Models/Book.phpの定数BOOK_STATUS_OBJECTを使って辞書型(連想配列)を展開 --}}
                                            @foreach(App\Models\Book::BOOK_STATUS_OBJECT as $key => $value)
                                                <option value="{{ $key }}" @if($key === (int)old('status',$book->status)) selected @endif>{{ $value }}</option>
                                            @endforeach
                                            {{-- app/Models/Book.phpに定数を定義したやり方 --}}

                                            {{-- 静的に値を設定する方法 --}}
                                            {{-- <option value="1">読書中</option>
                                            <option value="2">未読</option>
                                            <option value="3">読破</option>
                                            <option value="4">読みたい</option>
                                            <option value="{{ $book->status }}" selected>
                                            @if ($book->status == 1) 読書中 @endif
                                            @if ($book->status == 2) 未読 @endif
                                            @if ($book->status == 3) 読破 @endif
                                            @if ($book->status == 4) 読みたい @endif 
                                            </option>--}}
                                            {{-- 静的に値を設定する方法 --}}
                                            
                                            {{-- コントローラーファイルに辞書型(連想配列)のプレースホルダーを追加する方法 --}}
                                            {{-- @foreach ($dic as $key => $value)
                                                <option value="{{$value}}">{{$key}}</option>
                                            @endforeach


                                            @foreach ($dic as $key => $value)
                                                @if ($book->status !== $value) 
                                                @else <option value="{{ $book->status }}" selected>{{$key}}</option>
                                                @endif
                                            @endforeach --}}
                                            {{-- コントローラーファイルに辞書型(連想配列)のプレースホルダーを追加する方法 --}}

                                            <!-- <option>United States</option>
                                            <option>Canada</option>
                                            <option>Mexico</option>
                                            <option selected>Japan</option> -->
                                        </select>
                                        @error('status')
                                            <div class="text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <br>
                                    {{-- <p>1;読書中 2;未読 3;読破 4;読みたい</p> --}}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">著者</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <div class="mt-2">
                                        <input type="text" name="author" id="author" autocomplete="given-name" value="{{ old('author',$book->author) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        @error('author')
                                            <div class="text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">出版</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <div class="mt-2">
                                        <input type="text" name="publication" id="publication" autocomplete="given-name" value="{{ old('publication',$book->publication) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        @error('publication')
                                            <div class="text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">読み終わった日</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <div class="mt-2">
                                        <input type="text" name="read_at" id="read_at" placeholder="例)2023-08-24" autocomplete="given-name" value="{{ old('read_at',$book->read_at) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        @error('read_at')
                                            <div class="text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">メモ</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <div class="mt-2">
                                        <textarea id="note" name="note" rows="6" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ old("note",$book->note) }}</textarea>
                                        @error('note')
                                            <div class="text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </dd>
                            </div>
                            </dl>
                        </div>
                    </div>

                    {{-- ここにtailwind UIを適応 --}}

                    {{-- 戻るボタンと変更ボタンの表示 --}}
                    <div class="flex justify-center">
                        <button onclick="history.back()" class="mt-4 mr-12 shadow bg-gray-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">{{ __('戻る') }}</button> 
                        <button type="submit" class="mt-4 mr-2 shadow bg-gray-500 hover:bg-yellow-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">変更確定</button> 
                    </div>
                    {{-- 戻るボタンと変更ボタンの表示 --}}
                </form>
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
