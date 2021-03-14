<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRworker extends Model
{
    use HasFactory;
    protected $table = 'hrworkers';
    protected $primaryKey = "id";
    public $timestamps = false;
}
