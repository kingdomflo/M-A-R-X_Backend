<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxRelationshipType extends Model 
{
  public function marx_user_relationship_type() {
    return $this->belongsToMany('App\Models\MarxUserRelationshipType');
  }

}