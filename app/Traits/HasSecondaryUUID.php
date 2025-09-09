<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSecondaryUUID
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model): void {
            $model->uuid = (string) Str::uuid7();
        });
    }
}
