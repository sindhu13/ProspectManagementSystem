<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\MarketingHasEmployee;

class Target extends Model
{
    public function marketingHasEmployee()
    {
        return $this->belongsTo('App\MarketingHasEmployee')->orderBy('id', 'DESC');
    }
}
