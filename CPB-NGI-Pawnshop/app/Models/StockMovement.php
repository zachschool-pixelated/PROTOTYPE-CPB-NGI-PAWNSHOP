<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'user_id',
        'supplier_id',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product this movement is for
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who made this movement
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the supplier (if applicable)
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get type label for display
     */
    public function getTypeLabel(): string
    {
        return match($this->type) {
            'IN' => 'Stock In',
            'OUT' => 'Stock Out',
            'ADJUSTMENT' => 'Adjustment',
            default => $this->type,
        };
    }
}
