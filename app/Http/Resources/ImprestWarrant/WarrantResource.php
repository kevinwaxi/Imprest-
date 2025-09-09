<?php

namespace App\Http\Resources\ImprestWarrant;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarrantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'uuid'                 => $this->uuid,
            'doc_number'           => $this->doc_number,

            // Relationships
            'staff'                => $this->whenLoaded('staff', fn() => [
                'id'   => $this->staff->id,
                'name' => $this->staff->name,
            ]),

            'account'                => $this->whenLoaded('account', fn() => [
                'id'   => $this->account->id,
                'name' => $this->account->name,
            ]),

            'project'                => $this->whenLoaded('project', fn() => [
                'id'   => $this->project->id,
                'name' => $this->project->name,
            ]),

            // Workflow users
            'prepared_by'          => UserResource::make($this->preparedBy),
            'checked_by'           => UserResource::make($this->whenLoaded('checkedBy')),
            'approved_by'          => UserResource::make($this->whenLoaded('approvedBy')),
            'signed_by'            => UserResource::make($this->whenLoaded('signedBy')),

            // Financials
            'amount'               => (int)$this->amount,
            'purpose'              => $this->purpose,
            'remarks'              => $this->remarks,

            // Bank / Payment
            'payee_bank'           => $this->payee_bank,
            'payee_account_number' => $this->payee_account_number,
            'paying_bank'          => $this->paying_bank,
            'cheque_number'        => $this->cheque_number,
            'memo_number'          => $this->memo_number,
            'payment_date'         => $this->payment_date?->toDateString(),
            'signed_date'          => $this->signed_date?->toDateString(),

            // Status
            'status'               => $this->status,
            'status_remarks'       => $this->status_remarks,

            // Audit trail
            'created_by'           => $this->whenLoaded('creator', fn() => $this->creator?->only(['id', 'name'])),
            'updated_by'           => $this->whenLoaded('updater', fn() => $this->updater?->only(['id', 'name'])),

            'created_at'           => $this->created_at?->toDateTimeString(),
            'updated_at'           => $this->updated_at?->toDateTimeString(),
            'deleted_at'           => $this->deleted_at?->toDateTimeString(),
        ];
    }
}
