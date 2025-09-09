<?php

declare (strict_types = 1);

namespace App\Actions\Store;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

readonly class StoreDepartmentAction
{
    /**
     * Execute the action.
     */
    final public function execute($data): void
    {
        DB::transaction(function () use ($data): void {
            Department::create([
                'code'        => $data['code'],
                'name'        => $data['name'],
                'description' => $data['description'],
                'is_active'   => $data['is_active'],
                'created_by'  => auth()->id(),
                'updated_by'  => auth()->id(),
            ]);
        });
    }
}
