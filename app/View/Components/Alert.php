<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $type='success')
    {
        //
    }

    /**
     * Rufen Sie die Ansicht/den Inhalt ab, der die Komponente darstellt.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert',[
            'prefix' => ($this->type == 'success') ? 'Success :' : 'echec :'
        ]);
    }
}
