<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'phone_number' => $this->phone_number,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'is_married' => $this->is_married,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
