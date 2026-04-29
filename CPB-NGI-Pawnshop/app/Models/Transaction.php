<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\Auditable;

class Transaction extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'transaction_number',
        'type',
        'user_id',
        'total_amount',
        'notes',
        'transaction_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'transaction_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method - auto-generate transaction number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->transaction_number) {
                // Generate transaction number like TRN-2026-04-28-001
                $date = now()->format('Y-m-d');
                $count = static::whereDate('created_at', now())->count() + 1;
                $model->transaction_number = 'TRN-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Get the user who created this transaction
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this transaction
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Get type label for display
     */
    public function getTypeLabel(): string
    {
        return match($this->type) {
            'SALE' => 'Sale',
            'DISTRIBUTION' => 'Distribution',
            'RETURN' => 'Return',
            default => $this->type,
        };
    }

    /**
     * Add item to transaction
     */
    public function addItem($productId, $quantity, $unitPrice)
    {
        $subtotal = $quantity * $unitPrice;

        TransactionItem::create([
            'transaction_id' => $this->id,
            'product_id' => $productId,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
        ]);

        // Update total amount
        $this->total_amount += $subtotal;
        $this->save();

        // Deduct from stock
        $product = Product::find($productId);
        $product->removeStock($quantity, $this->user_id, "Sold via transaction {$this->transaction_number}");

        return $this;
    }

    /**
     * Calculate total from items
     */
    public function calculateTotal()
    {
        $this->total_amount = $this->items()->sum('subtotal');
        $this->save();
        return $this->total_amount;
    }
}
