<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\SubBranch;
use App\models\Stock;
use App\models\Employee;

class Branch extends Model
{
    public function subBranch()
    {
        return $this->hasMany('App\SubBranch');
    }

    public function stock()
    {
        return $this->hasMany('App\Stock');
    }
}
