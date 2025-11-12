<?php

namespace App\Http\Resources;

use App\Models\TableFloorPlan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableBookingScheduleResource extends JsonResource
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
            'bookingRef' => $this->bookingRef,
            'tableFloorPlanId' => $this->tableFloorPlanId,
            'date' => $this->date,
            'time' => $this->time,
            'status' => $this->status,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'numberOfGuests' => $this->numberOfGuests,
            'phone' => $this->phone,
            'css' => $this->css,
            'notes' => $this->notes,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'tableFloorPlan' => new TableFloorPlanResource($this->whenLoaded('table_floor_plan')),
        ];
        
    }
}
