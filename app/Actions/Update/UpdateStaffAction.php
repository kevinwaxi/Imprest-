<?php

declare (strict_types = 1);

namespace App\Actions\Update;

use Illuminate\Support\Facades\DB;

readonly class UpdateStaffAction
{
    /**
     * Execute the action.
     */
    final public function execute($data, $staff): void
    {
        DB::transaction(function () use ($data, $staff): void {
            $staff->update([
                'staff_number' => $data['staff_number'],
                'name'         => $data['name'],
                'phone'        => $data['phone'],
                'is_active'    => $data['is_active'],
                'updated_by'   => auth()->id(),
            ]);
        });
    }
}
