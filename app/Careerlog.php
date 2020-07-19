<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Careerlog extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function branch(){
        return $this->belongsTo('App\Branch');
    }

    public function position(){
        return $this->belongsTo('App\Position');
    }
}
