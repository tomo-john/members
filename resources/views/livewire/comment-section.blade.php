<div>
    <div class="mt-4 mb-12">
        @if (session()->has('message'))
            <div class="text-green-600 mb-4">
                {{ session('message') }}
            </div>
        @endif

        @foreach ($comments as $comment)
            <div class="text-gray-500 bg-white w-full rounded-2xl px-10 py-2 shadow-lg mt-8 whitespace-pre-line">
                {{ $comment->body }}
                <div class="text-sm font-semibold flex flex-row-reverse">
                    <p>{{ $comment->user->name }} / {{ $comment->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach

        <form wire:submit="save">
            <textarea wire:model="body"
                      class="text-gray-600 bg-white w-full rounded-2xl px-4 mt-4 py-4 shadow-lg hover-shadow-2xl transition duration-500"
                      cols="30" rows="10" placeholder="コメントを入力して下さい🐶"></textarea>
            <flux:button type="submit" class="float-right mr-4 mb-12">
                コメントする
            </flux:button>
        </form>
    </div>
</div>

