<?php

namespace App\Models;

use App\Traits\HasAuditFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes, HasAuditFields;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function warrants(): HasMany
    {
        return $this->hasMany(Warrant::class);
    }

}
