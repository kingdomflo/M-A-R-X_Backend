<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MarxUser extends Model
{

  public function marx_user_relationship_type()
  {
    return $this->hasMany('App\MarxUserRelationshipType');
  }

  public function marx_relationship_type()
  {
    return $this->belongsToMany('App\MarxRelationshipType', 'marx_user_relationship_types', 'user_id', 'relationship_type_id');
  }
}