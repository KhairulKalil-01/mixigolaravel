<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientPatientRelationship extends Pivot
{

    protected $table = 'client_patient_relationship';

    protected $guarded = [];
    public $timestamps = true;

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
