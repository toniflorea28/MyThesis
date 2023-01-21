<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QAndA extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'qanda';
    protected $primaryKey = 'id';
    public $incrementing = true;
}
