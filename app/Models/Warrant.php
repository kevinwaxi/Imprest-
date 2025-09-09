<?php

namespace App\Models;

use App\Enums\WarrantStatus;
use App\Traits\HasAuditFields;
use App\Traits\HasSecondaryUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warrant extends Model
{
    use HasSecondaryUUID, HasAuditFields;
    protected $fillable = [
        'uuid',
        'doc_number',
        'staff_id',
        'account_id',
        'department_id',
        'project_id',
        'prepared_by',
        'checked_by',
        'approved_by',
        'signed_by',
        'amount',
        'purpose',
        'remarks',
        'payee_bank',
        'payee_account_number',
        'paying_bank',
        'cheque_number',
        'memo_number',
        'payment_date',
        'signed_date',
        'status',
        'status_remarks',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'amount'       => 'decimal:2',
        'payment_date' => 'date',
        'signed_date'  => 'date',
        'status'       => WarrantStatus::class,
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function checkedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function signedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(WarrantLog::class);
    }

    public static function generateNextDocNumber(): string
    {
        // Get the latest warrant by doc_number
        $last = self::orderByDesc('id')->first();

        if (!$last || !preg_match('/^IW(\d+)$/', $last->doc_number, $matches)) {
            return 'IW001'; // start if none exist
        }

        $nextNumber = (int) $matches[1] + 1;

        return 'IW' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

}
