<div>
    <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-semibold text-center">
            <i class="fa-solid fa-dog mx-2"></i>
            Sand Box
            <i class="fa-solid fa-dog mx-2"></i>
        </h2>
    </div>

    <div class="max-w-3xl mx-auto border rounded-md space-y-4 p-4 m-4">
        <h2 class="text-2xl font-semibold ">Form</h2>
        <flux:input label="Name" icon="face-smile" wire:model="name" placeholder="じょん・どぅ" />
        <flux:checkbox label="Is good boy? 🐶" wire:model="is_good_boy" />
        <flux:input label="Birthday" icon="cake" wire:model="birthday" type='date' />
        <flux:button wire:click="save">保存</flux:button>
    </div>

    <div class="max-w-3xl mx-auto border rounded-md space-y-4 p-4 m-4">
        <h2 class="text-2xl font-semibold ">Index</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($sandboxes as $sandbox)
                <div wire:key="sandbox-{{ $sandbox->id }}" class="bg-gray-100 rounded-lg p-4 shadow space-y-2">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-500">
                            {{ $sandbox->name }}
                        </h3>

                        @if($sandbox->is_good_boy)
                            <span class="text-green-600 text-sm">Good Boy 🐶</span>
                        @else
                            <span class="text-gray-400 text-sm">Devil 👿</span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600">
                        🎂 {{ $sandbox->birthday?->format('Y-m-d') ?? 'Unknown' }}
                    </p>

                    <span class="inline-block text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                        mood: {{ $sandbox->mood }}
                    </span>
                </div>
            @empty
                <p>No data</p>
            @endforelse
        </div>
    </div>
</div>
