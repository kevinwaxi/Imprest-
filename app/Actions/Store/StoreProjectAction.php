<?php

declare (strict_types = 1);

namespace App\Actions\Store;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

readonly class StoreProjectAction
{
    /**
     * Execute the action.
     */
    final public function execute($data): void
    {
        DB::transaction(function () use ($data): void {
            Project::create([
                'code'        => $data['code'],
                'name'        => $data['name'],
                'description' => $data['description'],
                // 'start_date'  => $data['start_date'],
                // 'end_date'    => $data['end_date'],
                'is_active'   => $data['is_active'],
                'created_by'  => auth()->id(),
                'updated_by'  => auth()->id(),
            ]);
        });
    }
}
