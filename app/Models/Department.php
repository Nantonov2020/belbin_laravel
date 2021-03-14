<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    protected $primaryKey = "id";
    public $timestamps = false;

    public function company()
    {
        return $this->belongsTo('App\Models\Company','company_id','id');
    }

}
