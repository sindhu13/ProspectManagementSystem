<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Unit;

class UnitModel extends Model
{
    public function unit()
    {
        return $this->hasMany('App\Unit');
    }
}
