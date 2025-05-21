<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientPatientRelationship extends Pivot
{

    protected $table = 'client_patient_relationship';

    protected $guarded = ['']; // adjust as per your columns

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
