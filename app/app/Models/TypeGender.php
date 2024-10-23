<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeGender extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'name',
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }
}
