<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Stock;

class Position extends Model
{
    public function stock()
    {
        return $this->hasMany('App\Stock');
    }
}
