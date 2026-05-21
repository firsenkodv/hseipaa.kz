<?php

declare(strict_types=1);

namespace App\Http\Controllers\FancyBox;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Training;
use Illuminate\Http\Request;

class FancyBoxController extends Controller
{
    public function fancybox(Request $request)
    {
        if ($request->template === 'test') {
            return view('fancybox.forms.test');
        }

        if ($request->template === 'advantages') {
            return view('fancybox.forms.advantages');
        }

        if ($request->template === 'consult_me') {
            return view('fancybox.forms.consult_me');
        }

        if ($request->template === 'record_me') {
            return view('fancybox.forms.record_me', [
                'trainings' => Training::published()->get(['id', 'title']),
                'cities'    => City::published()->get(['id', 'title']),
            ]);
        }

        if ($request->template === 'schedule_enroll') {
            $data = json_decode($request->data ?? '{}', true) ?? [];
            return view('fancybox.forms.schedule_enroll', [
                'course' => $data['course'] ?? null,
                'price'  => $data['price']  ?? null,
                'date'   => $data['date']   ?? null,
            ]);
        }

        return view('fancybox.forms.error.error_form');
    }
}
