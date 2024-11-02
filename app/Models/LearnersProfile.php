<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LearnersProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'learners_profile';

    protected $fillable = [
        'IDpicture',
        'ULI',
        'RFID',
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
        'parentContact',
        'parentAddress',
        'consent',
        'picture',
        'dateAccomplished',
        'registrar',
        'dateReceived',
        'exam',
        'interview',
        'secondInterview',
        'admission_status',
        'status',
        'failed',
        'progress',
        'yearLevel',
        'semester',
        'enrollmentStatus',
        'freshmen',
        'diploma',
        'dateGraduated',
        'graduateEmploymentStatus',
        'company',
        'dateHired'
        
    ];

    public function User() {
        return $this->hasOne(User::class, 'studentID', 'id')->withTrashed();
    }

    public function LearnersCourse() {
        return $this->hasOne(LearnersCourse::class, 'studentID', 'id')->withTrashed();
    }

    public function Region() {
        return $this->hasOne(Region::class, 'regCode', 'region')->withTrashed();
    }
    public function Province() {
        return $this->hasOne(Province::class, 'provCode', 'province')->withTrashed();
    }
    public function Municipal() {
        return $this->hasOne(Municipal::class, 'citymunCode', 'city')->withTrashed();
    }
    public function Barangay() {
        return $this->hasOne(Barangay::class, 'brgyCode', 'barangay')->withTrashed();
    }

    public function BirthRegion() {
        return $this->hasOne(Region::class, 'regCode', 'birthplaceRegion')->withTrashed();
    }
    public function BirthProvince() {
        return $this->hasOne(Province::class, 'provCode', 'birthplaceProvince')->withTrashed();
    }
    public function BirthMunicipal() {
        return $this->hasOne(Municipal::class, 'citymunCode', 'birthplaceCity')->withTrashed();
    }

    public function studentYearLevels()
    {
        return $this->hasMany(StudentYearLevel::class, 'studentID', 'id')->withTrashed();
    }
}
