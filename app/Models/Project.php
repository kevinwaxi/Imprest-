<?php

namespace App\Models;

use App\Traits\HasAuditFields;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasAuditFields, HasUUID;
    protected $guarded = [];

    protected $casts = [
        'is_active'  => 'boolean',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function warrants(): HasMany
    {
        return $this->hasMany(Warrant::class);
    }

}
