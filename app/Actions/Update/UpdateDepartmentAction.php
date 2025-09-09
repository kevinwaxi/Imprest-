<?php

declare (strict_types = 1);

namespace App\Actions\Update;

use Illuminate\Support\Facades\DB;

readonly class UpdateDepartmentAction
{
    /**
     * Execute the action.
     */
    final public function execute($data, $department): void
    {
        DB::transaction(function () use ($data, $department): void {
            $department->update([]);
        });
    }
}
