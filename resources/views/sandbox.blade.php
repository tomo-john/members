<x-layouts::app>
    <div class="bg-gray-800">
        <h1 class="mx-4">Hello 🐶</h1>

        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <x-message :message="session('message')" type="success" />
            <form action="{{ route('sandbox.store') }}" method="post" class="space-y-6">
                @csrf

                <flux:input name="name" label="name" placeholder="例: じょん" />
                <flux:input type="date" label="scheduled_at" name="scheduled_at" view="calendar" />
                <flux:button type="submit" variant="primary">保存</flux:button>
            </form>
        </div>
    </div>

    <div class="bg-gray-800 mt-6">
        @php
            $item = $sandbox->where('id', 2)->first();
        @endphp

        {{ $item->name }}
        {{ $item->scheduled_at }}
    </div>
</x-layouts::app>
