<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|string',
            'new_password' => 'required|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/|min:6|different:old_password',
            'new_password_confirmation' => 'required|same:new_password'
        ];
    }

    public function messages()
    {
        return [
            'new_password.regex' => 'Пароль должен содержать хотя бы одну цифру, одну строчную букву и одну заглавную',
            'new_password.different' => 'Старый и новый пароли не должны совпадать',
            'new_password_confirmation.same' => 'Пароли не совпадают',
        ];
    }
}
