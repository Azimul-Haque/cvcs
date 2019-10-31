<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	public function users() {
	  return $this->hasMany('App\User');
	}

	public function tempmemdatas() {
	  return $this->hasMany('App\Tempmemdata');
	}
	
    public $timestamps = false;
}
