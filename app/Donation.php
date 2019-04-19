<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    public function donor() {
      return $this->belongsTo('App\Donor', 'donor_id', 'id');
    }

    public function submitter() {
      return $this->belongsTo('App\User', 'submitter_id', 'id');
    }
}
