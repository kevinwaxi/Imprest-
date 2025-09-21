<?php

namespace App\Observers;

use App\Models\Surrender;
use App\Models\Warrant;

class WarrantObserver
{
    /**
     * Handle the Warrant "created" event.
     */
    public function created(Warrant $warrant): void
    {
        Surrender::create([
            'warrant_id'     => $warrant->id,
            'imprest_amount' => $warrant->amount,
            'actual_spent'   => $warrant->amount,
        ]);
    }

    /**
     * Handle the Warrant "updated" event.
     */
    public function updated(Warrant $warrant): void
    {
        //
    }

    /**
     * Handle the Warrant "deleted" event.
     */
    public function deleted(Warrant $warrant): void
    {
        //
    }

    /**
     * Handle the Warrant "restored" event.
     */
    public function restored(Warrant $warrant): void
    {
        //
    }

    /**
     * Handle the Warrant "force deleted" event.
     */
    public function forceDeleted(Warrant $warrant): void
    {
        //
    }
}
