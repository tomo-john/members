<x-layouts::app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-amber-600 leading-tight">投稿の一覧</h2>
        <x-message :message="session('message')" type="success" />
        <p class="text-white my-2">{{ $user->name }}さん、こんにちは<i class="fa-solid fa-dog ml-4"></i></p>
        @foreach ($posts as $post)
            <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    <div class="bg-white w-full rounded-2xl px-10 py-8 pb-8 shadow-lg hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <div class="flex items-center gap-2">
                                <div class="flex items-center rounded-full w-12 h-12 bg-gray-200 border border-gray-100 shadow-sm overflow-hidden">
                                    <!-- アバター表示 -->
                                    <img src="{{ asset('storage/avatar/' . ($post->user->avatar ?? 'user_default.jpg')) }}" class="w-full h-hull object-cover">
                                </div>
                                <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer float-left pt-4">
                                    <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                                </h1>
                            </div>
                            <hr class="w-full">
                            <p class="mt-4 text-gray-600 py-4">{{ Str::limit($post->body, 100, '...') }}</p>
                            <div class="text-sm font-semibold flex flex-row-reverse text-black">
                                <p>{{ $post->user->name ?? '退会ユーザー' }} / {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            @if ($post->comments->count())
                                <flux:badge variant="solid" color="teal">コメント {{ $post->comments->count() }}件</flux:badge>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.app>
