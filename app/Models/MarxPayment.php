<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxPayment extends Model
{

  public function relationship()
  {
    return $this->hasOne('App\Models\MarxRelationship', 'id', 'relationshipId');
  }

  public function reminder_date()
  {
    return $this->belongsTo('App\Models\MarxReminderDate', 'id', 'paymentId');
  }

}