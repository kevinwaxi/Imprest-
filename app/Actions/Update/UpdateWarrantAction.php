<?php

declare (strict_types = 1);

namespace App\Actions\Update;

use App\Models\Warrant;
use Illuminate\Support\Facades\DB;

readonly class UpdateWarrantAction
{
    /**
     * Execute the action.
     */
    final public function execute(array $data, Warrant $warrant): void
    {
        DB::transaction(function () use ($data, $warrant): void {
            $warrant->update([
                'doc_number'           => $data['doc_number'],
                'staff_id'             => $data['staff_id'],
                'account_id'           => $data['account_id'],
                'department_id'        => $data['department_id'],
                'project_id'           => $data['project_id'],
                'prepared_by'          => $data['prepared_by'],
                'checked_by'           => $data['checked_by'],
                'approved_by'          => $data['approved_by'],
                'signed_by'            => $data['signed_by'],
                'amount'               => $data['amount'],
                'purpose'              => $data['purpose'],
                'remarks'              => $data['remarks'],
                'payee_bank'           => $data['payee_bank'],
                'payee_account_number' => $data['payee_account_number'],
                'paying_bank'          => $data['paying_bank'],
                'cheque_number'        => $data['cheque_number'],
                'memo_number'          => $data['memo_number'],
                'payment_date'         => $data['payment_date'],
                'signed_date'          => $data['signed_date'],
                'status'               => $data['status'],
                'status_remarks'       => $data['status_remarks'],
                'updated_by'           => auth()->id(),
            ]);
        });
    }
}
