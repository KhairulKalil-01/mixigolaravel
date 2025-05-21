<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function clientRelationships()
    {
        return $this->hasMany(ClientPatientRelationship::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_patient_relationship')->using(ClientPatientRelationship::class);;
    }
}
