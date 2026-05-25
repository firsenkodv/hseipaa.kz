<?php

namespace App\Http\Controllers\Axios;

use App\Http\Controllers\Controller;
use App\Http\Requests\CallMeBlueRequest;
use App\Http\Requests\ConsultMeRequest;
use App\Http\Requests\ProgramEnrollRequest;
use App\Http\Requests\RecordMeRequest;
use App\Http\Requests\ScheduleEnrollRequest;
use App\Jobs\Form\CallMeBlueJob;
use App\Jobs\Form\ConsultMeJob;
use App\Jobs\Form\ProgramEnrollJob;
use App\Jobs\Form\RecordMeJob;
use App\Jobs\Form\ScheduleEnrollJob;
use Illuminate\Http\Request;

class AxiosController extends Controller
{
    public function async(Request $request)
    {
        if ($request->template === 'call_me_blue') {
            return view('axios.forms.call_me_blue');
        }

        return view('axios.forms.error.error_form');
    }

    public function callMeBlue(CallMeBlueRequest $request)
    {
        $data = [
            'ФИО'     => $request->input('ФИО'),
            'Телефон' => $request->input('Телефон'),
            'Email'   => $request->input('Email'),
        ];

        CallMeBlueJob::dispatch($data);

        return response()->json(['response' => 'ok']);
    }

    public function consultMe(ConsultMeRequest $request)
    {
        $data = [
            'Имя'     => $request->input('Имя'),
            'Телефон' => $request->input('Телефон'),
            'Email'   => $request->input('Email'),
        ];

        ConsultMeJob::dispatch($data);

        return response()->json(['response' => 'ok']);
    }

    public function recordMe(RecordMeRequest $request)
    {
        $data = array_filter([
            'Тип'           => $request->input('Тип'),
            'Компания'      => $request->input('Компания'),
            'ФИО'           => $request->input('ФИО'),
            'Телефон'       => $request->input('Телефон'),
            'Email'         => $request->input('Email'),
            'Город'         => $request->input('Город'),
            'Курс'          => $request->input('Курс'),
            'Дата отправки' => now()->format('d.m.Y H:i'),
        ]);

        RecordMeJob::dispatch($data);

        return response()->json(['response' => 'ok']);
    }

    public function scheduleEnroll(ScheduleEnrollRequest $request)
    {
        $data = array_filter([
            'Курс'           => $request->input('Курс'),
            'Стоимость'      => $request->input('Стоимость'),
            'Дата'           => $request->input('Дата'),
            'Имя'            => $request->input('Имя'),
            'Телефон'        => $request->input('Телефон'),
            'Email'          => $request->input('Email'),
            'Дата отправки'  => now()->format('d.m.Y H:i'),
        ]);

        ScheduleEnrollJob::dispatch($data);

        return response()->json(['response' => 'ok']);
    }

    public function programEnroll(ProgramEnrollRequest $request)
    {
        $data = array_filter([
            'Имя'      => $request->input('Имя'),
            'Телефон'  => $request->input('Телефон'),
            'Email'    => $request->input('Email'),
            'Страница' => $request->input('Страница'),
        ]);

        ProgramEnrollJob::dispatch($data);

        return response()->json(['response' => 'ok']);
    }
}
