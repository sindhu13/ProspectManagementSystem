<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Employee;
use App\models\MarketingHasEmployee;

class MarketingGroup extends Model
{
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function marketingHasEmployee()
    {
        return $this->hasMany('App\MarketingHasEmployee');
    }
}
