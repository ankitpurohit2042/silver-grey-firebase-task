<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\ValidationRequests;

class ProfileRequest extends ValidationRequests
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => __('Please enter name'),
        ];
    }
}
