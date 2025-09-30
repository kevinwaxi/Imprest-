<?php

declare (strict_types = 1);

namespace App\Actions\Store;

use App\Models\Warrant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

readonly class StoreWarrantAction
{
    /**
     * Execute the action for multiple warrants.
     *
     * @param  array{warrants: array<int, array<string, mixed>>}  $data
     */
    final public function execute(array $data): void
    {
        $default = settings('authority');
        DB::transaction(function () use ($data, $default): void {
            foreach ($data['warrants'] as $warrantData) {
                Warrant::create([
                    'doc_number'           => $warrantData['doc_number'],
                    'staff_id'             => $warrantData['staff_id'],
                    'account_id'           => $warrantData['account_id'],
                    'department_id'        => $warrantData['department_id'] ?? null,
                    'project_id'           => $warrantData['project_id'] ?? null,
                    'prepared_by'          => $warrantData['prepared_by'] ?? null,
                    'checked_by'           => $default['examiner'],
                    'approved_by'          => $default['approver'],
                    'signed_by'            => $default['authorizer'],
                    'amount'               => $warrantData['amount'],
                    'purpose'              => $warrantData['purpose'] ?? null,
                    'remarks'              => $warrantData['remarks'] ?? null,
                    'payee_bank'           => $warrantData['payee_bank'] ?? null,
                    'payee_account_number' => $warrantData['payee_account_number'] ?? null,
                    'paying_bank'          => $warrantData['paying_bank'] ?? null,
                    'cheque_number'        => $warrantData['cheque_number'] ?? null,
                    'memo_number'          => $warrantData['memo_number'] ?? null,
                    'payment_date'         => $warrantData['payment_date'] ?? null,
                    'signed_date'          => $warrantData['signed_date'] ?? null,
                    'status'               => $warrantData['status'] ?? 'draft',
                    'status_remarks'       => $warrantData['status_remarks'] ?? null,
                    'created_by'           => Auth::id(),
                    'updated_by'           => Auth::id(),
                ]);
            }
        });
    }
}
