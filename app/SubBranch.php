<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Branch;
use App\models\Employee;

class SubBranch extends Model
{
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function employee()
    {
        return $this->hasMany('App\Employee');
    }
}
