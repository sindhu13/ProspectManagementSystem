<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Employee;

class Departement extends Model
{
    public function employee()
    {
        return $this->hasMany('App\Employee');
    }
}
