<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxUser extends Model
{
  public function marx_relationship()
  {
    return $this->hasMany('App\MarxRelationship');
  }

  public function marx_relationship_type() {
    return $this->belongsToMany('App\MarxRelationshipType');
  }
}