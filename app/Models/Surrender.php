<?php

namespace App\Models;

use App\Observers\SurrenderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([SurrenderObserver::class])]
class Surrender extends Model
{
    protected $guarded = [];

    protected $casts = [
        'imprest_amount' => 'decimal:2',
        'actual_spent'   => 'decimal:2',
    ];

    public function warrant(): BelongsTo
    {
        return $this->belongsTo(Warrant::class);
    }
}
