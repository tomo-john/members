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
        <flux:input label="Name" icon="face-smile" wire:model.live.debounce.500ms="name" placeholder="じょん・どぅ" />
    </div>

    <div class="max-w-3xl mx-auto border rounded-md space-y-4 p-4 m-4">
        <h2 class="text-2xl font-semibold ">Test</h2>
        <flux:text class="mt-2">{{ $name }}</flux:text>
    </div>
</div>
