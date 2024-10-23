<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'name',
        'active',
    ];

    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }
}
