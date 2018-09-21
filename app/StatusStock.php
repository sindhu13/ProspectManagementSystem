<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Stock;

class StatusStock extends Model
{
    public function stockl()
    {
        return $this->belongsTo('App\Stock', 'status_id', 'id');
    }

    public function stockr()
    {
        return $this->belongsTo('App\Stock', 'last_status_id', 'id');
    }
}
