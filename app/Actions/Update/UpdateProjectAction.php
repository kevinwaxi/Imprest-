<?php

declare(strict_types=1);

namespace App\Actions\Update;

use Illuminate\Support\Facades\DB;

final readonly class UpdateProjectAction
{
    /**
     * Execute the action.
     */
    public function execute($data): void
    {
        DB::transaction(function ()use($data): void {
            //
        });
    }
}
