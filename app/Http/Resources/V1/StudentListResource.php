<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentListResource extends JsonResource
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
            'nisn' => $this->nisn,
            'name' => $this->name,
            'profile_picture' => $this->when($this->profile_picture, 'storage/'.$this->profile_picture),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
