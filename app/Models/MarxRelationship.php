<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MarxRelationship extends Model
{
  public function marx_user()
  {
    return $this->belongsTo('App\Models\MarxUser');
  }

  public function user_relationship_type()
  {
    return $this->hasOne('App\Models\MarxUserRelationshipType', 'id', 'user_relationship_type_id')->with('relationship_type');
  }


}