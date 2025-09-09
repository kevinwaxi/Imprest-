<?php

declare (strict_types = 1);

namespace App\Actions\Store;

use App\Models\Staff;
use Illuminate\Support\Facades\DB;

readonly class StoreStaffAction
{
    /**
     * Execute the action.
     */
    final public function execute($data): void
    {
        DB::transaction(function () use ($data): void {
            Staff::create([
                'staff_number' => $data['staff_number'],
                'name'         => $data['name'],
                'phone'        => $data['phone'],
                'is_active'    => $data['is_active'],
                'created_by'   => auth()->id(),
                'updated_by'   => auth()->id(),
            ]);
        });
    }
}
