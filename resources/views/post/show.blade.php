<x-layouts::app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <div class="px-10 mt-4">
                <h2 class="font-semibold text-xl text-amber-600 leading-tight">
                    投稿詳細
                    <a href="{{ route('post.index') }}"><i class="fa-solid fa-dog"></i></a>
                </h2>

                <x-message :message="session('message')" type="success" />
                <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="flex justify-between">
                        <div class="text-lg text-gray-700 font-semibold">
                            {{ $post->title }}
                        </div>
                        <div class="flex justify-end  gap-4 my-2">
                            <a href="{{ route('post.edit', $post) }}">
                                <flux:button class="bg-teal-700">編集</flux:button>
                            </a>
                            <form method="post" action="{{ route('post.destroy', $post) }}">
                                @csrf
                                @method('delete')
                                <flux:button variant="danger" class="bg-red-700" type="submit" onClick="return confirm('本当に削除しますか？🐶');">削除</flux:button>
                            </form>
                        </div>
                    </div>
                    <hr class="w-full">
                    <p class="mt-4 text-gray-600 py-4 whitespace-pre-line">{{ $post->body }}</p>

                    @if ($post->image)
                        <div class="text-black">
                            (画像ファイル: {{ $post->image}})
                        </div>
                        <img src="{{ asset('storage/images/' . $post->image) }}" class="mx-auto" style="height:300px;">
                    @endif

                    <div class="text-sm font-semibold flex flex-row-reverse text-black">
                        <p> {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
