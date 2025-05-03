<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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

    public function rules()
    {
        return [
            'current_password' => 'required|string|min:6', // Customize these validation rules
            'password' => 'required|string|min:6|confirmed', // confirmed will ensure password_confirmation is checked
            'password_confirmation' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => __('validation.required_current_password'),
            'current_password.string' => __('validation.string_current_password'),
            'current_password.min' => __('validation.min_current_password'),
            'password.string' => __('validation.string_password'),
            'password.min' => __('validation.min_password'),
            'password.confirmed' => __('validation.confirmed_password'),
            'password_confirmation.string' => __('validation.string_password_confirmation'),
            'password_confirmation.min' => __('validation.min_password_confirmation'),
            'password_confirmation.required' => __('validation.required_password_confirmation'),
        ];
    }
}
