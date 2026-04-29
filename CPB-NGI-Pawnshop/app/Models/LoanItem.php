<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'item_id',
        'appraised_value',
        'quantity',
        'notes',
    ];

    protected $casts = [
        'appraised_value' => 'decimal:2',
    ];

    /**
     * Get the loan this item belongs to
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Get the item
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
