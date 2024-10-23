<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegisterCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        'customer_id',
        'provider_id',
        'service_id',
        'duration',
        'start_date',
        'end_date',
        'amount_service',
        'discount_percent',
        'discount_value',
        'amount_to_pay',
        'split_pay',
        'amount_split_pay',
        'payment_method_id',
        'active',
        'observation'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
