<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxReminderDate extends Model
{

  public function payment()
  {
    return $this->belongsTo('App\MarxPayment')->with('relationship')->with('user_currency');
  }

}