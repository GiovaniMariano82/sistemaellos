<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerContacts extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "type_contact_id",
        "customer_id",
        "contactName",
        "contact",
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function type_contact(): BelongsTo
    {
        return $this->belongsTo(TypeContact::class, 'type_contact_id', 'id');
    }
}
