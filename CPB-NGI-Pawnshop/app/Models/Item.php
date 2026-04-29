<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Item extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'item_code',
        'name',
        'description',
        'category_id',
        'safe_id',
        'appraised_value',
        'condition',
        'location',
        'notes',
        'is_available',
    ];

    protected $casts = [
        'appraised_value' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the category this item belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the safe this item is stored in
     */
    public function safe()
    {
        return $this->belongsTo(Safe::class);
    }

    /**
     * Get all loan items for this item
     */
    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }

    /**
     * Get all loans this item is part of
     */
    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'loan_items')
                    ->withPivot('appraised_value', 'quantity', 'notes')
                    ->withTimestamps();
    }

    /**
     * Get the latest loan this item is part of
     */
    public function getLatestLoanAttribute()
    {
        return $this->loans()->latest('loans.created_at')->first();
    }
}
