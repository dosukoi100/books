
{{-- 本の一覧画面 --}}

<x-app-layout>
<button onclick="location.href='/book/new/'" class="text-base ml-5 mt-5 mb-5 shadow bg-green-500 hover:bg-blue-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">新規作成</button> 
    <x-slot name="header">
        <h3>{{Auth::user()->name}}さんこんにちは</h3><br>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- {{ __('Dashboard') }} -->
            {{ __('本の管理一覧画面:Books') }}
        </h2>
    </x-slot>

    {{-- フラッシュメッセージの表示 --}}
    @if(session('status'))
        <x-ui.flash-message message="{{ session('status') }}"></x-ui.flash-message>
    @endif
    {{-- フラッシュメッセージの表示 --}}
    
    {{-- 検索用 --}}
    <div class="pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="m-5">

                    <form action="{{ route('book') }}">{{-- ルート名の指定 --}}
                        <div class="flex flex-row">


                            {{-- プレースホルダーのnameをvalue属性に格納 --}}
                            <div class="col-span-6 sm:col-span-3 p-2 w-48">
                                <label for="name" class="block text-sm font-medium text-gray-700">本の名前</label>
                                <input type="text" name="name" id="name" value="{{ $name }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="p-2 w-48">
                                <label for="status" class="block text-sm font-medium text-gray-700">ステータス</label>
                                <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">--</option>
                                    {{--@foreach($statuses as $option) は教材からのコード--}}

                                    {{-- BookモデルファイルのBOOK_STATUS_OBJECTからキーとバリューを表示 --}}
                                    @foreach(App\Models\Book::BOOK_STATUS_OBJECT as $key => $value)
                                    <option value="{{ $key }}" @if($status == $key) selected @endif >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- プレースホルダーのauthorsをforeachで展開してvalue属性に格納と表示 --}}
                            <div class="p-2 w-48">
                                <label for="author" class="block text-sm font-medium text-gray-700">著者</label>
                                <select id="author" name="author" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">--</option>
                                    @foreach($authors as $option)
                                    <option value="{{ $option }}" @if($author == $option) selected @endif >{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="p-2 w-48">
                                <label for="publication" class="block text-sm font-medium text-gray-700">出版</label>
                                <select id="publication" name="publication" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">--</option>
                                    @foreach($publications as $option)
                                    <option value="{{ $option }}" @if($publication == $option) selected @endif >{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-span-6 sm:col-span-3 p-2 w-48">
                                <label for="note" class="block text-sm font-medium text-gray-700">特記事項</label>
                                <input type="text" name="note" id="note" value="{{ $note }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            {{-- 検索ボタン --}}
                            <div class="col-span-6 sm:col-span-3 p-2 w-48 relative">
                                <button type="submit" class="absolute inset-x-0 bottom-2 mr-2 shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">検索</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- 検索用 --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- tailblocks.ccからのコピー --}}
                    {{-- <section class="text-gray-600 body-font">
                    <div class="container px-5 py-24 mx-auto">
                        <div class="flex flex-col text-center w-full mb-20">
                        <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">Pricing</h1>
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Banh mi cornhole echo park skateboard authentic crucifix neutra tilde lyft biodiesel artisan direct trade mumblecore 3 wolf moon twee</p>
                        </div>
                        <div class="lg:w-2/3 w-full mx-auto overflow-auto"> --}}
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                            <tr>
                                {{-- カラム名の指定 --}}
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">名前</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ステータス</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">著者</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">出版</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">読み終わった日</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メモ</th>
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>{{-- 詳細ボタン用 --}}
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>{{-- 変更ボタン用 --}}
                                {{-- <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th> --}}
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($books as $i)
                            <tr>
                                {{-- カラムの値 --}}
                                <td class="border-t-2 border-gray-200 px-4 py-3">{{$i->id}}</td> 
                                <td class="border-t-2 border-gray-200 px-4 py-3">{{Str::limit($i->name,10,$end='...')}}</td>
                                {{-- 連想配列のkeyからvalueを呼び出すので$i->statusはリスト型にする --}}
                                <td class="border-t-2 border-gray-200 px-4 py-3">{{App\Models\Book::BOOK_STATUS_OBJECT[$i->status]}}</td> 
                                <td class="border-t-2 border-gray-200 px-4 py-3">{{Str::limit($i->author,5,$end='...')}}</td>
                                <td class="border-t-2 border-gray-200 px-4 py-3">{{Str::limit($i->publication,5,$end='...')}}</td>
                                <td class="border-t-2 border-gray-200 px-4 py-3">{{Carbon\Carbon::parse($i->read_at)->format('Y年m月j日')}}</td>
                                <td class="border-t-2 border-gray-200 px-4 py-3">{{Str::limit($i->note,30,$end='...')}}</td>
                                <td class="border-t-2 border-gray-200 px-4 py-3">
                                    {{-- <button onclick="location.href='/book/detail/{{$i->id }}'" class="text-sm shadow 最初の色 bg-色-500 マウスが乗ったときの色 hover:bg-色-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">詳細</button> --}}
                                    {{-- classのtext-sm mt-2 ml-2はご自由に --}}
                                    <button onclick="location.href='/book/detail/{{$i->id }}'" class="text-sm mt-2 ml-2 shadow bg-blue-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">詳細</button>
                                    {{-- edit.blade.phpからの流用 '/book/edit/{{ $book->id }}'は'/book/edit/{{ $i->id }}'に変える --}}
                                    <button onclick="location.href='/book/edit/{{ $i->id }}'" class="text-sm mt-2 ml-2 shadow bg-gray-500 hover:bg-yellow-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">変更</button>
                                </td>
                            </tr>
                            @endforeach 
                            </tbody>
                        </table>
                        
                        {{-- ページネーションの追加 --}}
                        {{ $books->links() }}

                        {{-- </div>
                        <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                        <a class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">Button</button>
                        </div>
                    </div>
                    </section> --}}
                    {{-- tailblocks.ccからのコピー --}}
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
