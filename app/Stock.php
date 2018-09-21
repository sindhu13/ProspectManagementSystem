<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Unit;
use App\models\Position;
use App\models\Color;
use App\models\Branch;
use App\models\ProspectActivity;

class Stock extends Model
{
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function position()
    {
        return $this->belongsTo('App\Position');
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function stockStatusl()
    {
        return $this->belongsTo('App\StockStatus', 'id', 'status_id');
    }

    public function stockStatusr()
    {
        return $this->belongsTo('App\StockStatus', 'id', 'last_status_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function prospectActivity()
    {
        return $this->hasMany('App\ProspectActivity');
    }
}
