<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\View;

class RecordForm extends Component
{
    public function render(): View
    {
        return view('components.form.record-form');
    }
}
