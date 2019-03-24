<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function albumphotoes() {
      return $this->hasMany('App\Albumphoto');
    }
}
