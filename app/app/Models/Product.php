<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "description",
        "price",
        "amount",
        "slug",
        "photo",
        "maximum_amount",
        "minimum_amount",
        "active",
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getPriceAttribute($price)
    {
        return number_format($price / 100, 2, ',', '.');
    }

    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = ((float) str_replace(['.',','],['','.'], $price)) * 100;
    }
}
