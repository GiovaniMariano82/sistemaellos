<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderContacts extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "type_contact_id",
        "provider_id",
        "contactName",
        "contact",
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function type_contact(): BelongsTo
    {
        return $this->belongsTo(TypeContact::class, 'type_contact_id', 'id');
    }
}
