<x-layouts::app>
    <div class="">
        <h1>Hello 🐶</h1>

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
</x-layouts::app>
