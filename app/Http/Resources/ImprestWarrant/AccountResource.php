<?php

namespace App\Http\Resources\ImprestWarrant;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'name'        => $this->name,
            'description' => $this->description,
            'is_active'   => $this->is_active,
            'balance'     => $this->balance,
            'created_by'  => UserResource::make($this->whenLoaded('creator')),
            'updated_by'  => UserResource::make($this->whenLoaded('updator')),
            'created_at'  => $this->created_at?->diffForHumans(),
            'updated_at'  => $this->updated_at?->diffForHumans(),
        ];
    }
}
