<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChunkFileUploadInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $suffix = '1', public string $containerClass = '') {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chunk-file-upload-input');
    }
}
