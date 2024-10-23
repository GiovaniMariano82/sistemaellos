<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';

    protected $fillable = [
        "id",
        "name",
        "description",
        "unit_id",
        "price",
        "slug",
        "active",
    ];

    public function getPriceAttribute($price)
    {
        return number_format($price / 100, 2, ',', '.');
    }

    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = ((float) str_replace(['.',','],['','.'], $price)) * 100;
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function register_customers(): HasMany
    {
        return $this->hasMany(RegisterCustomer::class, 'service_id');
    }
}
