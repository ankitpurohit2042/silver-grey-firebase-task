<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ValidationRequests;
use DBTableNames;
use Illuminate\Support\Facades\Auth;

class UserProfileRequest extends ValidationRequests
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $default_max_value = 10 * 1024; //10mb
        return [
            'photo' => 'sometimes|max:' . $default_max_value . '|mimes:jpg,jpeg,png,gif',
            'first_name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/',
            'last_name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/',
            'mobile'=>'sometimes|digits_between:12,15|unique:users,mobile,'.Auth::user()->id.',id',
            'about_me' => 'sometimes|string|max:20'
        ];

    }

}
