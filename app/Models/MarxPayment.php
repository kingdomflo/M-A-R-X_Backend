<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxPayment extends Model
{

  public function relationship()
  {
    return $this->hasOne('App\Models\MarxRelationship', 'id', 'relationship_id');
  }

  public function reminder_date()
  {
    return $this->belongsTo('App\Models\MarxReminderDate', 'id', 'payment_id');
  }

}