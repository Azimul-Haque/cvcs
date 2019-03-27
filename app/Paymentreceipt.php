<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentreceipt extends Model
{
    public function payment() {
      return $this->belongsTo('App\Payment');
    }
}
