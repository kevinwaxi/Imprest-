<?php

namespace App\Observers;

use App\Models\Surrender;

class SurrenderObserver
{
    /**
     * Handle the Surrender "creating" event.
     */
    public function creating(Surrender $surrender): void
    {
        // Get the last record to determine the next number
        $lastNumber = Surrender::max('sequence_number'); // assuming you have this column

        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

        // Save both sequence number and formatted code
        $surrender->sequence_number = $nextNumber;
        $surrender->doc_code        = 'IS' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    }
    /**
     * Handle the Surrender "created" event.
     */
    public function created(Surrender $surrender): void
    {
        //
    }

    /**
     * Handle the Surrender "updated" event.
     */
    public function updated(Surrender $surrender): void
    {
        //
    }

    /**
     * Handle the Surrender "deleted" event.
     */
    public function deleted(Surrender $surrender): void
    {
        //
    }

    /**
     * Handle the Surrender "restored" event.
     */
    public function restored(Surrender $surrender): void
    {
        //
    }

    /**
     * Handle the Surrender "force deleted" event.
     */
    public function forceDeleted(Surrender $surrender): void
    {
        //
    }
}
