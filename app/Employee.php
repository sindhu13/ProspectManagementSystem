<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\models\Departement;
use App\models\MarketingGroup;
use App\models\MarketingHasEmployee;
use App\models\SubBranch;
use App\models\User;

class Employee extends Model
{
    public function departement()
    {
        return $this->belongsTo('App\Departement');
    }

    public function subBranch()
    {
        return $this->belongsTo('App\SubBranch');
    }

    public function marketingGroup()
    {
        return $this->hasMany('App\MarketingGroup');
    }

    public function marketingHasEmployee()
    {
        return $this->hasMany('App\MarketingHasEmployee');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }
}
