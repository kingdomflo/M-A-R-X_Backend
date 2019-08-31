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
    return $this->belongsToMany('App\Models\MarxRelationshipType', 'marx_user_relationship_types', 'user_id', 'relationship_type_id');
  }

  public function marx_relationship()
  {
    return $this->hasMany('App\Models\MarxRelationship','user_id')->with('marx_user_relationship_type');
  }
}