<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnersProfile extends Model
{
    use HasFactory;

    protected $table = 'learners_profile';

    protected $fillable = [
        'IDpicture',
        'ULI',
        'entryDate',
        'lastname',
        'firstname',
        'middlename',
        'region',
        'province',
        'city',
        'barangay',
        'district',
        'street',
        'account',
        'phone',
        'nationality',
        'sex',
        'civilStatus',
        'employmentStatus',
        'employmentType',
        'birthdate',
        'age',
        'birthplaceRegion',
        'birthplaceProvince',
        'birthplaceCity',
        'education',
        'parent',
        'parentAddress',
        'consent',
        'picture',
        'dateAccomplished',
        'registrar',
        'dateReceived',
        'exam',
        'interview',
        'admission_status',
        'status',
        
    ];

    public function Region() {
        return $this->hasOne(Region::class, 'regCode', 'region');
    }
    public function Province() {
        return $this->hasOne(Province::class, 'provCode', 'province');
    }
    public function Municipal() {
        return $this->hasOne(Municipal::class, 'citymunCode', 'city');
    }
    public function Barangay() {
        return $this->hasOne(Barangay::class, 'brgyCode', 'barangay');
    }

    public function BirthRegion() {
        return $this->hasOne(Region::class, 'regCode', 'birthplaceRegion');
    }
    public function BirthProvince() {
        return $this->hasOne(Province::class, 'provCode', 'birthplaceProvince');
    }
    public function BirthMunicipal() {
        return $this->hasOne(Municipal::class, 'citymunCode', 'birthplaceCity');
    }
}
