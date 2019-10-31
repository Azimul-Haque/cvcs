<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    public function users() {
      return $this->hasMany('App\User');
    }
}
