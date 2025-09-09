<?php

declare(strict_types=1);

namespace App\Actions\Store;

use Illuminate\Support\Facades\DB;

final readonly class StorePropjectAction
{
    /**
     * Execute the action.
     */
    public function execute(): void
    {
        DB::transaction(function (): void {
            //
        });
    }
}
