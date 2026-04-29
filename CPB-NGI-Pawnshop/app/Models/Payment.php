<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Payment extends Model
{
    use Auditable;

    protected $fillable = [
        'loan_id',
        'amount',
        'payment_method',
        'status',
        'notes',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Get the loan this payment belongs to
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
