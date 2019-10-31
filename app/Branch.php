<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function branchpayments() {
      return $this->hasMany('App\Branchpayment', 'branch_id', 'id');
    }

    public function users() {
      return $this->hasMany('App\User');
    }

    public function tempmemdatas() {
      return $this->hasMany('App\Tempmemdata');
    }

    public $timestamps = false;
}
