<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'name',
        'description',
        'has_input_box',
        'active',
    ];

    public function register_customers(): HasMany
    {
        return $this->hasMany(RegisterCustomer::class);
    }
}
