<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxRelationshipType extends Model 
{
  public function marx_user() {
    return $this->belongsToMany('App\User');
  }

  public function marx_relationship() {
    return $this->hasMany('App\MarxRelationship');
  }
}