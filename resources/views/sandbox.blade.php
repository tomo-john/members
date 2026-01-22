<x-layouts::app>
    <div class="bg-gray-800">
        <h2 class="text-2xl text-white font-semibold m-4">Snad Box<i class="fa-solid fa-dog ml-2"></i><h2>

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

    <!-- Livewire Volt -->
    <div class="bg-gray-800 mt-6">
        <h2 class="text-2xl text-white font-semibold m-4">Volt<i class="fa-solid fa-bolt ml-2"></i><h2>

        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <livewire:sandbox-lookup />
        </div>
    </div>

    <!-- ドキュメントエリア -->
    <div class="bg-gray-800 mt-6">
        <h2 class="text-2xl text-white font-semibold m-4">Memo<i class="fa-solid fa-pen ml-2"></i><h2>
        <div class="m-4 space-y-2">
            <p>index, storeは通常のController</p>
            <p>Livewire(Volt)でリアルタイム表示 + 更新処理</p>
        </div>
    </div>

</x-layouts::app>
