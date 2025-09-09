<?php

declare (strict_types = 1);

namespace App\Actions\Update;

use Illuminate\Support\Facades\DB;

readonly class UpdateAccountAction
{
    /**
     * Execute the action.
     */
    final public function execute($data, $account): void
    {
        DB::transaction(function () use ($data, $account): void {
            $account->update([
                'code'        => $data['data'],
                'name'        => $data['name'],
                'description' => $data['description'],
                'is_active'   => $data['is_active'],
                'updated_by'  => auth()->id(),
            ]);
        });
    }
}
