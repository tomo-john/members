<x-layouts::app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-amber-600 leading-tight">投稿の一覧</h2>
        <x-message :message="session('message')" type="success" />
            <p class="text-white">{{ $user->name }}さん、こんにちは<i class="fa-solid fa-dog ml-4"></i></p>
        @foreach ($posts as $post)
            <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    <div class="bg-white w-full rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <p class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer">
                                <a href="{{ route('post.show', $post )}}">{{ $post->title }}</a>
                            </p>
                            <hr class="w-full">
                            <p class="mt-4 text-gray-600 py-4">{{ $post->body }}</p>
                            <div class="text-sm font-semibold flex flex-row-reverse text-black">
                                <p>{{ $post->user->name }} / {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.app>
