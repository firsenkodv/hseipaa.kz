<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleEnrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Имя'     => ['required', 'string', 'min:2', 'max:100'],
            'Телефон' => ['required', 'string', 'min:6', 'max:30'],
            'Email'   => ['required', 'email', 'min:4', 'max:100'],
            'Курс'      => ['nullable', 'string', 'max:255'],
            'Стоимость' => ['nullable', 'string', 'max:100'],
            'Дата'      => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'Имя.required'     => 'Необходимо ввести имя.',
            'Имя.min'          => 'Минимальная длина имени — :min символа.',
            'Телефон.required' => 'Необходимо ввести номер телефона.',
            'Телефон.min'      => 'Минимальная длина телефона — :min символов.',
            'Email.required'   => 'Электронная почта обязательна.',
            'Email.email'      => 'Введите корректный email.',
        ];
    }
}
