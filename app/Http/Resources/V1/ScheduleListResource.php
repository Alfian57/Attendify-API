<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleListResource extends JsonResource
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
            'teacher' => $this->teacher->name,
            'subject' => $this->subject->name,
            'classroom' => $this->classroom->name,
            'day' => $this->day,
            'time_start' => $this->time_start,
            'time_finish' => $this->time_finish,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
