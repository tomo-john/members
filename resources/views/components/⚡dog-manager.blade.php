<?php

use Livewire\Component;

new class extends Component
{
    public $name;
    public $birthday;
    public $is_good_boy;

    public function save()
    {
        dd($this->name);
    }
};
?>

<div>
    <h2>Hello🐶</h2>
    <p><i class="fa-solid fa-dog"></i></p>
    <flux:input label="Dog name" wire:model="name" />
    <flux:button wire:click="save">保存</flux:button>
</div>
