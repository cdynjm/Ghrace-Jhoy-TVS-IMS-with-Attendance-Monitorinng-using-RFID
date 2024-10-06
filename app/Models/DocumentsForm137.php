<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DocumentsForm137 extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documents_form137';

    protected $fillable = [
        'studentID',
        'filename',
    ];
}
