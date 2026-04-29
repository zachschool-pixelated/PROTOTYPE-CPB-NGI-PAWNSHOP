<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Supplier extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'description',
        'contact_person',
        'email',
        'phone',
        'address',
    ];

    /**
     * Get all stock movements from this supplier
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
