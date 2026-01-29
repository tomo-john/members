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

        <div>
            @forelse($sandboxes as $sandbox)
                <p>{{ $sandbox->name }} / {{ $sandbox->is_good_boy }} / {{ $sandbox->birthday }} / {{ $sandbox->mood }}</p>
            @empty
                <p>No data</p>
            @endforelse
        </div>
    </div>
</div>
