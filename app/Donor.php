<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    public function donations() {
      return $this->hasMany('App\Donation', 'donor_id', 'id');
    }
}
