<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Easyperiodpost extends Model
{
    public function easyperiodpostreplies(){
        return $this->hasMany('App\Easyperiodpostreply');
    }
}
