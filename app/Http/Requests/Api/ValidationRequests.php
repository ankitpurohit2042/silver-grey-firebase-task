<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;


class ValidationRequests extends FormRequest
{
    
    protected function failedValidation(Validator $validator): ValidationException {
        $errors = $validator->errors()->getMessages();
        if (!empty($errors)) {
            foreach ($errors as $message) {
                    $message[0];
                break;
            }
        }

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
