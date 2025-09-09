<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarrantLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'changes' => 'array',
    ];

    public function warrant(): BelongsTo
    {
        return $this->belongsTo(Warrant::class);
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
