<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Inline extends Component
{
    public function render()
    {
        return <<<'blade'
            <div>
                <h2>Hello Component Inline</h2>
            </div>
        blade;
    }
}
