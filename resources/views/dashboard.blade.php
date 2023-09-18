<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- ここがbladeテンプレートです --}}<br>
                    {{--{{ __("You're logged in!") }}--}}

                    {{-- ログイン中のuserモデルのnameカラムを呼び出す --}}
                    {{ Auth::user()->name }}さんこんにちは<br>

                    {{-- componenteからお問い合わせボタンを呼び出す --}}
                    {{--<x-primary-button>お問い合わせ</x-primary-button>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
