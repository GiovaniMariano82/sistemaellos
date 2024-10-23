<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'name',
        'description',
        'type_room_id',
        'customer_limit',
        'active',
    ];

    public function type_room(): BelongsTo
    {
        return $this->belongsTo(TypeRoom::class, 'type_room_id', 'id');
    }
}
