<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function branchpayments() {
      return $this->hasMany('App\Branchpayment', 'branch_id', 'id');
    }
}
