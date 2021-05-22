<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Easyperiodpostreply extends Model
{
    public function easyperiodpost(){
        return $this->belongsTo('App\Easyperiodpost');
    }
}
