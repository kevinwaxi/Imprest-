<?php

namespace App\Http\Resources\ImprestWarrant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurrenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'doc_code'        => $this->doc_code,
            'sequence_number' => $this->sequence_number,
            'warrant'         => WarrantResource::make($this->whenLoaded('warrant')),
            'imprest_amount'  => (int) $this->imprest_amount,
            'actual_spent'    => (int) $this->actual_spent,
            'examiner'        => $this->examination_by,
            'approver'        => $this->approved_by,
            'authorizer'      => $this->authorized_by,

        ];
    }
}
