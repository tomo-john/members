<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sandbox as SandboxModel;

class Sandbox extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.sandbox');
    }
}
