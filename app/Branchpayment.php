<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branchpayment extends Model
{
    public function branch() {
      return $this->belongsTo('App\Branch', 'branch_id', 'id');
    }

    public function submitter() {
      return $this->belongsTo('App\User', 'submitter_id', 'id');
    }
}
