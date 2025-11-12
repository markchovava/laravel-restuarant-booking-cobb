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
            'tableFloorPlanId' => $this->tableFloorPlanId,
            'date' => $this->date,
            'time' => $this->time,
            'status' => $this->status,
            'css' => $this->css,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'tableFloorPlan' => new TableFloorPlanResource($this->whenLoaded('table_floor_plan')),
        ];
        
    }
}
