<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'bookingRef' => $this->bookingRef,
            'userId' => $this->userId,
            'locationId' => $this->locationId,
            'scheduleId' => $this->scheduleId,
            'tableId' => $this->tableId,
            'tableName' => $this->tableName,
            'fullName' => $this->fullName,
            'phone' => $this->phone,
            'email' => $this->email,
            'guests' => $this->guests,
            'date' => $this->date,
            'time' => $this->time,
            'notes' => $this->notes,
            'updatedAt' => $this->updated_at,
            'createdAt' => $this->created_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'schedule' => new ScheduleResource($this->whenLoaded('schedule')),
            'table' => new TableResource($this->whenLoaded('table')),
        ];
    }
}
