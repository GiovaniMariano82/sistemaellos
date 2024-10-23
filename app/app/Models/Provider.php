<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "fullName",
        "socialName",
        "type_document_id",
        "documentNumber",
        "birthDate",
        "postalCode",
        "address",
        "addressNumber",
        "complement",
        "neighborhood",
        "city",
        "state",
        "status_id",
        "origin",
        "observation",
        "photo",
        "type_gender_id",
        "type_provider_id",
    ];

    public function getDocumentNumberAttribute($document_number)
    {
        switch ($this->type_document->id) {
            case 1:
                return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/','$1.$2.$3-$4', $document_number);
            case 2:
                return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/','$1.$2.$3/$4-$5', $document_number);
            default:
                return $document_number;
        }
    }

    public function setDocumentNumberAttribute($document_number)
    {
        $this->attributes['documentNumber'] = preg_replace("/[^0-9]/", "", $document_number);
    }

    public function getPostalCodeAttribute($postal_code)
    {
        return preg_replace('/(\d{2})(\d{3})(\d{3})/','$1.$2-$3', $postal_code);
    }

    public function setPostalCodeAttribute($postal_code)
    {
        $this->attributes['postalCode'] = preg_replace("/[^0-9]/", "", $postal_code);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function type_document(): BelongsTo
    {
        return $this->belongsTo(TypeDocument::class, 'type_document_id', 'id');
    }

    public function type_gender(): BelongsTo
    {
        return $this->belongsTo(TypeGender::class, 'type_gender_id', 'id');
    }

    public function type_provider(): BelongsTo
    {
        return $this->belongsTo(TypeProvider::class, 'type_provider_id', 'id');
    }

    public function provider_contacts(): HasMany
    {
        return $this->hasMany(ProviderContacts::class, 'provider_id');
    }

    public function register_customers(): HasMany
    {
        return $this->hasMany(RegisterCustomer::class, 'provider_id');
    }
}
