<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\ValidationRequests;

class UserListingRequest extends ValidationRequests
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        
        return [
            'orderBy' => "in:ASC,DESC,asc,desc",
            'perPage' => 'numeric',
            'page' => 'numeric',
            'status' => 'string',
            'getAll' => 'boolean',
        ];
    }

}
