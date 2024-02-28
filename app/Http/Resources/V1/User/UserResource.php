<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    public function toArray($request) {
        return [
            'id' => encrypt($this->id),
            "name" => $this->name,
            "email" => $this->email,
            "created_at" => $this->created_at,
        ];
    }
}
