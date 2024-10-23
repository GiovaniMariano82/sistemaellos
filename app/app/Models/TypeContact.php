<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeContact extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'name',
    ];

    public function customer_contacts(): HasMany
    {
        return $this->hasMany(CustomerContacts::class);
    }

    public function provider_contacts(): HasMany
    {
        return $this->hasMany(ProviderContacts::class);
    }
}
