<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\ValidationRequests;

class ChangePasswordRequest extends ValidationRequests
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required',
            'password' => [
                'required',
                'min:6',
                'max:16',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/',
            ],
            'password_confirmation' => 'required|same:password',
        ];
    }

}
