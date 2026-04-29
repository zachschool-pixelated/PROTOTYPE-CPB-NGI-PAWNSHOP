<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Loan extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'loan_number',
        'customer_id',
        'user_id',
        'loan_amount',
        'interest_rate',
        'loan_duration_days',
        'loan_date',
        'due_date',
        'redemption_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'loan_amount' => 'decimal:2',
        'interest_rate' => 'decimal:5,2',
        'loan_date' => 'datetime',
        'due_date' => 'datetime',
        'redemption_date' => 'datetime',
    ];

    /**
     * Boot method - auto-generate loan number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->loan_number) {
                // Generate loan number like LN-2026-04-28-001
                $date = now()->format('Y-m-d');
                $count = static::whereDate('created_at', now())->count() + 1;
                $model->loan_number = 'LN-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
            }

            // Set due date if not set
            if (!$model->due_date && $model->loan_date) {
                $model->due_date = $model->loan_date->addDays($model->loan_duration_days ?? 30);
            }
        });
    }

    /**
     * Get the customer for this loan
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user (staff) who created this loan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this loan
     */
    public function items()
    {
        return $this->hasMany(LoanItem::class);
    }

    /**
     * Get all payments for this loan
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Calculate total interest for this loan
     */
    public function calculateInterest()
    {
        return $this->loan_amount * ($this->interest_rate / 100);
    }

    /**
     * Calculate total amount due (principal + interest)
     */
    public function getTotalDueAttribute()
    {
        return $this->loan_amount + $this->calculateInterest();
    }

    /**
     * Get total paid
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }

    /**
     * Get remaining balance
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->total_due - $this->total_paid;
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'active' => 'Active',
            'paid' => 'Paid',
            'forfeited' => 'Forfeited',
            'cancelled' => 'Cancelled',
            default => $this->status,
        };
    }
}
