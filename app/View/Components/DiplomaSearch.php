<?php

namespace App\View\Components;

use App\Models\Diploma;
use Illuminate\View\Component;
use Illuminate\View\View;

class DiplomaSearch extends Component
{
    public ?string  $number   = null;
    public bool     $searched = false;
    public ?Diploma $diploma  = null;
    public ?string  $title      = null;
    public ?string  $short_desc = null;
    public ?string  $desc       = null;

    public function __construct(object $page)
    {
        $this->title      = $page->title      ?? null;
        $this->short_desc = $page->short_desc ?? null;
        $this->desc       = $page->desc       ?? null;

        $raw = request('number');

        if ($raw !== null && trim($raw) !== '') {
            $this->number   = trim($raw);
            $this->searched = true;
            $this->diploma  = Diploma::where('title', $this->number)
                ->where('published', 1)
                ->first();
        }
    }

    public function render(): View
    {
        return view('components.diploma-search');
    }
}
