<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipal extends Model
{
    use HasFactory;

    protected $table = 'municipal';

    protected $fillable = [
       'psgcCode',
       'citymunDesc',
       'regDesc',
       'provCode',
       'citymunCode'
    ];
}
