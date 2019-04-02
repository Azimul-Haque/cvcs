<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function user() {
      return $this->belongsTo('App\User', 'member_id', 'member_id');
    }

    public function payee() {
      return $this->belongsTo('App\User', 'payer_id', 'member_id');
    }

    public function paymentreceipts() {
      return $this->hasMany('App\Paymentreceipt');
    }
}
