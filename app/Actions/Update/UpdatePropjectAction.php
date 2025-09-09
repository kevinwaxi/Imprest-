<?php

declare(strict_types=1);

namespace App\Actions\Update;

use Illuminate\Support\Facades\DB;

final readonly class UpdatePropjectAction
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
