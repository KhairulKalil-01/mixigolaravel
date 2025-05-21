<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function patientRelationships()
    {
        return $this->hasMany(ClientPatientRelationship::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'client_patient_relationship')->using(ClientPatientRelationship::class);;
    }
}
