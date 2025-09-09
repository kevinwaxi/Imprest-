<?php

namespace App\Http\Resources\ImprestWarrant;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'staff_number' => $this->staff_number,
            'name'         => $this->name,
            'phone'        => $this->phone,
            'is_active'    => $this->is_active,
            'created_by'   => UserResource::make($this->whenLoaded('createdBy')),
            'updated_by'   => UserResource::make($this->whenLoaded('updatedBy')),
            'created_at'   => $this->created_at->diffForHumans(),
            'updated_at'   => $this->updated_at->diffForHumans(),
        ];
    }
}
