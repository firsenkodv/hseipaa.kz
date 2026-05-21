<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordMeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ФИО'     => ['required', 'string', 'min:2', 'max:100'],
            'Телефон' => ['required', 'string', 'min:6', 'max:30'],
            'Email'   => ['required', 'email', 'min:4', 'max:100'],
            'Курс'    => ['required', 'string', 'min:2', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'ФИО.required'     => 'Необходимо ввести ФИО.',
            'ФИО.min'          => 'Минимальная длина ФИО — :min символа.',
            'Телефон.required' => 'Необходимо ввести номер телефона.',
            'Телефон.min'      => 'Минимальная длина телефона — :min символов.',
            'Email.required'   => 'Электронная почта обязательна.',
            'Email.email'      => 'Введите корректный email.',
            'Курс.required'    => 'Выберите курс обучения.',
        ];
    }
}
