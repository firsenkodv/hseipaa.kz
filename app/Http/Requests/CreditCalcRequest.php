<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditCalcRequest extends FormRequest
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

            'Банк'                => ['nullable', 'string', 'max:100'],
            'Курс'                => ['nullable', 'string', 'max:200'],
            'Сумма'               => ['nullable', 'string', 'max:50'],
            'Срок'                => ['nullable', 'string', 'max:50'],
            'Ежемесячный платёж'  => ['nullable', 'string', 'max:50'],
            'Переплата'           => ['nullable', 'string', 'max:50'],
            'Итого'               => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'ФИО.required'     => 'Необходимо ввести ФИО.',
            'ФИО.min'          => 'Минимальная длина имени — :min символа.',
            'ФИО.max'          => 'Максимальная длина имени — :max символов.',
            'Телефон.required' => 'Необходимо ввести номер телефона.',
            'Телефон.min'      => 'Минимальная длина телефона — :min символов.',
            'Телефон.max'      => 'Максимальная длина телефона — :max символов.',
            'Email.required'   => 'Электронная почта обязательна.',
            'Email.email'      => 'Введите корректный email.',
            'Email.min'        => 'Минимальная длина email — :min символа.',
            'Email.max'        => 'Максимальная длина email — :max символов.',
        ];
    }
}
