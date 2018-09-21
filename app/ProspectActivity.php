<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Prospect;
use App\models\StatusProspect;
use App\models\Stock;

class ProspectActivity extends Model
{
    public function prospect()
    {
        return $this->belongsTo('App\Prospect', 'prospect_id')->orderBy('id', 'DESC');
    }

    public function statusProspect()
    {
        return $this->belongsTo('App\StatusProspect');
    }

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }
}
