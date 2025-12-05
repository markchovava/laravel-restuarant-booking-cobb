<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'userId' => $this->userId,
            'locationId' => $this->locationId,
            'locationName' => $this->locationName,
            'status' => $this->status,
            'date' => $this->date,
            'time' => $this->time,
            'description' => $this->description,
            'tablesTotal' => $this->tablesTotal,
            'tablesTaken' => $this->tablesTaken,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
