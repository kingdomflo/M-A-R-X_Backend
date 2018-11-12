<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxPayment extends Model
{

  public function relationship() {
    return $this->hasOne('App\MarxRelationship', 'id', 'relationship_id');
  }

  public function user_currency() {
    return $this->hasOne('App\MarxUserCurrencies', 'id', 'relationship_id')->with('currency');
  }

}