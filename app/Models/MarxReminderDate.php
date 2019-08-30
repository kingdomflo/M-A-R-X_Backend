<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxReminderDate extends Model
{

  public function payment()
  {
    return $this->belongsTo('App\Models\MarxPayment')->with('relationship');
  }

}