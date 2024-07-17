<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $table = 'personal_access_tokens';

    public function User() {
        return $this->hasOne(User::class, 'id', 'tokenable_id');
    }
}
