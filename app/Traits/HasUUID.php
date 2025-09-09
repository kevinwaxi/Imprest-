<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUUID
{
    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model): void {
            $model->id = (string) Str::uuid();
        });
    }
}
