<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxPayment extends Model
{

  public function relationship() {
    return $this->hasOne('App\Models\MarxRelationship', 'id', 'relationship_id');
  }

  public function user_currency() {
    return $this->hasOne('App\Models\MarxUserCurrencies', 'id', 'relationship_id')->with('currency');
  }

}