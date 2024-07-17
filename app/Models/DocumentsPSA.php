<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsPSA extends Model
{
    use HasFactory;

    protected $table = 'documents_psa';

    protected $fillable = [
        'studentID',
        'filename',
    ];
}
