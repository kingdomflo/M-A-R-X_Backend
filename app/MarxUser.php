<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxUser extends Model
{

  public function marx_user_relationship_type()
  {
    return $this->hasMany('App\MarxUserRelationshipType');
  }

  public function relationship_type()
  {
    return $this->belongsToMany('App\MarxRelationshipType', 'marx_user_relationship_types', 'user_id', 'relationship_type_id');
  }

  public function currencies()
  {
    return $this->belongsToMany('App\MarxCurrencies', 'marx_user_currencies', 'user_id', 'currencies_id');
  }

  public function marx_relationship()
  {
    return $this->hasMany('App\MarxRelationship','user_id')->with('marx_user_relationship_type');
  }
}