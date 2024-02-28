<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\ValidationRequests;

class RegisterRequest extends ValidationRequests
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
        $rules = [
            'name' => ['required', 'string', 'max:255', 'regex:/^[^\s]+(\s*[^\s]+)*$/'],
        ];

        if (request()->method() === 'PUT' || request()->method() === 'PATCH') {
            $id = decrypt($this->route()->parameter('user'));
            $rules = array_merge($rules, [
                'email' => [
                    'required', 'string', 'unique:users,email,' . $id . ',id',
                ],
            ]);
        } elseif (request()->method() === 'POST') {
            $rules = array_merge($rules, [
                'email' => ['required', 'string', 'email', 'unique:users'],
                'password' => ['required', 'min:8', 'max:16', 'regex:/^\S*$/u', 'regex:/^(?=.*?[0-9]).{6,}$/'],
                'password_confirmation' => ['required', 'max:16', 'same:password'],
            ]);
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.regex' => 'The name may not contain whitespace.',
            'password.regex' => 'The Password must contain at least one number. No spaces allowed.',
            'email.unique' => 'User already exist',
            'password_confirmation.required' => 'The Confirm password field is required.',
            'password_confirmation.same' => 'The Confirm password and password must match.',
        ];
    }
}
