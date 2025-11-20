<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    public function patientRelationships()
    {
        return $this->hasMany(ClientPatientRelationship::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'client_patient_relationship')->using(ClientPatientRelationship::class);;
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function prepaidRecords()
    {
        return $this->hasMany(PrepaidRecord::class);
    }
}
