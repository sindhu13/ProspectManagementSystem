<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Stock;
use App\models\Prospect;

class Color extends Model
{
    public function stock()
    {
        return $this->hasMany('App\Stock');
    }

    public function prospect()
    {
        return $this->hasMany('App\Prospect');
    }
}
