<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'name',
        'acronym',
        'multiplier',
        'active',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
