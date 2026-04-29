<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Customer extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'id_number',
        'id_type',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all loans for this customer
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Get total loan amount for this customer
     */
    public function getTotalLoanAmountAttribute()
    {
        return $this->loans()->where('status', 'active')->sum('loan_amount');
    }

    /**
     * Get active loans count
     */
    public function getActiveLoanCountAttribute()
    {
        return $this->loans()->where('status', 'active')->count();
    }
}
