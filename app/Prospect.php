<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Unit;
use App\models\Color;
use App\models\MarketingHasEmployee;
use App\models\ProspectActivity;

class Prospect extends Model
{
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function marketingHasEmployee()
    {
        return $this->belongsTo('App\MarketingHasEmployee');
    }

    public function prospectActivity()
    {
        return $this->hasMany('App\ProspectActivity', 'prospect_id', 'id')->orderBy('id', 'DESC');
    }
}
