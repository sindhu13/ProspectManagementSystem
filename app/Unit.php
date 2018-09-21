<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\UnitModel;
use App\models\Stock;
use App\models\Prospect;

class Unit extends Model
{
    public function unitModel()
    {
        return $this->belongsTo('App\UnitModel');
    }

    public function stock()
    {
        return $this->hasMany('App\Stock');
    }

    public function prospect()
    {
        return $this->hasMany('App\Prospect');
    }
}
