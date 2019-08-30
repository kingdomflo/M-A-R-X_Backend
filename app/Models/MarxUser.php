<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxUser extends Model
{

  public function marx_user_relationship_type()
  {
    return $this->hasMany('App\Models\MarxUserRelationshipType');
  }

  public function relationship_type()
  {
    return $this->belongsToMany('App\Models\MarxRelationshipType', 'marx_userRelationshipTypes', 'userId', 'relationshipTypeId');
  }

  public function marx_relationship()
  {
    return $this->hasMany('App\Models\MarxRelationship','userId')->with('marx_userRelationshipType');
  }
}