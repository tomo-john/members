<?php

use Livewire\Component;
use App\Models\Sandbox;

new class extends Component
{
    public $sandboxId;
    public $scheduledAt;

    public function updatedSandboxId()
    {
        $sandbox = Sandbox::find($this->sandboxId);
        $this->scheduledAt = $sandbox?->scheduled_at;
    }
};

?>

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium">Snadbox ID</label>
        <input type="number"
               wire:model.live.number="sandboxId"
               class="border rounded px-3 py-2 w-full"
               placehokder="IDを入力">
    </div>

    @if($scheduledAt)
        <div class="text-sm">
            <p>scheduled_at</p>
            <p class="font-semibold">
                {{ $scheduledAt->translatedFormat('Y年m月d日 H:i') }}
            </p>
            <p class="text-xs text-gray-500">
                {{ $scheduledAt->diffForHumans() }}
            </p>
        </div>
    @else
        <p class="text-sm text-gray-400">
            データはありません
            <i class="fa-solid fa-dog"></i>
        </p>
    @endif
</div>
