<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxUserCurrencies extends Model
{

  // public $id;
  // public $name;
  // public $label;

  public function currency()
  {
    return $this->hasOne('App\MarxCurrencies', 'id', 'currencies_id');
  }

}