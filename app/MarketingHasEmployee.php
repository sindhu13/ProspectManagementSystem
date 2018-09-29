<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\MarketingGroup;
use App\models\Employee;
use App\models\Prospect;
use App\models\Target;

class MarketingHasEmployee extends Model
{
    public function marketingGroup()
    {
        return $this->belongsTo('App\MarketingGroup');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function prospect()
    {
        return $this->hasMany('App\Prospect');
    }

    public function target()
    {
        return $this->hasMany('App\Target');
    }
}
