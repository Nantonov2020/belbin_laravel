<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $primaryKey = "id";
    public $timestamps = false;

    public function departments()
    {
        return $this->hasMany('App\Models\Department','company_id','id');
    }


}
