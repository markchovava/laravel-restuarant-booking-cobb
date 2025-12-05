<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * 
     * 
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'locationId' => $this->locationId,
            'tableId' => $this->tableId,
            'scheduleId' => $this->scheduleId,
            'scheduleBookingId' => $this->scheduleBookingId,
            'locationName' => $this->locationName,
            'tableName' => $this->tableName,
            'quantity' => $this->quantity,
            'taken' => $this->taken,
            'date' => $this->date,
            'time' => $this->time,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'scheduleBooking' => new ScheduleBookingResource($this->whenLoaded('scheduleBooking')),
            'table' => new TableResource($this->whenLoaded('table')),
            'schedule' => new ScheduleResource($this->whenLoaded('schedule')),
        ];
    }
}
