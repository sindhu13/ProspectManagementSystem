<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\ProspectActivity;

class StatusProspect extends Model
{
    public function prospectActivity()
    {
        return $this->hasMany('App\ProspectActivity');
    }
}
