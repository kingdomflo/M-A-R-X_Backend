<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxUserCurrencies extends Model
{

  // public $id;
  // public $name;
  // public $label;

  public function currency()
  {
    return $this->hasOne('App\Models\MarxCurrencies', 'id', 'currencies_id');
  }

}